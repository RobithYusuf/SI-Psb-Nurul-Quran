<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $table = 'exam_questions';

    protected $guarded = ['id'];

    protected $casts = [
        'options' => 'array',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class, 'exam_session_id');
    }
}
