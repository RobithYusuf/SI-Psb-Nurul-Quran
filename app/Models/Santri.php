<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class santri extends Model
{
    use HasFactory;
    protected $table = 'santri';
    protected $fillable = [
    'nama',
    'nik',
    'tempat_lahir',
    'tanggal_lahir',
    'alamat',
    'no_hp',
    'jenis_kelamin',
    'email',
    'nama_wali',
    'alamat_wali',
    'no_hp_wali',
    'pekerjaan',
    'gaji_wali',
    'kartu_keluarga',
    'akta_kelahiran',
    'ijazah_terakhir',
    'kamar_id',
    'pendaftaran_id',
    'kelas_id'];

    public $timestamps = false;

    protected $primaryKey= 'id';

    public function pendaftaran(){
        return $this->hasMany(Pendaftaran::class, 'id');
    }
    public function kamar(){
        return $this->belongsTo(kamar::class, 'kamar_id','id');
    }
    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kelas_id','id');
    }
}
