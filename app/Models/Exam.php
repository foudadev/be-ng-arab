<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model {

    use HasFactory,
        UuidTrait,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'question_category_id',
        'level',
        'status',
        'answering_time',
        'degree',
        'used_hint_count',
        'skipped_count',
    ];

    protected $dates=[
        'created_at'.
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get user added the question.
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get user added the question.
     */
    public function category() {
        return $this->belongsTo(QuestionCategory::class, 'question_category_id', 'id');
    }

}
