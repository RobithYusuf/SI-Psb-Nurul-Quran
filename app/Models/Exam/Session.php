<?php

namespace App\Models\Exam;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
    use HasFactory;

    protected $table = 'exam_sessions';

    protected $guarded = ['id'];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'exam_session_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'exam_session_id');
    }
}
