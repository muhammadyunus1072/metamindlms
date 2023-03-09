<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class CourseDiscussion extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    //Relation
    public function discussion_answer()
    {
        return $this->hasMany(CourseDiscussionAnswer::class, 'discussion_id', 'id');
    }
}
