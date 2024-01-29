<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class TransactionDetailCourse extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        "transaction_detail_id",
        "course_id",

        "course_title",
        "course_description",
        "course_about",
        "course_url_image",
        "course_url_icon",
        "course_url_video",
        "course_price",
        "course_price_before_discount",
    ];
    protected static function onBoot()
    {
        self::created(function ($model) {
            $courseMember = new CourseMember();
            $courseMember->course_id = $model->course_id;
            $courseMember->member_id = $model->transactionDetail->transaction->user_id;
            $courseMember->course_price = $model->course_price;
            $courseMember->save();
        });
    }

    public function transactionDetail()
    {
        return $this->belongsTo(TransactionDetail::class, 'transaction_detail_id', 'id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
