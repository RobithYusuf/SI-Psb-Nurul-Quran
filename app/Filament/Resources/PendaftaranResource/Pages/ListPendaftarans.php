<?php

namespace App\Filament\Resources\PendaftaranResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PendaftaranResource;
use App\Filament\Resources\PendaftaranResource\Widgets\PendaftaranStatsOverview;
use App\Models\Pendaftaran;

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

    // protected function getHeaderWidgets():array
    // {
    //     return [
    //         PendaftaranStatsOverview::class,
    //     ];
    // }
}
