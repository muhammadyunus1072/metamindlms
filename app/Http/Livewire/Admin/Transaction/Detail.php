<?php

namespace App\Http\Livewire\Admin\Transaction;

use App\Models\Cart;
use App\Models\User;
use Livewire\Component;
use App\Helpers\FileHelper;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use Livewire\WithFileUploads;
use App\Models\TransactionStatus;

class Detail extends Component
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

    public function mount($transaction_id)
    {
        $this->transaction_id = $transaction_id;
        $this->getData();
    }
    private function getData()
    {
        $this->transaction = Transaction::where('id', $this->transaction_id)
        ->with(
            'transactionDetails',
            'status',
        )
        ->withSum('transactionDetails', 'product_price')
        ->first();

        $this->oldImage = $this->transaction->getImage();
        $this->total = $this->transaction->transaction_details_sum_product_price;
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
        return view('livewire.admin.transaction.detail',);
    }

}
