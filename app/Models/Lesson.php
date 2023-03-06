<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class Lesson extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    const TYPE_VIDEO = 'video';
    const TYPE_QUIZ = 'quiz';

    public function lesson_icon($is_member){
        if ($this->can_preview || $is_member) {
            if ($this->type === self::TYPE_VIDEO) {
                return 'play_circle_outline';
            } else if($this->type === self::TYPE_QUIZ){
                return 'hourglass_empty';
            }
        } else {
            return 'lock';
        }
        
    }
}
