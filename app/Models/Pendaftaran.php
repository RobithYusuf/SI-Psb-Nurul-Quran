<?php

namespace App\Models;

use DB;
use App\Traits\HasOwner;
use Spatie\MediaLibrary\HasMedia;
Use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Pendaftaran extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasOwner;
    protected $table = 'pendaftaran';
    protected $fillable = [
        'nama',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat','no_hp',
        'jenis_kelamin',
        'email',
        'nama_wali',
        'alamat_wali',
        'no_hp_wali',
        'pekerjaan',
        'gaji_wali',
        'kartu_keluarga',
        'akta_kelahiran_new',
        'akta_kelahiran',
        'ijazah_terakhir',
        'status_pendaftaran',
        'created_at',
        'updated_at',
    ];


    protected $primaryKey= 'id';

    public function santri(){
        return $this->belongsTo(santri::class,'pendaftaran_id','id');
    }

    public function seleksi(){
        return $this->belongsTo(seleksi::class,'pendaftaran_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }


}
