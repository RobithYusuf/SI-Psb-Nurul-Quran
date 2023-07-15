<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
Use Illuminate\Support\Carbon;

class kamar extends Model
{
    use HasFactory;
    protected $table = 'kamar';
    protected $fillable = ['nama_kamar','jumlah_santri','ketua_kamar'];
    public $timestamps = false;

    protected $primaryKey= 'id';

    public function santri(){
        return $this->hasMany(santri::class,'kelas_id','id');
    }
}
