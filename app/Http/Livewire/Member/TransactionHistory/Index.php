<?php

namespace App\Http\Livewire\Member\TransactionHistory;

use App\Models\Cart;
use App\Models\User;
use Livewire\Component;
use App\Models\PaymentMethod;

class Index extends Component
{
    public $user;

    public function mount()
    {
        $this->getData();
    }
    private function getData()
    {
        $user = User::where('id', info_user_id())->with([
            'transactions',
            'transactions.transactionDetails',
            'transactions.status',
        ])
        ->first();
        $this->user = $user;
    }
    public function render()
    {
        return view('livewire.member.transaction-history.index',);
    }

}
