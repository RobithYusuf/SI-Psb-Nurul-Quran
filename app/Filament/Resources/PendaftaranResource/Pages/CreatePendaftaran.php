<?php

namespace App\Filament\Resources\PendaftaranResource\Pages;

use App\Models\Pendaftaran;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PendaftaranResource;

class CreatePendaftaran extends CreateRecord
{
    protected static string $resource = PendaftaranResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // public function mount(): void
    // {
    //     parent::mount();

    //     if (auth()->user()->hasRole('santri')) {
    //         abort(403, 'Anda telah mengisi data pendaftaran.');
    //     }
    // }
    public function mount(): void
{
    parent::mount();

    // Cek jika user memiliki role 'santri'
    if (auth()->user()->hasRole('santri')) {
        // Cek apakah user sudah melakukan pendaftaran
        $pendaftaran = Pendaftaran::where('user_id', auth()->id())->first();
        // Jika sudah melakukan pendaftaran, redirect atau tampilkan pesan error
        if($pendaftaran){
            abort(403, 'Anda telah mengisi data pendaftaran.');
        }
    }
}

}
