<?php

namespace App\Http\Livewire\Admin\OfflineCourseRegistrar;

use App\Models\OfflineCourseRegistrar;
use App\Traits\WithDatatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class Datatable extends Component
{
    use WithDatatable;

    public $offline_course_id;

    protected $listeners = ['refresh-registrar-data' => '$refresh'];

    public function delete($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $attendance = OfflineCourseRegistrar::find($id);
        $attendance->delete();

        $this->emit('registrar-change');
        $this->emit('attendance-change', true);
    }

    public function getColumns() : array
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

    public function getQuery(): Builder
    {
        $decId = Crypt::decryptString($this->offline_course_id);
        return OfflineCourseRegistrar::where('offline_course_id', '=', $decId);
    }

    public function getView(): String
    {
        return 'livewire.admin.offline-course-registrar.datatable';
    }
}
