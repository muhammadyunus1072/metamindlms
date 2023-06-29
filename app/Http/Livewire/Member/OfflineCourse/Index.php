<?php

namespace App\Http\Livewire\Member\OfflineCourse;

use Livewire\WithPagination;
use App\Models\OfflineCourse;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    public $search = '', $filter_categories_id = [];

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'add_filter_search',
        'add_filter_category',
    ];

    public function add_filter_category($categories_id)
    {
        $this->filter_categories_id = $categories_id;
    }

    public function add_filter_search($search_text)
    {
        $this->search = $search_text;
    }

    public function render()
    {
        $filter_categories_id = $this->filter_categories_id;
        $currentDate = Carbon::now()->format('Y-m-d H:i:s');

        return view(
            'livewire.member.offline-course.index',
            [
                'data' => OfflineCourse::where('title', 'like', "%$this->search%")
                    ->when(count($filter_categories_id) > 0, function ($query) use ($filter_categories_id) {
                        $query->whereHas('offlineCourseCategories', function ($query) use ($filter_categories_id) {
                            $query->whereIn('category_course_id', $filter_categories_id);
                        });
                    })
                    ->where('date_time_end', '>=', $currentDate)
                    ->orderBy('date_time_start', 'DESC')
                    ->paginate(9)
            ]
        );
    }
}
