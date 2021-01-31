<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, UuidTrait , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question',
        'question_category_id',
        'user_id',
        'level',
        'resource',
        'status',
    ];

    /**
     * Get user added the question.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get answers.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }
}
