<?php

namespace App\Filament\Resources\Exam\SessionResource\Pages;

use App\Filament\Resources\Exam\SessionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSession extends EditRecord
{
    protected static string $resource = SessionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
