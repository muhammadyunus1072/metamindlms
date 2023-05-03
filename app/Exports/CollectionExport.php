<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CollectionExport implements FromView, ShouldAutoSize
{
    private $view;
    private $collection;
    private $other;

    public function __construct($view, $collection, $other = [])
    {
        $this->other = $other;
        $this->collection = $collection;
        $this->view = $view;
    }

    public function view(): View
    {
        return view($this->view, [
            'other' => $this->other,
            'collection' => $this->collection,
            'number_format' => false,
        ]);
    }
}
