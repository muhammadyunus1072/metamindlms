<?php

namespace App\Http\Livewire\Admin\Report;

use App\Models\OfflineCourse;
use App\Models\User;
use Livewire\Component;

class FilterRegistrarOfflineCourseDatatable extends Component
{
    public function render()
    {
        return view('livewire.admin.report.filter-registrar-offline-course-datatable');
    }
}
