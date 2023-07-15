<?php

namespace App\Models;

use DB;
use App\Models\Exam\Result;
use App\Models\Pendaftaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
Use Illuminate\Support\Carbon;


class seleksi extends Model
{
    use HasFactory;
    protected $table = 'seleksi';
    protected $fillable = [
        'result_id',
        'nilai_test',
        'nilai_wawancara',
        'nilai_btq',
        'total_nilai',
        'status_seleksi',
        'tanggal_pengumuman',
        'berkas_hasil_pendaftan'];
    public $timestamps = false;
    protected $dates = ['tanggal_pengumuman'];
    protected $primaryKey= 'id';

    public function pendaftaran(){
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id');
    }
    public function result(){
        return $this->belongsTo(Result::class, 'result_id', 'id');
    }



}
