<?php

namespace App\Http\Livewire\Admin\Report;

use Livewire\Component;
use App\Models\OfflineCourse;
use App\Traits\WithDatatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;

class OfflineCourseDatatable extends Component
{
    use WithDatatable;

    public $filter_categories_id = [];

    protected $listeners = [
        'filter_category'
    ];

    public function filter_category($category_id)
    {
        if (in_array($category_id, $this->filter_categories_id)) {
            $this->filter_categories_id = array_filter(
                $this->filter_categories_id,
                function ($element) use ($category_id) {
                    return $element != $category_id;
                }
            );
        } else {
            array_push($this->filter_categories_id, $category_id);
        }
    }

    public function getColumns()
    {
        return [
            [
                'key' => 'date_time_start',
                'name' => 'Tanggal Mulai',
                'render' => function ($item) {
                    return Carbon::parse($item->date_time_start)->format('d M Y, H:i');
                },
            ],
            [
                'key' => 'date_time_end',
                'name' => 'Tanggal Selesai',
                'render' => function ($item) {
                    return Carbon::parse($item->date_time_end)->format('d M Y, H:i');
                },
            ],
            [
                'key' => 'title',
                'name' => 'Judul',
            ],
            [
                'key' => 'quota',
                'name' => 'Quota',
            ],
            [
                'name' => 'Jumlah Pendaftar',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    return $item->registrars()->count();
                },
            ],
            [
                'name' => 'Jumlah Kehadiran',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    return $item->attendances()->count();
                },
            ],
        ];
    }

    public function getQuery()
    {
        $filter_categories_id = $this->filter_categories_id;

        return OfflineCourse::when(count($filter_categories_id) > 0, function ($query) use ($filter_categories_id) {
            $query->whereHas('offlineCourseCategories', function ($query) use ($filter_categories_id) {
                $query->whereIn('category_course_id', $filter_categories_id);
            });
        });
    }

    public function getView()
    {
        return 'livewire.admin.report.offline-course-datatable';
    }
}
