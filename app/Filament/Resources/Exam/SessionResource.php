<?php

namespace App\Filament\Resources\Exam;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pendaftaran;
use App\Models\Exam\Session;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Exam\SessionResource\Pages;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\Exam\SessionResource\RelationManagers;

class SessionResource extends Resource
{
    protected static ?string $model = Session::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $modelLabel = 'Ujian';

    protected static ?int $navigationSort = -4;

    protected static function getNavigationGroup(): ?string
    {
        $user = Auth::user();

        if ($user && $user->hasRole('santri')) {
            return __('Ujian');
        } else {
            return __('Data Pengelolaan');
        }
    }

    protected static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        // jika pengguna belum diautentikasi, tidak menampilkan halaman
        if (!$user) {
            return false;
        }
        // jika pengguna memiliki peran selain 'santri', menampilkan halaman
        if (!$user->hasRole('santri')) {
            return true;
        }
        // untuk pengguna dengan peran 'santri', cek status pendaftaran
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();
        if ($pendaftaran && $pendaftaran->status_pendaftaran === 'lengkap') {
            return true;  // menampilkan halaman jika status pendaftaran adalah 'lengkap'
        }
        return false;  // tidak menampilkan halaman untuk pengguna 'santri' dengan status pendaftaran lainnya
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Nama Ujian')
                    ->inlineLabel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->inlineLabel()
                    ->rows(3)
                    ->maxLength(255),
                Forms\Components\TextInput::make('minimum_score')
                    ->label('Nilai Minimum Kelulusan')
                    ->inlineLabel()
                    ->extraAttributes(['style' => 'max-width: 200px'])
                    ->default(30)
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('duration')
                    ->label('Durasi Ujian')
                    ->inlineLabel()
                    ->suffix('menit')
                    ->extraAttributes(['style' => 'max-width: 200px'])
                    ->default(30)
                    ->numeric()
                    ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Ujian'),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Durasi')
                    ->suffix(' menit'),
                Tables\Columns\TextColumn::make('results_count')
                    ->label('Peserta')
                    ->counts('results')
                    ->toggleable()
                    ->hidden(auth()->user()->hasRole('santri')),
                Tables\Columns\TextColumn::make('results_avg_score')
                    ->label('Rata-Rata Nilai')
                    ->avg('results', 'score')
                    ->formatStateUsing(fn ($state) => round($state, 2))
                    ->toggleable()
                    ->hidden(auth()->user()->hasRole('santri')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->hidden(auth()->user()->hasRole('santri')),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->dateTime()
                    ->hidden(auth()->user()->hasRole('santri')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->hidden(auth()->user()->hasRole('santri')),
                Tables\Actions\EditAction::make()->hidden(auth()->user()->hasRole('santri')),
                Tables\Actions\Action::make('clear_session')
                    ->label('Clear Session (dev)')
                    ->action(fn ($record) => session()->forget('exam_' . $record->id))
                    ->hidden(auth()->user()->hasRole('santri')),
                Tables\Actions\Action::make('take_exam')
                    ->label('Mulai Ujian')
                    ->color('success')
                    ->icon('heroicon-s-paper-airplane')
                    ->modalWidth('md')
                    ->centerModal()
                    ->modalHeading('Perhatian')
                    ->modalSubheading(fn ($record) => 'Durasi untuk ujian ini adalah ' . $record->duration . ' menit dan akan berjalan setelah Anda klik tombol Lanjutkan.')
                    ->modalButton('Lanjutkan')
                    ->action(fn ($record) => redirect(static::getUrl('take', $record->id))),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\QuestionsRelationManager::class,
            RelationManagers\ResultsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSessions::route('/'),
            'create' => Pages\CreateSession::route('/create'),
            'view' => Pages\ViewSession::route('/{record}'),
            'edit' => Pages\EditSession::route('/{record}/edit'),
            'take' => Pages\ExamPage::route('/{record}/take'),
        ];
    }
}
