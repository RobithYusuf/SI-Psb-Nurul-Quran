<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\kamar;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Pendaftaran;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DashboardWidgets extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            card::make('Jumlah santri Baru',Santri::all('id')->count())
            ->description('Jumlah Santri Baru')
            ->Icon('heroicon-s-user-group')
            ->color('success'),
            card::make('jumlah Pendaftar', Pendaftaran::all('id')->count())
            ->description('Calon Santri')
            ->Icon('heroicon-o-user-add')
            ->color('success'),
            card::make('Kamar Tersedia', Kamar::all('id')->count())
            ->description('Jumlah Kamar Asrama')
            ->Icon('heroicon-o-office-building')
            ->color('success'),
            card::make('Kelas Tersedia', Kelas::all('id')->count())
            ->description('Jumlah Kelas mengaji')
            ->Icon('heroicon-o-office-building')
            ->color('success'),
        ];
    }
}
