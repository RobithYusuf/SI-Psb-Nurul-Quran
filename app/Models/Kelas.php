<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $fillable = ['nama_kelas','jumlah_santri','ketua_kelas'];
    public $timestamps = false;


    protected $primaryKey= 'id';

    public function santri(){
        return $this->hasMany(santri::class,'kelas_id','id');
    }

}
