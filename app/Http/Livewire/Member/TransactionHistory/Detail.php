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

    protected $rules = [];

    public $snapToken;

    public function mount($transaction_id)
    {
        $this->transaction_id = $transaction_id;
        $this->getData();
    }

    private function getData()
    {
        $transaction = Transaction::where('id', $this->transaction_id)
            ->where('user_id', info_user_id())
            ->with(
                'transactionDetails',
                'status',
            )
            ->withSum('transactionDetails', 'product_price')
            ->first();
        if ($transaction->payment_method_id == PaymentMethod::MIDTRANS_ID) {
            if(!$transaction->snap_token){
                $snapToken = MidtransPayment::getSnapToken(
                    $transaction->id,
                    $transaction->transactionDetails->sum('product_price'),
                    [
                        'first_name' => $transaction->user->name,
                        'last_name' => '',
                        'email' => $transaction->user->email,
                        'phone' => $transaction->user->phone,
                    ]
                );
                $transaction->snap_token = $snapToken;
                $transaction->save();
            }
            $this->snap_token = $transaction->snap_token;
        }else{
            $this->oldImage = $transaction->getImage();
        }
        $this->transaction = $transaction;
        $this->total = $transaction->transaction_details_sum_product_price;
    }

    public function updated($propertyName)
    {

        if ($this->image != null) {
            $this->validate([
                'image' => 'image|max:2048',
            ]);
        }
    }

    public function checkout(){
        $this->emit('midtransCheckout', $snapToken);
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
        if ($transaction_status->save()) {
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

        if ($transaction->save()) {
            if ($transaction->status->name != TransactionStatus::STATUS_ORDER_CONFIRMATION_PENDING) {
                $transaction_status = new TransactionStatus();
                $transaction_status->transaction_id = $transaction->id;
                $transaction_status->name = TransactionStatus::STATUS_ORDER_CONFIRMATION_PENDING;
                $transaction_status->description = TransactionStatus::STATUS_ORDER_CONFIRMATION_PENDING;
                $transaction_status->save();

                $this->getData();
            }
            $this->emit('onSuccessSweetAlert', 'Berhasil Menyimpan Bukti Bayar');
        } else {
            $this->emit('onFailSweetAlert', 'Gagal Menyimpan Bukti Bayar');
        }
    }
    public function render()
    {
        return view('livewire.member.transaction-history.detail',);
    }
}
