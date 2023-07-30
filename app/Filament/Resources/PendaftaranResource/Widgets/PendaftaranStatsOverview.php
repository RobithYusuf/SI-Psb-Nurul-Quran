<?php

namespace App\Filament\Resources\PendaftaranResource\Widgets;

use App\Models\Pendaftaran;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class PendaftaranStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Jumlah Pendaftar', Pendaftaran::all('id')->count())
            ->description('data pendaftaran perlu diseleksi'),
            // ->hidden(auth()->user()->hasRole('santri')),
            Card::make('Status Pendaftaran Lengkap', Pendaftaran::where('status_pendaftaran','=','Lengkap')->count())
            ->description('Lanjut Ujian Test')
            ->descriptionIcon('heroicon-s-badge-check')
            ->color('success'),
            Card::make('Status Pendaftaran Tidak Lengkap', Pendaftaran::where('status_pendaftaran','=','tidak lengkap')->count())
            ->description('Tidak Lanjut Ujian')
            ->descriptionIcon('heroicon-s-x-circle')
            ->color('danger'),

        ];
    }
}
