<?php

namespace App\Filament\Resources\Exam\SessionResource\Pages;

use App\Filament\Resources\Exam\SessionResource;
use App\Models\Exam\Result;
use App\Models\Exam\Session;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class ExamPage extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    use InteractsWithRecord;

    protected static string $resource = SessionResource::class;

    protected static string $view = 'filament.resources.exam.session-resource.pages.exam-page';

    protected int $duration;

    protected Result $result;

    public Session $exam;

    public int $startedAt;

    public int $shouldEndAt;

    public Collection $questions;

    public function mount(): void
    {
        $exam = $this->resolveRecord($this->record);

        abort_if(!$exam, 404);

        // bisa disesuaikan sendiri
        abort_if(
            Result::where('user_id', auth()->id())
                ->where('exam_session_id', $exam->id)
                ->first(),
            403,
            'Anda telah mengambil Ujian ini sebelumnya.'
        );

        // Untuk keperluan form->getState() harus ada public property tiap soal
        foreach ($exam->questions as $property) {
            $this->{'q_'.$property->id} = null;
        }

        $this->exam = $exam;
        $this->duration = $exam->duration * 60; // menit ke detik
        $this->questions = $exam->questions;

        // simpan waktu di user session
        if (!session()->exists('exam_'.$exam->id)) {
            session(['exam_'.$exam->id => time()]);
        }

        $this->startedAt = session('exam_'.$exam->id);
        $this->shouldEndAt = $this->startedAt + $this->duration;

        // bisa disesuaikan sendiri
        abort_if($this->shouldEndAt - time() <= 0, 403, 'Waktu Anda untuk ujian ini telah habis.');
    }

    protected function getTitle(): string|Htmlable
    {
        return $this->exam->title;
    }

    protected function getSubheading(): string|Htmlable|null
    {
        return new HtmlString($this->exam->description);
    }

    protected function getFormSchema(): array
    {
        if (!$this->questions) {
            return [];
        }

        $questions = $this->questions->sortBy('sort');

        $questionFields = [];

        foreach ($questions as $question) {
            $questionFields[] =
                Forms\Components\Card::make([
                    Forms\Components\Placeholder::make(Str::uuid())
                        ->disableLabel()
                        ->content(new HtmlString($question->question)),
                    Forms\Components\Radio::make('q_'.$question->id)
                        ->disableLabel()
                        ->options(function () use ($question) {
                            $options = [];
                            foreach ($question->options as $value) {
                                $options[$value['option']] = $value['option'];
                            }

                            return $options;
                        })
                ]);
        }

        return $questionFields;
    }

    protected function processAnswers(array $answers): array
    {
        $questions = $this->questions;
        $score = 0;

        $details = [];
        foreach ($answers as $key => $value) {
            $question = $questions->find(str($key)->after('_')->toString());
            $options = $question->options;
            $points = $question->points;

            $isCorrect = false;
            foreach ($options as $item) {
                if ($item['option'] === $value) {
                    $score += $item['is_correct'] ? $points  : 0;
                    $isCorrect = $item['is_correct'] ? true : false;
                    break;
                }
            }

            $details[] = [
                'question' => $question->question,
                'answer' => $value,
                'result' => $isCorrect,
            ];
        }

        return ['score' => $score, 'details' => $details];
    }

    public function submit()
    {
        // validasi +30 detik utk kompensasi koneksi dll
        if (time() > ($this->shouldEndAt + 30)) {
            Notification::make('thanks')
                ->title('Waktu ujian telah berakhir.')
                ->danger()
                ->send();

            $this->redirect(static::getResource()::getUrl('index'));

            return;
        }

        $answers = $this->form->getState();

        $result = $this->processAnswers($answers);

        $this->exam->results()->create([
            'user_id' => auth()->id(),
            'score' => $result['score'],
            'started_at' => Carbon::parse($this->startedAt),
            'answers' => $result['details'],
            'completed_at' => now(),
        ]);

        session()->forget('exam_'.$this->exam->id);

        Notification::make('thanks')
            ->title('Terima kasih')
            ->body('Jawaban Anda telah kami terima, harap tunggu pengumuman berikutnya.')
            ->success()
            ->send();

        $this->redirect(static::getResource()::getUrl('index'));
    }
}
