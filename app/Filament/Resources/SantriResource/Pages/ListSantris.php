<?php

namespace App\Filament\Resources\SantriResource\Pages;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SantriResource;
use App\Models\santri;

class ListSantris extends ListRecords
{
    protected static string $resource = SantriResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Tambah Santri'),

        ];
    }
}
