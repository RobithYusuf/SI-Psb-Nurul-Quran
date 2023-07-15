<?php

namespace App\Filament\Resources\SantriResource\Pages;

use App\Models\Pendaftaran;
use Filament\Pages\Actions;
use App\Filament\Resources\SantriResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSantri extends CreateRecord
{
    protected static string $resource = SantriResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    
}
