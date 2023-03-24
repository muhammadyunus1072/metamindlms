<?php

namespace App\Http\Livewire\OfflineCourseAttendance;

use App\Models\OfflineCourseAttendance;
use App\Traits\WithDatatable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class Datatable extends Component
{
    use WithDatatable;

    public $offline_course_id;

    public function delete($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $attendance = OfflineCourseAttendance::find($id);
        $attendance->delete();

        $this->emitUp('attendanceChange');
    }

    public function getColumns()
    {
        return [
            [
                'name' => 'Action',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    $encryptedId = Crypt::encryptString($item->id);

                    $destroyUrl = route('admin.offline_course_attendance.destroy', $encryptedId);
                    $destroyHtml = "<form action='$destroyUrl' method='POST' wire:submit.prevent=\"delete('$encryptedId')\">"
                        . method_field('DELETE') . csrf_field() .
                        "<button type='submit' class='btn btn-danger ml-1'
                            onclick=\"return confirm('Delete Data?')\">
                            <i class='fa fa-trash'></i>
                        </button>
                    </form>";

                    return "<div class='row'>$destroyHtml</div>";
                },
            ],
            [
                'key' => 'user_name',
                'name' => 'Nama',
            ],
            [
                'key' => 'user_phone',
                'name' => 'Telepon',
            ],
            [
                'key' => 'user_email',
                'name' => 'Email',
            ],
            [
                'key' => 'user_company_name',
                'name' => 'Asal Perusahaan',
            ],
        ];
    }

    public function paginate($query)
    {
        return $query->paginate($this->length, ['*'], 'page_attendance');
    }

    public function getQuery()
    {
        $decId = Crypt::decryptString($this->offline_course_id);
        return OfflineCourseAttendance::where('offline_course_id', '=', $decId);
    }

    public function getView()
    {
        return 'livewire.offline-course-attendance.datatable';
    }
}
