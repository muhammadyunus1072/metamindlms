<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class OfflineCourseRegistrar extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'offline_course_id',
        'user_id',
    ];

    protected static function onBoot()
    {
        self::creating(function ($model) {
            $user = $model->user;
            $model->user_name = $user->name;
            $model->user_email = $user->address;
            $model->user_phone = $user->phone;
            $model->user_birth_place = $user->owner_name;
            $model->user_birth_date = $user->owner_email;
            $model->user_gender = $user->owner_phone;
            $model->user_religion = $user->contract_date_start;
            $model->user_company_name = $user->contract_date_end;
        });

        self::updating(function ($model) {
            if ($model->user_id != $model->getOriginal('user_id')) {
                $user = $model->user;
                $model->user_name = $user->name;
                $model->user_email = $user->address;
                $model->user_phone = $user->phone;
                $model->user_birth_place = $user->owner_name;
                $model->user_birth_date = $user->owner_email;
                $model->user_gender = $user->owner_phone;
                $model->user_religion = $user->contract_date_start;
                $model->user_company_name = $user->contract_date_end;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function offlineCourse()
    {
        return $this->belongsTo(OfflineCourse::class, 'offline_course_id', 'id');
    }
}
