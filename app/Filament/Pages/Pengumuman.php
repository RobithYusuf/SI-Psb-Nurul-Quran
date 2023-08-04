<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Models\seleksi;
use Filament\Pages\Page;
use App\Models\Exam\Result;
use App\Models\Pendaftaran;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Filament\Forms;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Pages\Actions;

class Pengumuman extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static function getNavigationGroup(): ?string
    {
        $user = Auth::user();

        if ($user && $user->hasRole('santri')) {
            return __('Laporan Pengumuman Kelulusan');
        } else {
            return __('Data Pengelolaan');
        }
    }

    protected static ?int $navigationSort = -3;

    protected static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        if (!$user->hasRole('santri')) {
            return true;
        }
        $exam_result = Result::where('user_id', $user->id)->first();
        if ($exam_result && $exam_result->score >= '10') {
            return true;
        }
        return false;
    }

    protected static ?string $title = 'Pengumuman Seleksi';

    protected static string $view = 'filament.pages.pengumuman';

    public $seleksi;

    // // Buat property untuk menyimpan data seleksi
    public function mount()
    {
        // Jika user yang login memiliki peran 'santri'
        if (Auth::user()->hasRole('santri')) {
            // Dapatkan hasil yang berkaitan dengan user yang login
            // dan load data seleksi yang berkaitan
            $pendaftaran = Pendaftaran::where('user_id', Auth::id())->first();
            $exam_results = Result::where('user_id', Auth::id())->first();
            $this->seleksi = Result::where('user_id', Auth::id())->with('seleksi')->get();
            $this->seleksi->pendaftaran = $pendaftaran;
            $this->seleksi->exam_results = $exam_results;
        } else {
            // Jika user memiliki peran lain, dapatkan semua hasil
            // dan load data seleksi yang berkaitan
            $this->seleksi = Result::with('seleksi')->get();
        }
    }

    protected function getActions(): array
    {
        return [
            Actions\Action::make('download_pengumuman')
                ->label('Download Pengumuman')
                ->hidden(!auth()->user()->hasRole('santri'))
                ->action(function () {
                    // Pastikan bahwa user memiliki pendaftaran
                    if (!auth()->user()->pendaftaran) {
                        return back()->withErrors(['message' => 'User tidak memiliki pendaftaran']);
                    }

                    $filename = 'Pengumuman_' . now()->toDateTimeString() . '.pdf';

                    // Dapatkan data pendaftaran
                    $pendaftaran = auth()->user()->pendaftaran;
                    $result = auth()->user()->result;
                    $seleksi = $result ? $result->seleksi : null;

                    // Jika seleksi tidak ditemukan, kembali ke halaman sebelumnya dengan pesan kesalahan
                    if (!$seleksi) {
                        return back()->withErrors(['message' => 'Seleksi tidak ditemukan untuk user ini.']);
                    }

                    $pdf = PDF::loadView('pdf_pengumuman', [
                        'pendaftaran' => $pendaftaran,
                        'seleksi' => $seleksi,
                    ])->output();

                    return response()->streamDownload(fn () => print($pdf), $filename);
                }),



            Actions\Action::make('export')
                ->label('Print PDF')
                ->icon('heroicon-s-document-download')
                ->hidden(auth()->user()->hasRole('santri'))
                ->form([
                    Forms\Components\DatePicker::make('dari')->required(),
                    Forms\Components\DatePicker::make('hingga')->required()
                        ->default(function () {
                            return Carbon::now();
                        }),
                ])
                ->action(function (array $data) {
                    $filename = 'Laporan Data Pengumuman' . now()->toDateTimeString() . '.pdf';

                    // query untuk mengambil semua pengumuman antara tanggal yang diberikan
                    $pengumumanRecords = Seleksi::whereBetween('tanggal_pengumuman', [$data['dari'], $data['hingga']])
                        ->join('exam_results', 'seleksi.result_id', '=', 'exam_results.id')
                        ->join('users', 'exam_results.user_id', '=', 'users.id')
                        ->select('seleksi.*', 'exam_results.score', 'users.name')
                        ->get();

                    // menghitung total row yang di tampilkan
                    $totalRows = $pengumumanRecords->count();

                    $pdf = PDF::loadView('pdf_pengumuman_penerimaan_santri', [
                        'records' => $pengumumanRecords,
                        'totalRows' => $totalRows,
                        'dari' => $data['dari'],
                        'hingga' => $data['hingga']
                    ])->output();

                    return response()->streamDownload(fn () => print($pdf), $filename);
                }),
        ];
    }
}
