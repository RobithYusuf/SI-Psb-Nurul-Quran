<?php

namespace App\Filament\Resources\SantriResource\Widgets;

use App\Models\Santri;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SantriStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Jumlah Santri Baru', Santri::all('nama')->count())
            ->description('Jumlah santri baru yang terinput berdasarkan hasil seleksi yang telah dilakukan'),
            // ->hidden(auth()->user()->hasRole('santri')),
            // Card::make('Status Pendaftaran Lengkap', Santri::where('status_pendaftaran','=','Lengkap')->count())
            // ->description('Lanjut Ujian Test')
            // ->descriptionIcon('heroicon-s-badge-check')
            // ->color('success'),
            // Card::make('Status Pendaftaran Tidak Lengkap', Santri::where('status_pendaftaran','=','tidak lengkap')->count())
            // ->description('Tidak Lanjut Ujian')
            // ->descriptionIcon('heroicon-s-x-circle')
            // ->color('danger'),
        ];
    }
}
