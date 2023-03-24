<?php

namespace App\Http\Livewire\OfflineCourseRegistrar;

use App\Models\OfflineCourseRegistrar;
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
        $attendance = OfflineCourseRegistrar::find($id);
        $attendance->delete();

        $this->emitUp('registrarChange');
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

                    $destroyUrl = route('admin.offline_course_registrar.destroy', $encryptedId);
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
        return $query->paginate($this->length, ['*'], 'page_registrar');
    }

    public function getQuery()
    {
        $decId = Crypt::decryptString($this->offline_course_id);
        return OfflineCourseRegistrar::where('offline_course_id', '=', $decId);
    }

    public function getView()
    {
        return 'livewire.offline-course-registrar.datatable';
    }
}
