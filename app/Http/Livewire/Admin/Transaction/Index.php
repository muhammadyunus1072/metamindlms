<?php

namespace App\Http\Livewire\Admin\Transaction;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\PaymentMethod;

class Index extends Component
{
    public $transactions;
    public $jenis_tanggal_choice;
    public $jenis_tanggal = 'rentang';
    public $status;

    public $start_date;
    public $end_date;

    public function mount()
    {
        $this->end_date = Carbon::now()->format('Y-m-d');
        $this->start_date = Carbon::now()->subMonths(1)->format('Y-m-d');
        $this->jenis_tanggal_choice = [
            'rentang-waktu' => 'Rentang Waktu',
            'seluruh-tanggal' => 'Seluruh Tanggal',
        ];
        $this->jenis_tanggal = 'rentang-waktu';

        $this->getData();
    }

    public function updated()
    {
        $this->getData();
    }

    private function getData()
    {
        $this->transactions = Transaction::select(
            'transactions.*',
            'transaction_statuses.name as status_name'
        )
            ->join('transaction_statuses', 'transactions.last_status_id', '=', 'transaction_statuses.id')
            ->with('transactionDetails', 'status')
            ->when($this->jenis_tanggal != 'seluruh-tanggal', function ($query) {
                $query->whereBetween('transactions.created_at', [$this->start_date . " 00:00:00", $this->end_date . " 23:59:59"]);
            })
            ->when($this->status, function ($query) {
                $query->where('transaction_statuses.name', $this->status);
            })
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.transaction.index',);
    }
}
