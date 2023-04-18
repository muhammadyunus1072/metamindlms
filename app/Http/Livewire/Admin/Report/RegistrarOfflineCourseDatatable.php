<?php

namespace App\Http\Livewire\Admin\Report;

use App\Models\OfflineCourse;
use App\Models\User;
use Livewire\Component;
use App\Traits\WithDatatable;
use App\Models\OfflineCourseRegistrar;
use Illuminate\Support\Facades\Crypt;

class RegistrarOfflineCourseDatatable extends Component
{
    use WithDatatable;


    public $filter_offline_course_id = "";
    public $filter_member_id = "";

    protected $listeners = [
        'registrar_filter_offline_course',
        'registrar_filter_member',
    ];

    public function registrar_filter_offline_course($offline_course_id)
    {
        $this->filter_offline_course_id = $offline_course_id;
    }

    public function registrar_filter_member($member_id)
    {
        $this->filter_member_id = $member_id;
    }

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
        $filter_offline_course_id = $this->filter_offline_course_id != "" ? Crypt::decrypt($this->filter_offline_course_id) : "";
        $filter_member_id = $this->filter_member_id !=  "" ? Crypt::decrypt($this->filter_member_id) : "";

        return OfflineCourseRegistrar::select('*')
            ->when((!empty($filter_offline_course_id)), function ($query) use ($filter_offline_course_id) {
                $query->where('offline_course_id', $filter_offline_course_id);
            })
            ->when((!empty($filter_member_id)), function ($query) use ($filter_member_id) {
                $query->where('user_id', $filter_member_id);
            });
    }

    public function getView()
    {
        return 'livewire.admin.report.registrar-offline-course-datatable';
    }
}
