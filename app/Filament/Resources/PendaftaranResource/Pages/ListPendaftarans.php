<?php

namespace App\Filament\Resources\PendaftaranResource\Pages;

use Carbon\Carbon;
use Filament\Forms;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pendaftaran;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PendaftaranResource;
use App\Filament\Resources\PendaftaranResource\Widgets\PendaftaranStatsOverview;

class ListPendaftarans extends ListRecords
{
    protected static string $resource = PendaftaranResource::class;


    // protected function getActions(): array
    // {
    //     $user = auth()->user();

    //     if ($user->hasRole('santri') && Pendaftaran::where('user_id', $user->id)->exists()) {
    //         return [];
    //     }
    //     return [
    //         Actions\CreateAction::make()
    //             ->label('Tambah Pendaftaran')
    //             ->mutateFormDataUsing(function (array $data) use ($user): array {
    //                 $data['user_id'] = $user->id;
    //                 return $data;
    //             }),
    //     ];
    // }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Pendaftaran'),
            Actions\CreateAction::make()
                ->label('Tambah Pendaftaran')
                ->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = auth()->id();
                    return $data;
                }),

            Actions\Action::make('export')
                ->label('Print Laporan Pendaftaran')
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
                    $filename = 'Laporan Data Pendaftaran' . now()->toDateTimeString() . '.pdf';

                    // query untuk mengambil semua pengeluaran_barang antara tanggal yang diberikan
                    $pengeluaranRecords = Pendaftaran::whereBetween('created_at', [$data['dari'], $data['hingga']])->get();

                    // menghitung total row yang di tampilkan
                    $totalRows = $pengeluaranRecords->count();

                    $pdf = PDF::loadView('pdf_pendaftaran_santri', [
                        'records' => $pengeluaranRecords,
                        'totalRows' => $totalRows,
                        'dari' => $data['dari'],
                        'hingga' => $data['hingga']
                    ])->output();

                    return response()->streamDownload(fn () => print($pdf), $filename);
                }),

        ];
    }


    // protected function getActions(): array
    // {
    //     // Cek apakah user yang sedang login sudah memiliki data pendaftaran
    //     $userHasPendaftaran = Pendaftaran::where('user_id', auth()->id())->exists();

    //     return [
    //         Actions\CreateAction::make()
    //             ->label('Tambah Pendaftaran')
    //             ->hidden($userHasPendaftaran),

    //         Actions\CreateAction::make()
    //             ->label('Tambah Pendaftaran')
    //             ->mutateFormDataUsing(function (array $data): array {
    //                 $data['user_id'] = auth()->id();
    //                 return $data;
    //             })
    //             ->hidden($userHasPendaftaran),
    //     ];
    // }




    protected static ?string $recordTitleAttribute = 'title';

    public static function getGlobalSearchResultTitle(Pendaftaran $record): string
    {
        return $record->name;
    }

    protected function getHeaderWidgets():array
    {
        return [
            PendaftaranStatsOverview::class,
        ];
    }
}
