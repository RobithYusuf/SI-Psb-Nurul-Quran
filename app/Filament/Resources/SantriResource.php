<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Kamar;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\Seleksi;
use App\Models\Pendaftaran;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\SantriResource\Pages;
use App\Filament\Resources\SantriResource\Widgets\SantriStatsOverview;

class SantriResource extends Resource
{
    protected static ?string $model = Santri::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $modelLabel = 'Santri';

    protected static ?string $slug = 'santri';

    public static function getCleanOptionString(Pendaftaran $pendaftaran): string
    {
        return htmlspecialchars("[{$pendaftaran->id}] {$pendaftaran->nik} ({$pendaftaran->nama})");
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Data Diri')
                            ->schema([

                                // Select::make('kamar_id')
                                //     ->label('Kamar')
                                //     ->placeholder('Pilih Kamar')
                                //     ->options(Kamar::query()
                                //         ->pluck('nama_kamar', 'id'))
                                //     ->default(Kamar::query()->inRandomOrder()->first()->id)
                                //     ->required(),

                                Select::make('kamar_id')
                                    ->label('Kamar')
                                    ->placeholder('Pilih Kamar')
                                    ->options(function () {
                                        return Kamar::all()->mapWithKeys(function ($kamar) {
                                            return [$kamar->id => $kamar->nama_kamar . ' (jumlah santri = ' . $kamar->jumlah_santri . ')'];
                                        })->toArray();
                                    })
                                    ->default(Kamar::query()->inRandomOrder()->first()->id)
                                    ->required(),

                                Select::make('kelas_id')
                                    ->label('Kelas')
                                    ->placeholder('Pilih Kelas')
                                    ->options(function () {
                                        return Kelas::all()->mapWithKeys(function ($kelas) {
                                            return [$kelas->id => "{$kelas->nama_kelas} (jumlah santri = {$kelas->jumlah_santri})"];
                                        })->toArray();
                                    })
                                    ->default(Kelas::query()->inRandomOrder()->first()->id)
                                    ->required(),

                                Grid::make(1)
                                    ->schema([

                                        // Select::make('pendaftaran_id')
                                        //     ->label('Id Pendaftar')
                                        //     ->placeholder('Pilih Id Pendaftaran')
                                        //     ->options(function () {
                                        //         // mendapatkan id pendaftaran yang sudah digunakan
                                        //         $usedIds = Santri::pluck('pendaftaran_id')->toArray();
                                        //         // mengambil data pendaftaran dengan status 'lengkap' dan belum digunakan
                                        //         $pendaftaran = Pendaftaran::where('status_pendaftaran', 'lengkap')
                                        //             ->whereNotIn('id', $usedIds)
                                        //             ->get();

                                        //         return $pendaftaran->mapWithKeys(function ($pendaftaran) {
                                        //             return [$pendaftaran->getKey() => SantriResource::getCleanOptionString($pendaftaran)];
                                        //         })->toArray();
                                        //     })
                                        //     ->getOptionLabelUsing(function ($value): string {
                                        //         $pendaftaran = Pendaftaran::find($value);
                                        //         return SantriResource::getCleanOptionString($pendaftaran);
                                        //     })
                                        //     ->searchable()
                                        //     ->required()
                                        //     ->reactive()
                                        //     ->afterStateUpdated(function (Closure $set, $state) {
                                        //         $daftar = Pendaftaran::find($state);
                                        //         $set('nik', $daftar ? $daftar->nik : null);
                                        //         $set('nama', $daftar ? $daftar->nama : null);
                                        //         $set('tempat_lahir', $daftar ? $daftar->tempat_lahir : null);
                                        //         $set('tanggal_lahir', $daftar ? $daftar->tanggal_lahir : null);
                                        //         $set('jenis_kelamin', $daftar ? $daftar->jenis_kelamin : null);
                                        //         $set('alamat', $daftar ? $daftar->alamat : null);
                                        //         $set('no_hp', $daftar ? $daftar->no_hp : null);
                                        //         $set('email', $daftar ? $daftar->email : null);
                                        //         $set('nama_wali', $daftar ? $daftar->nama_wali : null);
                                        //         $set('alamat_wali', $daftar ? $daftar->alamat_wali : null);
                                        //         $set('no_hp_wali', $daftar ? $daftar->no_hp_wali : null);
                                        //         $set('pekerjaan', $daftar ? $daftar->pekerjaan : null);
                                        //         $set('gaji_wali', $daftar ? $daftar->gaji_wali : null);
                                        //         $set('kartu_keluarga', $daftar ? $daftar->kartu_keluarga : null);
                                        //         $set('akta_kelahiran', $daftar ? $daftar->akta_kelahiran : null);
                                        //         $set('ijazah_terakhir', $daftar ? $daftar->ijazah_terakhir : null);
                                        //     }),

                                        // ]),
                                        Select::make('pendaftaran_id')
                                            ->label('Id Pendaftar')
                                            ->placeholder('Pilih Id Pendaftaran')
                                            ->options(function () {
                                                // mendapatkan id pendaftaran yang sudah digunakan
                                                $usedIds = Santri::pluck('pendaftaran_id')->toArray();
                                                // mengambil data pendaftaran dengan status 'lengkap' dan belum digunakan
                                                $pendaftaran = Pendaftaran::where('status_pendaftaran', 'lengkap')
                                                    ->whereHas('user.result.seleksi', function ($query) {
                                                        $query->where('status_seleksi', 'LOLOS');
                                                    })
                                                    ->whereNotIn('id', $usedIds)
                                                    ->get();

                                                return $pendaftaran->mapWithKeys(function ($pendaftaran) {
                                                    return [$pendaftaran->getKey() => SantriResource::getCleanOptionString($pendaftaran)];
                                                })->toArray();
                                            })
                                            ->getOptionLabelUsing(function ($value): string {
                                                $pendaftaran = Pendaftaran::find($value);
                                                return SantriResource::getCleanOptionString($pendaftaran);
                                            })
                                            ->searchable()
                                            ->required()
                                            ->reactive()
                                            ->afterStateUpdated(function (Closure $set, $state) {
                                                $daftar = Pendaftaran::find($state);
                                                $set('nik', $daftar ? $daftar->nik : null);
                                                $set('nama', $daftar ? $daftar->nama : null);
                                                $set('tempat_lahir', $daftar ? $daftar->tempat_lahir : null);
                                                $set('tanggal_lahir', $daftar ? $daftar->tanggal_lahir : null);
                                                $set('jenis_kelamin', $daftar ? $daftar->jenis_kelamin : null);
                                                $set('alamat', $daftar ? $daftar->alamat : null);
                                                $set('no_hp', $daftar ? $daftar->no_hp : null);
                                                $set('email', $daftar ? $daftar->email : null);
                                                $set('nama_wali', $daftar ? $daftar->nama_wali : null);
                                                $set('alamat_wali', $daftar ? $daftar->alamat_wali : null);
                                                $set('no_hp_wali', $daftar ? $daftar->no_hp_wali : null);
                                                $set('pekerjaan', $daftar ? $daftar->pekerjaan : null);
                                                $set('gaji_wali', $daftar ? $daftar->gaji_wali : null);
                                                $set('kartu_keluarga', $daftar ? $daftar->kartu_keluarga : null);
                                                $set('akta_kelahiran', $daftar ? $daftar->akta_kelahiran : null);
                                                $set('ijazah_terakhir', $daftar ? $daftar->ijazah_terakhir : null);
                                            }),
                                    ]),


                            ])->columns(2),
                        Forms\Components\Section::make('Data Diri (Otomatis)')
                            ->schema([
                                Forms\Components\TextInput::make('nik')
                                    ->maxLength(50)
                                    ->disabled()
                                    ->label('NIK'),
                                Forms\Components\TextInput::make('nama')
                                    ->maxLength(50)
                                    ->disabled(),
                                Forms\Components\TextInput::make('tempat_lahir')
                                    ->maxLength(50)
                                    ->disabled(),
                                Forms\Components\DatePicker::make('tanggal_lahir'),
                                Radio::make('jenis_kelamin')
                                    ->options([
                                        'Laki-laki' => 'Laki-laki',
                                        'Perempuan' => 'Perempuan',
                                    ]),

                                Forms\Components\TextInput::make('alamat')
                                    ->maxLength(100)
                                    ->disabled(),
                                Forms\Components\TextInput::make('no_hp')
                                    ->maxLength(20)
                                    ->disabled(),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->maxLength(20)
                                    ->disabled(),
                                Forms\Components\TextInput::make('nama_wali')
                                    ->maxLength(50)
                                    ->disabled(),
                                Forms\Components\TextInput::make('alamat_wali')
                                    ->maxLength(100)
                                    ->disabled(),
                                Forms\Components\TextInput::make('no_hp_wali')
                                    ->maxLength(20)
                                    ->disabled(),
                                Forms\Components\TextInput::make('pekerjaan')
                                    ->maxLength(30)
                                    ->disabled(),
                                Forms\Components\TextInput::make('gaji_wali')
                                    ->maxLength(50)
                                    ->disabled(),
                                Forms\Components\TextInput::make('kartu_keluarga')->disabled(),
                                Forms\Components\TextInput::make('akta_kelahiran')->disabled(),
                                Forms\Components\TextInput::make('ijazah_terakhir')->disabled(),
                            ])->columns(2)
                    ])->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('index')->label('No')->rowIndex(),
                Tables\Columns\IconColumn::make('kartu_keluarga')
                    ->options([
                        'heroicon-o-x-circle',
                        'heroicon-o-check-circle' => fn ($state, $record): bool => $record->kartu_keluarga === 'uploads/Kartu_Keluarga.pdf',
                    ])
                    ->color(fn ($record): string => $record->kartu_keluarga === 'uploads/Kartu_Keluarga.pdf' ? 'success' : 'danger')
                    ->url(fn ($record) => Storage::url($record->kartu_keluarga)),

                Tables\Columns\IconColumn::make('akta_kelahiran')
                    ->options([
                        'heroicon-o-x-circle',
                        'heroicon-o-check-circle' => fn ($state, $record): bool => $record->akta_kelahiran === 'uploads/Akta_Kelahiran.pdf',
                    ])
                    ->color(fn ($record): string => $record->akta_kelahiran === 'uploads/Akta_Kelahiran.pdf' ? 'success' : 'danger')
                    ->url(fn ($record) => Storage::url($record->akta_kelahiran)),

                Tables\Columns\IconColumn::make('ijazah_terakhir')
                    ->options([
                        'heroicon-o-x-circle',
                        'heroicon-o-check-circle' => fn ($state, $record): bool => $record->ijazah_terakhir === 'uploads/Ijazah_Terakhir.pdf',
                    ])
                    ->color(fn ($record): string => $record->ijazah_terakhir === 'uploads/Ijazah_Terakhir.pdf' ? 'success' : 'danger')
                    ->url(fn ($record) => Storage::url($record->ijazah_terakhir)),
                Tables\Columns\TextColumn::make('kamar.nama_kamar')->label(' Kamar')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('kelas.nama_kelas')->label(' Kelas')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nik'),
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('tempat_lahir'),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date(),
                Tables\Columns\TextColumn::make('jenis_kelamin'),
                Tables\Columns\TextColumn::make('alamat'),
                Tables\Columns\TextColumn::make('no_hp'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('nama_wali'),
                Tables\Columns\TextColumn::make('alamat_wali'),
                Tables\Columns\TextColumn::make('no_hp_wali'),
                Tables\Columns\TextColumn::make('pekerjaan'),
                Tables\Columns\TextColumn::make('gaji_wali'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(''),
                Tables\Actions\EditAction::make()
                    ->label(''),
                Tables\Actions\DeleteAction::make()
                    ->label('')
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    // public static function getWidgets(): array
    // {
    //     return[
    //         SantriStatsOverview::class,
    //     ];
    // }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSantris::route('/'),
            'create' => Pages\CreateSantri::route('/create'),
            'edit' => Pages\EditSantri::route('/{record}/edit'),
        ];
    }
}
