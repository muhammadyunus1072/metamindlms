<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Sis\TrackHistory\HasTrackHistory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasTrackHistory;

    const ROLE_ADMIN = "admin";
    const ROLE_MEMBER = "member";

    const GENDER_PRIA = "Pria";
    const GENDER_WANITA = "Wanita";
    const GENDER_CHOICE = [
        self::GENDER_PRIA => self::GENDER_PRIA,
        self::GENDER_WANITA => self::GENDER_WANITA,
    ];

    const RELIGION_KATOLIK = "Katolik";
    const RELIGION_KRISTEN = "Kristen";
    const RELIGION_BUDDHA = "Buddha";
    const RELIGION_ISLAM = "Islam";
    const RELIGION_HINDU = "Hindu";
    const RELIGION_LAINNYA = "Lainnya";
    const RELIGION_CHOICE = [
        self::RELIGION_KATOLIK => self::RELIGION_KATOLIK,
        self::RELIGION_KRISTEN => self::RELIGION_KRISTEN,
        self::RELIGION_BUDDHA => self::RELIGION_BUDDHA,
        self::RELIGION_ISLAM => self::RELIGION_ISLAM,
        self::RELIGION_HINDU => self::RELIGION_HINDU,
        self::RELIGION_LAINNYA => self::RELIGION_LAINNYA,
    ];

    protected $fillable = [
        'email',
        'name',
        'role',
        'password',
        'phone',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'company_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const ADMIN = "admin";
    const MEMBER = "member";
}
