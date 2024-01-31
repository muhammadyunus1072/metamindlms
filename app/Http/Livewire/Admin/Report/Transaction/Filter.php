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

    public function mount()
    {
        $this->end_date = Carbon::now()->format('Y-m-d');
        $this->start_date = Carbon::now()->subMonths(1)->format('Y-m-d');
        $this->jenis_tanggal = 'rentang-waktu';
    }

    public function updated()
    {
        $this->emit('addFilter', [
            'end_date' => $this->end_date,
            'start_date' => $this->start_date,
            'jenis_tanggal' => $this->jenis_tanggal,
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
        return view('livewire.admin.report.transaction.filter');
    }
}
