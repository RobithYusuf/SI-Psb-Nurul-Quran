<?php

namespace App\Filament\Pages;


use App\Filament\Widgets\InformasiDonasi;
use Filament\Pages\Dashboard as BasePage;
use Illuminate\Contracts\Support\Htmlable;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use App\Filament\Resources\DonasiResource\Widgets\PendaftaranStatsOverview;
use App\Filament\Resources\DonasiDashResource\Widgets\DonasiDashStatsOverview;
use App\Filament\Resources\DonasiDashResource\Widgets\WidgetDashBottomStats;
use App\Filament\Widgets\DonasiMultiWidget;
use App\Filament\Widgets\DonasiMultiWidgetStats;

class Dashboard extends BasePage
{

    // use HasWidgetShield;

    // protected function getWidgets(): array
    // {
    //     return [
    //         PendaftaranStatsOverview;::class,
    //         DonasiStatsOverview::class,
    //         InformasiDonasi::class,
    //         WidgetDashBottomStats::class,
    //         DonasiMultiWidget::class,
    //     ];
    // }

    protected function getSubheading(): string|Htmlable|null
    {
        return "Informasi mengenai informasi Pondok Pesantren dan Pendaftaran dapat dilihat pada halaman ini,Sebelum melakukan pendaftaran silahkan baca panduan pendaftaran yang tertera dibawah";
    }
}
