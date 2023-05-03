<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CollectionExport implements FromView, ShouldAutoSize
{
    private $view;
    private $collection;
    private $request;

    public function __construct($request, $collection, $view)
    {
        $this->request = $request;
        $this->collection = $collection;
        $this->view = $view;
    }

    public function view(): View
    {
        return view($this->view, [
            'request' => $this->request,
            'collection' => $this->collection,
            'number_format' => false,
        ]);
    }
}
