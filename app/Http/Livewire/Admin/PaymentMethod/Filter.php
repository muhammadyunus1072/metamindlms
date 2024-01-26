<?php

namespace App\Http\Livewire\Admin\PaymentMethod;

use App\Models\Cart;
use App\Models\User;
use Livewire\Component;
use App\Helpers\FileHelper;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use Livewire\WithFileUploads;
use App\Models\TransactionStatus;

class Filter extends Component
{
    use WithFileUploads;

    public $transaction_id;
    public $transaction;
    public $total;

    public $image = null;
    public $oldImage = null;

    protected $rules = [
    ];
    protected $listeners = [
        'addFilter',
    ];

    public function addFilter($filter)
    {
        foreach ($filter as $key => $value) {
            $this->$key = $value;
        }
    }

    public function mount()
    {
        $this->getData();
    }
    private function getData()
    {
    }

    public function updated($propertyName)
    {

        if ($this->image != null) {
            $this->validate([
                'image' => 'image|max:2048',
            ]);
        }
    }

    public function confirmDoneTransaction()
    {
        $this->dispatchBrowserEvent('openConfirTransactionModal');
    }

    public function confirmTransaction()
    {
        $transaction_status = new TransactionStatus();
        $transaction_status->transaction_id = $this->transaction_id;
        $transaction_status->name = TransactionStatus::STATUS_DONE;
        $transaction_status->description = TransactionStatus::STATUS_DONE;
        if($transaction_status->save())
        {
            return redirect()->route('admin.transaction.index');
        }
    }
    public function confirmCancelTransaction()
    {
        $this->dispatchBrowserEvent('openConfirmCancellationModal');
    }
    public function cancelTransaction()
    {
        $transaction_status = new TransactionStatus();
        $transaction_status->transaction_id = $this->transaction_id;
        $transaction_status->name = TransactionStatus::STATUS_CANCEL;
        $transaction_status->description = TransactionStatus::STATUS_CANCEL;
        if($transaction_status->save())
        {
            return redirect()->route('admin.transaction.index');
        }
    }
    public function render()
    {
        return view('livewire.admin.payment-method.filter',);
    }

}
