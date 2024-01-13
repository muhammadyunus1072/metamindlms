<?php

namespace App\Http\Livewire\Member\Cart;

use App\Models\Cart;
use App\Models\User;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $user;
    public $total;
    public $input_payment_method = [];
    public $payment_method_choices = [];

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
        ])
        ->first();
        $this->total = $user->carts->sum(function ($cart) {
            return $cart->product->price ?? 0;
        });
        $this->user = $user;
    }
    public function render()
    {
        return view('livewire.member.cart.index',);
    }

    public function checkout()
    {
        try {
            DB::beginTransaction();
            
            $member = User::where('role', User::MEMBER)->where('id', info_user_id())->first();
            if(!$member){
                $this->emit('onFailSweetAlert', "Data Member tidak ditemukan.");
                return;
            }

            $insert_data = new Transaction();
            $insert_data->user_id = $member->id;
            $insert_data->payment_method_id = $this->input_payment_method;

            if($insert_data->save()){
                DB::commit();
                return redirect()->route('member.transaction.index');
            }
            else{
                DB::rollBack();
                $this->emit('onSuccessSweetAlert', "Data Kursus gagal masuk keranjang.");
            }

        } catch (Exception $e) {

            DB::rollBack();
            $this->emit('onFailSweetAlert', "Kursus gagal masuk keranjang.");
        }
    }

    public function deleteCart($cart_id)
    {
        $cart = Cart::find($cart_id);
        $cart->delete();
        $this->getData();
    }
}
