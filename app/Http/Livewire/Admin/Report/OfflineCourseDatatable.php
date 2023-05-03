<?php

namespace App\Http\Livewire\Admin\Report;

use App\Exports\CollectionExport;
use Livewire\Component;
use App\Models\OfflineCourse;
use App\Models\OfflineCourseAttendance;
use App\Models\OfflineCourseRegistrar;
use App\Traits\WithDatatable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class OfflineCourseDatatable extends Component
{
    use WithDatatable;

    public $filter_categories_id = [];
    public $total_offline_course_registrar = 0;
    public $total_offline_course_attendance = 0;

    protected $listeners = [
        'filter_category'
    ];

    public function onMount()
    {
        $this->total_offline_course_registrar = OfflineCourseRegistrar::count();
        $this->total_offline_course_attendance = OfflineCourseAttendance::count();
    }

    public function export()
    {
        $data = $this->getProcessedQuery()->get();
        $fileName = "Data Kursus Offline";
        return Excel::download(new CollectionExport('admin.pages.report.offline_course.export', $data), "$fileName.xlsx");
    }

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

    public function getColumns(): array
    {
        return [
            [
                'key' => 'date_time_start',
                'name' => 'Tanggal Mulai',
                'searchable' => false,
                'render' => function ($item) {
                    return Carbon::parse($item->date_time_start)->format('d M Y, H:i');
                },
            ],
            [
                'key' => 'date_time_end',
                'name' => 'Tanggal Selesai',
                'searchable' => false,
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
                'searchable' => false,
            ],
            [
                'name' => 'Jumlah Pendaftar',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    return $item->registrars->count();
                },
            ],
            [
                'name' => 'Jumlah Kehadiran',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    return $item->attendances->count();
                },
            ],
        ];
    }

    public function getQuery(): Builder
    {
        $this->total_offline_course_registrar = OfflineCourseRegistrar::when(!empty($this->search) || count($this->filter_categories_id) > 0, function ($query) {
            $query->whereHas('offlineCourse', function ($query) {
                if (!empty($this->search)) {
                    $query->where('title', 'LIKE', "%$this->search%");
                }

                if (count($this->filter_categories_id) > 0) {
                    $query->whereHas('offlineCourseCategories', function ($query) {
                        $query->whereIn('category_course_id', $this->filter_categories_id);
                    });
                }
            });
        })->count();
        $this->total_offline_course_attendance = OfflineCourseAttendance::when(!empty($this->search) || count($this->filter_categories_id) > 0, function ($query) {
            $query->whereHas('offlineCourse', function ($query) {
                if (!empty($this->search)) {
                    $query->where('title', 'LIKE', "%$this->search%");
                }

                if (count($this->filter_categories_id) > 0) {
                    $query->whereHas('offlineCourseCategories', function ($query) {
                        $query->whereIn('category_course_id', $this->filter_categories_id);
                    });
                }
            });
        })->count();

        return OfflineCourse::with('registrars', 'attendances')
            ->when(count($this->filter_categories_id) > 0, function ($query) {
                $query->whereHas('offlineCourseCategories', function ($query) {
                    $query->whereIn('category_course_id', $this->filter_categories_id);
                });
            });
    }

    public function getView(): String
    {
        return 'livewire.admin.report.offline-course-datatable';
    }
}
