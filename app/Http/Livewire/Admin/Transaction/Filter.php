<?php

namespace App\Http\Livewire\Admin\Transaction;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Filter extends Component
{
    // Filter
    public $end_date;
    public $start_date;
    public $status;
    public $jenis_tanggal;
    public $jenis_tanggal_choice;


    public function mount()
    {
        $this->end_date = Carbon::now()->format('Y-m-d');
        $this->start_date = Carbon::now()->subMonths(1)->format('Y-m-d');
        $this->jenis_tanggal_choice = [
            'rentang-waktu' => 'Rentang Waktu',
            'seluruh-tanggal' => 'Seluruh Tanggal',
        ];
        $this->jenis_tanggal = 'rentang-waktu';
    }

    public function updated()
    {
        $this->emit('addFilter', [
            'end_date' => $this->end_date,
            'start_date' => $this->start_date,
            'jenis_tanggal' => $this->jenis_tanggal,
            'status' => $this->status,
        ]);
    }

    public function render()
    {
        return view('livewire.admin.transaction.filter');
    }
}
