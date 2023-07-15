<?php

namespace App\Filament\Resources\SantriResource\Pages;

use App\Filament\Resources\SantriResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

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
