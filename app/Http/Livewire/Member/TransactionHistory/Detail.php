<?php

namespace App\Http\Livewire\Member\TransactionHistory;

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

    public function mount($transaction_id)
    {
        $this->transaction_id = $transaction_id;
        $this->getData();
    }
    private function getData()
    {
        $this->transaction = Transaction::where('id', $this->transaction_id)
        ->where('user_id', info_user_id())
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
            return redirect()->route('member.transaction.index');
        }
    }

    public function save()
    {
        $validatedData = [];
        if ($this->image != null) {
            $this->validate([
                'image' => 'image|max:2048',
            ]);

            $this->image->store(FileHelper::PROOF_OF_PAYMENT_SAVE_LOCATION);
            $validatedData['proof_of_payment'] = $this->image->hashName();
        }
        $transaction = Transaction::find($this->transaction_id);
        $transaction->fill($validatedData);
        if($transaction->save())
        {
            $this->emit('onSuccessSweetAlert', 'Berhasil Menyimpan Bukti Bayar');
        }else{
            $this->emit('onFailSweetAlert', 'Gagal Menyimpan Bukti Bayar');
        }

    }
    public function render()
    {
        return view('livewire.member.transaction-history.detail',);
    }

}
