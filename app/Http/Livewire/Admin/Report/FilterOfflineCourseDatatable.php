<?php

namespace App\Http\Livewire\Admin\Report;

use Livewire\Component;
use App\Models\CategoryCourse;

class FilterOfflineCourseDatatable extends Component
{
    public function render()
    {
        return view('livewire.admin.report.filter-offline-course-datatable', [
            'categories' => CategoryCourse::all(),
        ]);
    }
}
