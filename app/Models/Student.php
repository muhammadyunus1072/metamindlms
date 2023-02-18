<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Sis\TrackHistory\HasTrackHistory;

class Student extends Model implements Authenticatable
{
    use HasFactory, SoftDeletes, HasTrackHistory, AuthenticableTrait;
}