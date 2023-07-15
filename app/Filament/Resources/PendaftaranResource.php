<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pendaftaran;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Livewire\TemporaryUploadedFile;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\PendaftaranResource\Pages;

class PendaftaranResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    // protected static ?string $navigationGroup = 'Data Pengelolaan';

    protected static function getNavigationGroup(): ?string
    {
        $user = Auth::user();

        if ($user && $user->hasRole('santri')) {
            return __('Data Pendaftaraan');
        } else {
            return __('Data Pengelolaan');
        }
    }

    protected static ?string $modelLabel = 'Pendaftaran';
    protected static ?int $navigationSort = -5;
    protected static ?string $slug = 'pendaftaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        // Card::make()
                        //     ->schema([
                        Forms\Components\Section::make('Data Diri')
                            ->schema([
                                Forms\Components\TextInput::make('nik')
                                    ->maxLength(16)->numeric()->label('NIK'),
                                Forms\Components\TextInput::make('nama')
                                    ->maxLength(50)
                                    ->helperText('Nama terisi otomatis sesuai dengan user login!')
                                    ->disabled()
                                    ->default(fn () => auth()->user()->name),
                                Forms\Components\TextInput::make('tempat_lahir')
                                    ->maxLength(50),
                                Forms\Components\DatePicker::make('tanggal_lahir'),
                                Radio::make('jenis_kelamin')
                                    ->options([
                                        'Laki-laki' => 'Laki-laki',
                                        'Perempuan' => 'Perempuan',
                                    ]),
                                Forms\Components\TextInput::make('alamat')
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('no_hp')
                                    ->maxLength(15)->numeric(),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->maxLength(20),
                                // ])->columns(2),
                            ])->columns(2)->collapsible(),
                    ])->columnSpan('full'),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Data Wali')
                            ->schema([
                                Forms\Components\TextInput::make('nama_wali')
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('alamat_wali')
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('no_hp_wali')
                                    ->maxLength(15)->numeric(),
                                Forms\Components\TextInput::make('pekerjaan')
                                    ->maxLength(30),
                                Select::make('gaji_wali')
                                    ->placeholder('Pilih Nominal')
                                    ->options([
                                        '≤1000000' => '≤ Rp.1000.000',
                                        '1000000-2000000' => 'Rp.1,000,000-Rp.2,000,000',
                                        '2000000-3000000' => 'Rp.2,000,000-Rp.3,000,000',
                                        '3000000-4000000' => 'Rp.3,000,000-Rp.4,000,000',
                                        '4000000-5000000' => 'Rp.4,000,000-Rp.5,000,000',
                                        '5000000' => '≥ 5,000,000 ',

                                    ])->columnSpan('full'),
                            ])->columns(2)->collapsible(),
                    ])->columnSpan('full'),
                // SpatieMediaLibraryFileUpload::make('kartu_keluarga')
                //     ->enableDownload()
                //     ->enableOpen()
                //     ->multiple()
                //     ->columnSpanFull()
                //     ->preserveFilenames(),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Upload File')
                            ->schema([
                                FileUpload::make('kartu_keluarga')
                                    ->directory('uploads')
                                    ->enableOpen()
                                    ->visibility('public')
                                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                        return 'Kartu_Keluarga.' . $file->getClientOriginalExtension();
                                    }),

                                FileUpload::make('akta_kelahiran')
                                    ->directory('uploads')
                                    ->enableOpen()
                                    ->visibility('public')
                                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                        return 'Akta_Kelahiran.' . $file->getClientOriginalExtension();
                                    }),

                                FileUpload::make('ijazah_terakhir')
                                    ->directory('uploads')
                                    ->enableOpen()
                                    ->visibility('public')
                                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                        return 'Ijazah_Terakhir.' . $file->getClientOriginalExtension();
                                    }),
                            ])->columns(2)->collapsible(),
                    ])->columnSpan('full'),

                Forms\Components\Section::make('Status Pendaftaran')
                    ->schema([
                        Radio::make('status_pendaftaran')
                            ->options([
                                'tidak lengkap' => 'Tidak Lengkap',
                                'lengkap' => 'Lengkap',
                            ])
                            ->descriptions([
                                'tidak lengkap' => 'Berkas Tidak Lengkap',
                                'lengkap' => 'Berkas Sudah lengkap',
                            ])->required()
                    ])->columnSpan('full')
                    ->hidden(auth()->user()->hasRole('santri')),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BadgeColumn::make('status_pendaftaran')
                ->colors([
                    'primary',
                    'success' => 'lengkap',
                    'danger' => 'tidak lengkap',
                ])->sortable(),
                Tables\Columns\TextColumn::make('nik')
                    ->hidden(fn ($record) => auth()->user()->role == 'santri'),
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir'),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date(),
                Tables\Columns\TextColumn::make('jenis_kelamin'),
                Tables\Columns\TextColumn::make('alamat'),
                Tables\Columns\TextColumn::make('no_hp'),
                Tables\Columns\TextColumn::make('email')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('nama_wali'),
                Tables\Columns\TextColumn::make('alamat_wali'),
                Tables\Columns\TextColumn::make('no_hp_wali'),
                Tables\Columns\TextColumn::make('pekerjaan'),
                Tables\Columns\TextColumn::make('gaji_wali'),


                // SpatieMediaLibraryImageColumn::make('kartu_keluarga'),

                // Tables\Columns\IconColumn::make('kartu_keluarga')
                //     ->options([
                //         'heroicon-o-document-text'
                //     ])
                //     ->url(fn ($record) => Storage::url($record->kartu_keluarga)),

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


                // Tables\Columns\IconColumn::make('ijazah_terakhir')
                //     ->options([
                //         'heroicon-o-document-text'
                //     ])
                //     ->url(fn ($record) => Storage::url($record->ijazah_terakhir)),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->label('Ubah'),
                Tables\Actions\DeleteAction::make()
                    ->label(''),
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

    // public static function getWidgets(): array
    // {
    //     return[
    //         PendaftaranStatsOverview::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendaftarans::route('/'),
            'create' => Pages\CreatePendaftaran::route('/create'),
            'edit' => Pages\EditPendaftaran::route('/{record}/edit'),
        ];
    }
}
