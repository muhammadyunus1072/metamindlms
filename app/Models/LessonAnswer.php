<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class LessonAnswer extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    const MAX_OVERALL_SCORE = 100;

    protected $fillable = [
        'lesson_question_id',
        'user_id',
        'number',
        'answers',
        'score'
    ];

    protected static function onBoot()
    {
        self::creating(function ($model) {
            $lesson_question = $model->lesson_question;
            $model->lesson_question_lesson_id = $lesson_question->lesson_id;
            $model->lesson_question_number = $lesson_question->number;
            $model->lesson_question_text = $lesson_question->text;
            $model->lesson_question_choices = $lesson_question->choices;

            $model->score = $model->calculate_score();
        });
    }

    public function calculate_score()
    {
        $answers = json_decode($this->answers);
        $choices = json_decode($this->lesson_question_choices);

        $is_correct = false;
        foreach ($answers as $answer) {
            foreach ($choices as $choice) {
                if ($choice->text ==  $answer && $choice->is_correct) {
                    $is_correct = true;
                    break;
                }
            }

            if ($is_correct) {
                break;
            }
        }

        return $is_correct ? 1 : 0;
    }

    public static function generate_overall_score($lesson_answers)
    {
        $score = 0;
        foreach ($lesson_answers as $answer) {
            $score += $answer['score'];
        }

        return [
            'score' => $score / count($lesson_answers) * self::MAX_OVERALL_SCORE,
            'max_score' => self::MAX_OVERALL_SCORE,
        ];
    }

    public function lesson_question()
    {
        return $this->belongsTo(LessonQuestion::class, 'lesson_question_id', 'id');
    }
}
