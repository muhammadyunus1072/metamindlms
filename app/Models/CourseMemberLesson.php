<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class CourseMemberLesson extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    const BELOW_60 = "0 - 60";
    const BETWEEN_60_TO_70 = "60 - 70";
    const BETWEEN_70_TO_80 = "70 - 80";
    const BETWEEN_80_TO_90 = "80 - 90";
    const BETWEEN_90_TO_100 = "90 - 100";

    const LIST_PROGRESS = array(
        self::BELOW_60 => "Dibawah 60%",
        self::BETWEEN_60_TO_70 => "Antara 60% sampai 70%",
        self::BETWEEN_70_TO_80 => "Antara 70% sampai 80%",
        self::BETWEEN_80_TO_90 => "Antara 80% sampai 90%",
        self::BETWEEN_90_TO_100 => "Antara 90% sampai 100%",
    );
}
