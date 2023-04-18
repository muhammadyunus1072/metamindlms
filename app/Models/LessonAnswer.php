<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class LessonAnswer extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'lesson_question_id',
        'user_id',
        'number',
        'answers',
        'score'
    ];

    public function lesson_question()
    {
        return $this->belongsTo(LessonQuestion::class, 'lesson_question_id', 'id');
    }

    protected static function onBoot()
    {
        // self::creating(function ($model) {
        //     $lesson_question = $model->lesson_question;
        //     $model->lesson_question_lesson_id = $lesson_question->lesson_id;
        //     $model->lesson_question_number = $lesson_question->number;
        //     $model->lesson_question_text = $lesson_question->text;
        //     $model->lesson_question_choices = $lesson_question->choices;
        // });
    }
}
