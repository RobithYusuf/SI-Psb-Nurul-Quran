<?php

namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Exam\Result;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessFilament(): bool
    {
        return $this->hasRole([
            'panitia', 'admin',  'santri',
        ]);
    }

    public function result()
    {
        return $this->hasOne(Result::class);
    }

    public function results()
    {
        return $this->hasOne(Result::class, 'user_id');
    }
    public function pendaftaran()
    {
        return $this->hasOne(Pendaftaran::class);
    }


    public function hasRegistered()
    {
        return $this->pendaftaran()->exists();
    }

    public static function create(array $attributes = [])
    {
        $user = static::query()->create($attributes);
        $user->assignRole('santri'); //atur default role daftar
        return $user;
    }
}
