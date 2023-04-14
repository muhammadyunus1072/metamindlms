<?php

namespace App\Http\Livewire\Admin\OfflineCourse;

use App\Models\OfflineCourse;
use App\Traits\WithDatatable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class Datatable extends Component
{
    use WithDatatable;

    public function delete($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $offlineCourse = OfflineCourse::find($id);
        $offlineCourse->delete();
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

                    $showUrl = route('admin.offline_course.show', $encryptedId);
                    $showHtml = "<a href='$showUrl' class='dropdown-item'><i class='fa fa-eye mr-2'></i>Lihat Detail</a>";

                    $editUrl = route('admin.offline_course.edit', $encryptedId);
                    $editHtml = "<a href='$editUrl' class='dropdown-item'><i class='fa fa-edit mr-2'></i>Edit</a>";

                    $destroyUrl = route('admin.offline_course.destroy', $encryptedId);
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
                            $showHtml
                            <div class='dropdown-divider'></div>
                            $editHtml
                            <div class='dropdown-divider'></div>
                            $destroyHtml
                        </div>
                    </div>";

                    return $html;
                },
            ],
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
        return OfflineCourse::query();
    }

    public function getView()
    {
        return 'livewire.admin.offline-course.datatable';
    }
}
