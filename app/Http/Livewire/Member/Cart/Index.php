<?php

namespace App\Http\Livewire\Member\Cart;

use App\Models\Cart;
use App\Models\User;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Helpers\MidtransPayment;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $user;
    public $carts;
    public $total;
    public $input_payment_method = [];
    public $payment_method_choices = [];
    public $instruction;

    protected $listeners = [
        'paymentStatus',
    ];

    public function mount()
    {
        $this->getData();
        $this->payment_method_choices = PaymentMethod::select('name', 'id', 'description')->get();
    }

    private function getData()
    {
        $user = User::where('id', info_user_id())->with([
            'carts',
            'carts.product',
        ])->first();

        $this->total = $user->carts->sum(function ($cart) {
            return $cart->product->price ?? 0;
        });

        $this->user = $user;
        $this->carts = $user->carts;
    }

    public function updatedInputPaymentMethod($payment_method_id)
    {
        $paymentMethod = PaymentMethod::select('instruction')->where('id', $payment_method_id)->first();
        $this->instruction = $paymentMethod->instruction;
    }

    public function checkout()
    {
        try {
            DB::beginTransaction();

            $member = User::where('role', User::MEMBER)->where('id', info_user_id())->first();
            if (!$member) {
                $this->emit('onFailSweetAlert', "Data Member tidak ditemukan.");
                return;
            }

            $transaction = new Transaction();
            $transaction->user_id = $member->id;
            $transaction->payment_method_id = $this->input_payment_method;

            if ($transaction->save()) {
                DB::commit();
                return redirect()->route('member.transaction.detail', ['id' => $transaction->id]);
                
            } else {
                $this->emit('onSuccessSweetAlert', "Data Kursus gagal masuk keranjang.");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('onFailSweetAlert', "Kursus gagal masuk keranjang.");
        }
    }

    public function deleteCart($cart_id)
    {
        $cart = Cart::find($cart_id);
        $cart->delete();
        $this->getData();
        $this->emit('refreshNotification');
    }

    public function render()
    {
        return view('livewire.member.cart.index',);
    }
}
