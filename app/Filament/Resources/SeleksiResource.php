<?php

namespace App\Filament\Resources;

use Closure;
use Carbon\Carbon;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Seleksi;
use App\Models\Exam\Result;
use App\Models\Pendaftaran;
use App\Models\Exam\Session;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use App\Filament\Resources\SeleksiResource\Pages;

class SeleksiResource extends Resource
{
    protected static ?string $model = Seleksi::class;


    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';

    protected static ?string $navigationGroup = 'Data Pengelolaan';

    protected static ?int $navigationSort = -3;

    protected static ?string $modelLabel = 'Seleksi';

    protected static ?string $slug = 'seleksi';

    // public static function getCleanOptionString(Pendaftaran $pendaftaran): string
    // {
    //     return htmlspecialchars("[{$pendaftaran->id}] {$pendaftaran->nik} ({$pendaftaran->nama})");
    // }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Select::make('pendaftaran_id')
                // ->label('Id Pendaftar')
                // ->placeholder('Pilih Id Pendaftar')
                // ->options(Pendaftaran::query()
                // ->pluck('id', 'id'))
                // ->required(),
                Forms\Components\Card::make()
                    ->schema([
                        // Select::make('pendaftaran_id')
                        //     ->label('Id Pendaftar')
                        //     ->placeholder('Pilih Id Pendaftar')
                        //     ->options(function () {
                        //         $pendaftaran = Pendaftaran::where('status_pendaftaran', 'lengkap')->get();
                        //         return $pendaftaran->mapWithKeys(function ($pendaftaran) {
                        //             return [$pendaftaran->getKey() => SeleksiResource::getCleanOptionString($pendaftaran)];
                        //         })->toArray();
                        //     })
                        //     ->getOptionLabelUsing(function ($value): string {
                        //         $pendaftaran = Pendaftaran::find($value);
                        //         return SeleksiResource::getCleanOptionString($pendaftaran);
                        //     })->searchable()
                        //     ->required(),
                        Select::make('result_id')
                            ->label('Hasil Nilai Ujian')
                            ->placeholder('Pilih Hasil Ujian')
                            ->options(function () {
                                // mengambil semua result_id dari tabel seleksi
                                $selectedResultIds = Seleksi::pluck('result_id')->toArray();
                                // mengambil data hasil ujian dengan score >= 70 dan result_id belum dipilih di tabel seleksi
                                $results = Result::where('score', '>=', 10)
                                    ->whereNotIn('id', $selectedResultIds)  // ini akan memastikan bahwa result_id belum dipilih
                                    ->get();
                                return $results->mapWithKeys(function ($result) {
                                    $user = User::find($result->user_id);
                                    return [$result->getKey() => $user->name . ', Score: ' . $result->score];
                                })->toArray();
                            })
                            ->getOptionLabelUsing(function ($value): string {
                                $result = Result::find($value);
                                $user = User::find($result->user_id);
                                return $user->name . ', Score: ' . $result->score;
                            })->searchable()
                            ->required()
                            ->reactive()

                            ->afterStateUpdated(function (Closure $set, $state, $get) {
                                $hasil = Result::find($state);
                                $nilai_test = $hasil ? $hasil->score : null;
                                $set('nilai_test', $nilai_test);

                                // Dapatkan nilai-nilai lainnya.
                                $nilai_wawancara = $get('nilai_wawancara');
                                $nilai_btq = $get('nilai_btq');

                                // Hitung total nilai.
                                $total = $nilai_test * 0.4 + $nilai_wawancara * 0.3 + $nilai_btq * 0.3;
                                $set('total_nilai', $total);

                                // Set status seleksi berdasarkan total nilai.
                                $status = ($total >= 75) ? 'LOLOS' : 'TIDAK LOLOS';
                                $set('status_seleksi', $status);
                            }),
                        Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('nilai_test')
                                    ->numeric()
                                    ->label('Nilai Test Pendaftar (Otomatis)')
                                    ->maxLength(100)
                                    ->disabled()
                                    ->required()
                                    ->helperText('Score Ujian')
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, $get, $set) {
                                        if ($get('nilai_wawancara') && $get('nilai_btq')) {
                                            $total = $state * 0.4 + $get('nilai_wawancara') * 0.3 + $get('nilai_btq') * 0.3;
                                            $set('total_nilai', $total);

                                            $status = ($total >= 75) ? 'LOLOS' : 'TIDAK LOLOS';
                                            $set('status_seleksi', $status);
                                        }
                                    }),
                                Forms\Components\TextInput::make('nilai_wawancara')
                                    ->numeric()
                                    ->maxLength(100)
                                    ->required()
                                    ->helperText('Hasil Wawancara')
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, $get, $set) {
                                        $total = $get('nilai_test') * 0.4 + $state * 0.3 + $get('nilai_btq') * 0.3;
                                        $set('total_nilai', $total);

                                        $status = ($total >= 75) ? 'LOLOS' : 'TIDAK LOLOS';
                                        $set('status_seleksi', $status);
                                    }),
                                Forms\Components\TextInput::make('nilai_btq')
                                    ->numeric()
                                    ->maxLength(100)
                                    ->required()
                                    ->label('Nilai Baca Tulis Al-Quran')
                                    ->helperText('Hasil BTQ')
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, $get, $set) {
                                        $total = $get('nilai_test') * 0.4 + $get('nilai_wawancara') * 0.3 + $state * 0.3;
                                        $set('total_nilai', $total);

                                        $status = ($total >= 75) ? 'LOLOS' : 'TIDAK LOLOS';
                                        $set('status_seleksi', $status);
                                    }),
                            ]),
                    ]),
                Forms\Components\Section::make('Hasil Seleksi (Otomatis)')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('total_nilai')
                                    ->disabled()
                                    ->label('Total Nilai (Otomatis)')
                                    ->helperText('Hasil Nilai Akhir, (Kelulusan => 75)'),

                                Forms\Components\TextInput::make('status_seleksi')
                                    ->disabled()
                                    ->label('Status Seleksi (Otomatis)')
                                    ->helperText('Status LOLOS dan TIDAK LOLOS')
                            ]),
                    ]),
                Forms\Components\Section::make('Tanggal Pengumuman')
                    ->schema([

                        Forms\Components\DatePicker::make('tanggal_pengumuman')
                            ->default(function () {
                                return Carbon::now()->addWeek();
                            })
                            ->required()
                            ->label('Tanggal Pengumuman')
                            ->helperText('Hasil pengumuman akan bsia di akses sesuai tanggal pengumuman'),

                    ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('result.user.name')
                    ->label('Pendaftar (Users)'),

                Tables\Columns\TextColumn::make('total_nilai')->label('Nilai Akhir'),
                Tables\Columns\BadgeColumn::make('status_seleksi')
                    ->colors([
                        'success' => 'LOLOS',
                        'danger' => 'TIDAK LOLOS',
                    ]),
                Tables\Columns\TextColumn::make('tanggal_pengumuman'),
                Tables\Columns\TextColumn::make('berkas_hasil_pendaftaran'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(''),
                Tables\Actions\DeleteAction::make()
                    ->label('')
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeleksis::route('/'),
            'create' => Pages\CreateSeleksi::route('/create'),
            'edit' => Pages\EditSeleksi::route('/{record}/edit'),
        ];
    }
}
