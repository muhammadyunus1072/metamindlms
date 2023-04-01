<?php

namespace App\Http\Livewire\Member\OfflineCourse;

use App\Models\CategoryCourse;
use Livewire\Component;

class FilterOfflineCourse extends Component
{
    public function render()
    {
        return view(
            'livewire.member.offline-course.filter-offline-course',
            [
                'categories' => CategoryCourse::all(),
            ]
        );
    }
}
