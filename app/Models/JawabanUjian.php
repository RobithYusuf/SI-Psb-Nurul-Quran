<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanUjian extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_ujian', 'id_soal', 'jawaban_peserta', 'is_benar',
    ];

    public function ujian()
    {
        return $this->belongsTo('App\Models\Ujian', 'id_ujian');
    }

    public function soal()
    {
        return $this->belongsTo('App\Models\Soal', 'id_soal');
    }
}
