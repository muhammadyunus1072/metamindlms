<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
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

    abstract public function getColumns(): array;
    abstract public function getQuery(): Builder;
    abstract public function getView(): String;

    public function onMount()
    {
    }

    public function mount()
    {
        $columns = $this->getColumns();
        if ($this->sortBy == '' && count($columns) > 0) {
            foreach ($columns as $col) {
                if (!isset($col['sortable']) || $col['sortable']) {
                    $this->sortBy = $col['key'];
                    break;
                }
            }
        }

        $this->onMount();
    }

    public function paginate($query)
    {
        return $query->paginate($this->length);
    }

    public function updatingSearch()
    {
        $this->resetPage();
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

    public function getProcessedQuery()
    {
        $columns = $this->getColumns();
        $query = $this->getQuery();
        $search = $this->search;
        $sortBy = $this->sortBy;
        $sortDirection = $this->sortDirection;

        $query->when($search, function ($query) use ($search, $columns) {
            $query->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    if (
                        isset($col['key'])
                        && (!isset($col['searchable']) || (isset($col['searchable']) && $col['searchable']))
                    ) {
                        $query->orWhere($col['key'], 'LIKE', "%$search%");
                    }
                }
            });
        });

        $query->when($sortBy, function ($query) use ($sortBy, $sortDirection) {
            $query->orderBy($sortBy, $sortDirection);
        });

        return $query;
    }

    public function getData()
    {
        return $this->paginate($this->getProcessedQuery());
    }

    public function render()
    {
        return view($this->getView(), [
            'data' => $this->getData(),
            'columns' => $this->getColumns(),
        ]);
    }
}
