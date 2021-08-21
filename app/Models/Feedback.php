<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model {

    use HasFactory,
        UuidTrait,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exam_id',
        'question_id',
        'feedback',
    ];

    /**
     * Get user added the question.
     */
    public function exam() {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Get user added the question.
     */
    public function question() {
        return $this->belongsTo(Question::class);
    }

}
