<?php

namespace App\Http\Livewire;

use App\Models\CourseReview;
use Livewire\Component;
use Livewire\WithPagination;

class Review extends Component
{
    use WithPagination;
    public $course_id;

    public function render()
    {
        $list_review_data = CourseReview::
            select(
                'course_reviews.*',
                'u.name as member_name',
            )
            ->leftJoin('users as u', 'u.id', '=', 'course_reviews.member_id')
            ->where('course_reviews.course_id', $this->course_id)
            ->paginate(5);
        return view('livewire.review', compact('list_review_data'));
    }
}
