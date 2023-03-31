<?php

namespace App\Http\Livewire\Member\OfflineCourse;

use Livewire\WithPagination;
use App\Models\OfflineCourse;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $filter = [''];

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['refreshUserPagination' => '$refresh'];

    public function render()
    {
        return view(
            'livewire.member.offline-course.index',
            [
                'data' => OfflineCourse::where('title', 'like', "%$this->search%")->paginate(9)
            ]
        );
    }
}
