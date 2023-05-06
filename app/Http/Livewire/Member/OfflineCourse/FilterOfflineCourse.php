<?php

namespace App\Http\Livewire\Member\OfflineCourse;

use App\Models\CategoryCourse;
use Livewire\Component;

class FilterOfflineCourse extends Component
{
    public $search = "";
    public $filter_categories_id = [];

    public function updatedSearch()
    {
        $this->emit('add_filter_search', $this->search);
    }
    
    public function toggle_filter_category($category_id)
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

        $this->emit('add_filter_category', $this->filter_categories_id);
    }

    public function render()
    {
        return view(
            'livewire.member.offline-course.filter-offline-course',
            [
                'categories' => CategoryCourse::all(),
            ]
        );
    }
}
