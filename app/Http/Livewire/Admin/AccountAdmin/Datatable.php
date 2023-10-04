<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use App\Traits\WithDatatable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

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
        $user = User::find($id);
        $user->delete();
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

                    $editUrl = route('admin.account_admin.edit', $encryptedId);
                    $editHtml = "<a href='$editUrl' class='dropdown-item'><i class='fa fa-edit mr-2'></i>Edit</a>";

                    $destroyUrl = route('admin.account_admin.destroy', $encryptedId);
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
                'key' => 'email',
                'name' => 'Email',
            ],
            [
                'key' => 'name',
                'name' => 'Nama',
            ],
        ];
    }

    public function getQuery(): Builder
    {
        return User::where('role', '=', User::ROLE_ADMIN);
    }

    public function getView(): String
    {
        return 'livewire.admin.offline-course.datatable';
    }
}
