<?php

namespace App\Http\Livewire\Admin\PaymentMethod;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\OfflineCourse;
use App\Models\PaymentMethod;
use App\Traits\WithDatatable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Builder;

class Datatable extends Component
{
    use WithDatatable;

    public function onMount()
    {
        $this->sortDirection = 'desc';
    }

    public function delete($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $offlineCourse = OfflineCourse::find($id);
        $offlineCourse->delete();
    }

    public function getColumns(): array
    {
        return [
            [
                'name' => 'Action',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    $encryptedId = Crypt::encryptString($item->id);

                    $editHtml = "<button type=''button class='dropdown-item'><i class='fa fa-edit mr-2'></i>Edit</button>";

                    $destroyUrl = '';
                    $destroyHtml = "<form action='$destroyUrl' method='POST' wire:submit.prevent=\"delete('$encryptedId')\">"
                        . method_field('DELETE') . csrf_field() .
                        "<button type='submit' class='dropdown-item'
                            onclick=\"return confirm('Delete Data?')\">
                            <i class='fa fa-trash mr-2'></i>Hapus
                        </button>
                    </form>";

                    $html = "<div class='btn-group'>
                        <button type='button'
                            class='btn btn-primary btn-sm dropdown-toggle'
                            data-toggle='dropdown'
                            aria-haspopup='true'
                            aria-expanded='false'>Aksi <i class='mdi mdi-chevron-down'></i></button>
                        <div class='dropdown-menu'>
                            $editHtml
                            <div class='dropdown-divider'></div>
                            $destroyHtml
                        </div>
                    </div>";

                    return $html;
                },
            ],
            [
                'key' => 'name',
                'name' => 'Nama',
            ],
            [
                'key' => 'description',
                'name' => 'Deskripsi',
            ],
            [
                'key' => 'instruction',
                'name' => 'Instruksi',
                'render' => function($item){
                    return $item->instruction;
                }
            ],
        ];
    }

    public function getQuery(): Builder
    {
        return PaymentMethod::query();
    }

    public function getView(): String
    {
        return 'livewire.admin.payment-method.datatable';
    }
}
