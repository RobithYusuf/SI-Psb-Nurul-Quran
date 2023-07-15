<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Myprofile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    // protected static string $view = 'filament.pages.myprofile';

    protected static ?string $slug = 'my-profile';

    protected static ?string $title = 'Edit Profil';

    protected static function getNavigationGroup(): ?string
    {
        $user = Auth::user();

        if ($user && $user->hasRole('santri')) {
            return __('Ubah Profil');
        } else {
            return __('Kelola Pengguna');
        }
    }


    protected static ?string $modelLabel = 'Santri';

}
