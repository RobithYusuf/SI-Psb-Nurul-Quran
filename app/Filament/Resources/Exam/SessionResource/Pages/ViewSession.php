<?php

namespace App\Filament\Resources\Exam\SessionResource\Pages;

use App\Filament\Resources\Exam\SessionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSession extends ViewRecord
{
    protected static string $resource = SessionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
