<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Kenepa\MultiWidget\MultiWidget;
use App\Filament\Widgets\PetunjukDonasi;
use App\Filament\Widgets\InformasiDonasi;
use App\Filament\Widgets\informasipesantren;
use App\Filament\Widgets\panduanpendaftaran;
use App\Filament\Widgets\StatistikChartDonasi;
use App\Filament\Widgets\StatistikChartDonasiKategori;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use App\Filament\Resources\DonasiDashResource\Widgets\StatistikDonasi;
use App\Filament\Resources\DonasiResource\Widgets\DonasiStatsOverview;
use App\Filament\Resources\DonasiAllResource\Widgets\DonasiAllStatsOverview;
use App\Filament\Resources\DonasiDashResource\Widgets\WidgetDashBottomStats;
use App\Filament\Resources\DonasiDashResource\Widgets\WidgetDashBottomStatus;
use App\Filament\Resources\DonasiDashResource\Widgets\DonasiDashStatsOverview;

class InformasiMultiWidget extends MultiWidget
{
    // protected static string $view = 'filament.widgets.donasi-multi-widget';
    // use HasWidgetShield;

    public array $widgets = [
        informasipesantren::class,
        panduanpendaftaran::class,

        // StatistikDonasi::class,
        // StatistikChartDonasi::class,
        // // StatistikChartDonasiKategori::class,
        // DonasiTerakhir::class,
        // PetunjukDonasi::class


    ];
}
