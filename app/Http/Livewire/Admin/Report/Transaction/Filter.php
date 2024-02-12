<?php

namespace App\Http\Livewire\Admin\Report\Transaction;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Filter extends Component
{
    // Filter
    public $end_date;
    public $start_date;
    public $statuses;
    public $members;
    public $products;
    public $courses;
    public $offline_courses;
    public $payment_methods;

    public $total_price;
    public $total_transaction;

    protected $listeners = [
        'setTotalHeader',
    ];

    public function mount()
    {
        $this->end_date = Carbon::now()->format('Y-m-d');
        $this->start_date = Carbon::now()->subMonths(1)->format('Y-m-d');
    }

    public function setTotalHeader($total_price, $total_transaction)
    {
        $this->emit('consoleLog', "$total_price - $total_transaction");
        $this->total_price = number_format($total_price, 0, '.', '.');
        $this->total_transaction = number_format($total_transaction, 0, '.', '.');
    }

    public function updated()
    {
        $this->emit('addFilter', [
            'end_date' => $this->end_date,
            'start_date' => $this->start_date,
            'statuses' => $this->statuses,
            'members' => $this->members,
            'products' => $this->products,
            'courses' => $this->courses,
            'offline_courses' => $this->offline_courses,
            'payment_methods' => $this->payment_methods,
        ]);
    }

    public function render()
    {
        $this->emit('consoleLog', "filter");
        return view('livewire.admin.report.transaction.filter');
    }
}
