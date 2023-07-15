<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Models\seleksi;
use Filament\Pages\Page;
use App\Models\Exam\Result;
use App\Models\Pendaftaran;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Pengumuman extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static function getNavigationGroup(): ?string
    {
        $user = Auth::user();

        if ($user && $user->hasRole('santri')) {
            return __('Pengumuman Kelulusan');
        } else {
            return __('Data Pengelolaan');
        }
    }

    protected static ?int $navigationSort = -3;

    protected static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        if (!$user->hasRole('santri')) {
            return true;
        }
        $exam_result = Result::where('user_id', $user->id)->first();
        if ($exam_result && $exam_result->score >= '10') {
            return true;
        }
        return false;
    }

    protected static ?string $title = 'Pengumuman Seleksi';

    protected static string $view = 'filament.pages.pengumuman';

    public $seleksi;
    // public function mount()
    // {
    //     // if (auth()->user()->hasRole('santri')) {
    //     //     // $this->seleksi = auth()->user()->result->seleksi;
    //     //     $this->seleksi = Seleksi::with('result.user_id', auth()->id())->get();
    //     // } else {
    //     //     $this->seleksi = Seleksi::with('result.user')->get();
    //     // }
    //     $this->seleksi = Seleksi::with('result.user')->get();
    // }

    // public $seleksi;

    // // Buat property untuk menyimpan data seleksi
    public function mount()
    {
        // Jika user yang login memiliki peran 'santri'
        if (Auth::user()->hasRole('santri')) {
            // Dapatkan hasil yang berkaitan dengan user yang login
            // dan load data seleksi yang berkaitan
            $pendaftaran = Pendaftaran::where('user_id', Auth::id())->first();
            $exam_results = Result::where('user_id', Auth::id())->first();
            $this->seleksi = Result::where('user_id', Auth::id())->with('seleksi')->get();
        $this->seleksi->pendaftaran = $pendaftaran;
        $this->seleksi->exam_results = $exam_results;
        } else {
            // Jika user memiliki peran lain, dapatkan semua hasil
            // dan load data seleksi yang berkaitan
            $this->seleksi = Result::with('seleksi')->get();
        }
    }



//     public function mount()
// {
//     $this->user = User::with(['results', 'pendaftaran'])->where('id', Auth::id())->first();

//     if (Auth::user()->hasRole('santri')) {
//         $this->seleksi = $this->user->results->load('seleksi');
//     } else {
//         $this->seleksi = Result::with('seleksi')->get();
//     }
// }

}
