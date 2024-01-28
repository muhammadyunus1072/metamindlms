<?php

namespace App\Http\Livewire\Admin\Product;

use App\Helpers\NumberFormatter;
use Carbon\Carbon;
use App\Models\Product;
use Livewire\Component;
use App\Models\OfflineCourse;
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

                    $editUrl = route('admin.product.edit', $encryptedId);
                    $editHtml = "<a href='$editUrl' class='dropdown-item'><i class='fa fa-edit mr-2'></i>Edit</a>";

                    $destroyUrl = route('admin.product.destroy', $encryptedId);
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
                'key' => 'price',
                'name' => 'Harga',
                'searchable' => false,
                'render' => function ($item) {
                    return NumberFormatter::format($item->price);
                },
            ],
            [
                'key' => 'price_before_discount',
                'name' => 'Harga Sebelum Diskon',
                'searchable' => false,
                'render' => function ($item) {
                    return NumberFormatter::format($item->price_before_discount);
                },
            ],
        ];
    }

    public function getQuery(): Builder
    {
        return Product::whereNull('remarks_id');
    }

    public function getView(): String
    {
        return 'livewire.admin.offline-course.datatable';
    }
}
