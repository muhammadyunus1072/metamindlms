<?php

namespace App\Http\Livewire\Admin\Report;

use Livewire\Component;
use App\Traits\WithDatatable;
use App\Models\OfflineCourseRegistrar;

class RegistrarOfflineCourseDatatable extends Component
{
    use WithDatatable;

    public function getColumns()
    {
        return [
            [
                'key' => 'offline_course_id',
                'name' => 'Judul Kursus Offline',
                'render' => function ($item) {
                    return $item->offlineCourse->title;
                },
            ],
            [
                'key' => 'user_name',
                'name' => 'Nama Pengguna',
            ],
            [
                'key' => 'user_email',
                'name' => 'Email',
            ],
            [
                'key' => 'user_phone',
                'name' => 'Telepon',
            ],
            [
                'key' => 'user_company_name',
                'name' => 'Asal Perusahaan',
            ],
            [
                'name' => 'Status Kehadiran',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    if (!empty($item->offlineCourseAttendance)) {
                        return "<span class= 'badge badge-success'>Hadir</span>";
                    } else {
                        return "<span class= 'badge badge-danger'>Tidak Hadir</span>";
                    }
                },
            ]
        ];
    }

    public function getQuery()
    {
        return OfflineCourseRegistrar::query();
    }

    public function getView()
    {
        return 'livewire.admin.report.registrar-offline-course-datatable';
    }
}
