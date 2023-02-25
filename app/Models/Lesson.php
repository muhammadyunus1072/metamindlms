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
}
