<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\Pendaftaran;
use Illuminate\Foundation\Auth\User;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class PSBStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $Pendaftaran = Pendaftaran::all('id')->count();
        // $jumlahpendaftar = User::where('id')->count();

        return [
            Card::make('Jumlah Pendaftar', $Pendaftaran)
            ->description('data pendaftaran perlu diseleksi'),

            // Card::make('Status Pendaftaran Lengkap', Pendaftaran::where('status_pendaftaran','=','Lengkap')->count())
            // ->description('Lanjut Ujian Test')

            // ->descriptionIcon('heroicon-s-badge-check')
            // ->color('success'),
            // Card::make('Status Pendaftaran Tidak Lengkap', Pendaftaran::where('status_pendaftaran','=','tidak lengkap')->count())
            // ->description('Tidak Lanjut Ujian')
            // ->descriptionIcon('heroicon-s-x-circle')
            // ->color('danger'),
            // //




        ];
    }
}
