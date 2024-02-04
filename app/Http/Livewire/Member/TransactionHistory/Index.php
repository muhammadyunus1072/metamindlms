<?php

namespace App\Http\Livewire\Member\TransactionHistory;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $length = 5;

    public $start_date;
    public $end_date;
    public $search;

    public function mount()
    {
        $this->end_date = Carbon::now()->format('Y-m-d');
        $this->start_date = Carbon::now()->subMonths(3)->format('Y-m-d');
    }

    public function render()
    {
        $transactions = Transaction::select('id', 'number', 'last_status_id')
            ->with([
                'status',
                'transactionDetails' => function ($query) {
                    return $query->select('transaction_id', 'product_name', 'product_description', 'product_price');
                }
            ])
            ->where('user_id', info_user_id())
            ->whereBetween('transactions.created_at', [$this->start_date . " 00:00:00", $this->end_date . " 23:59:59"])
            ->when($this->search, function ($query) {
                $query->whereHas('transactionDetails', function ($query) {
                    $query->where('product_name', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->orderBy('transactions.created_at', 'DESC')
            ->paginate($this->length);

        return view('livewire.member.transaction-history.index', [
            'transactions' => $transactions,
        ]);
    }
}
