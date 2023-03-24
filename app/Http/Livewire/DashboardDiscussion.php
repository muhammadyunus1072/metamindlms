<?php

namespace App\Http\Livewire;

use App\Models\CourseDiscussion;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardDiscussion extends Component
{
    use WithPagination;

    public function render()
    {
        $list_discussion_data = CourseDiscussion::
            select(
                'course_discussions.*',
                'u.name as member_name',
            )
            ->leftJoin('users as u', 'u.id', '=', 'course_discussions.member_id')
            ->where('course_discussions.member_id', info_user_id())
            ->paginate(3);
        return view('livewire.discussion', compact('list_discussion_data'));
    }
}
