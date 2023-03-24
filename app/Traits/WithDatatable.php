<?php

namespace App\Traits;

use Livewire\WithPagination;

trait WithDatatable
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $lengthOptions = [10, 25, 50, 100];
    public $length = 10;
    public $search;
    public $sortBy = '';
    public $sortDirection = 'asc';

    public function getColumns()
    {
    }

    public function getQuery()
    {
    }

    public function getView()
    {
    }

    public function paginate($query)
    {
        return $query->paginate($this->length);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        if ($this->sortBy == '' && count($this->getColumns()) > 0) {
            foreach ($this->getColumns() as $col) {
                if (!isset($col['sortable']) || $col['sortable']) {
                    $this->sortBy = $col['key'];
                    break;
                }
            }
        }
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort()
            : 'asc';

        $this->sortBy = $field;
    }

    public function reverseSort()
    {
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }

    public function getData()
    {
        $columnsKey = array_column($this->getColumns(), "key");

        $query = $this->getQuery();
        $query->where(function ($query) use ($columnsKey) {
            foreach ($columnsKey as $field) {
                $query->orWhere($field, 'LIKE', "%$this->search%");
            }
        });

        return $this->paginate($query->orderBy($this->sortBy, $this->sortDirection));
    }

    public function render()
    {
        return view($this->getView(), [
            'data' => $this->getData(),
            'columns' => $this->getColumns(),
        ]);
    }
}
