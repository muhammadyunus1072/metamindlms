<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class CourseReview extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    const RATING_0 = 0;
    const RATING_1 = 1;
    const RATING_2 = 2;
    const RATING_3 = 3;
    const RATING_4 = 4;
    const RATING_5 = 5;

    const LIST_RATING = array(
        self::RATING_0 => "0 Bintang",
        self::RATING_1 => "1 Bintang",
        self::RATING_2 => "2 Bintang",
        self::RATING_3 => "3 Bintang",
        self::RATING_4 => "4 Bintang",
        self::RATING_5 => "5 Bintang",
    );
}
