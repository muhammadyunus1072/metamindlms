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

class Detail extends Component
{
    use WithFileUploads;

    public $paymend_method_id;
    public $paymend_method_name;
    public $paymend_method_description;
    public $paymend_method_instruction;

    protected $listeners = [
        'addFilter',
    ];

    public function addFilter($filter)
    {
        foreach ($filter as $key => $value) {
            $this->$key = $value;
        }
    }

    public function mount($paymend_method_id = null)
    {
        if($paymend_method_id)
        {
            $paymend_method = PaymentMethod::find($paymend_method_id);
            if($paymend_method)
            {
                $this->paymend_method_id = $paymend_method->id;
                $this->paymend_method_name = $paymend_method->name;
                $this->paymend_method_description = $paymend_method->description;
                $this->paymend_method_instruction = $paymend_method->instruction;
            }
        }
    }

    public function store()
    {
        if($this->paymend_method_id)
        {
            $paymend_method = PaymentMethod::find($this->paymend_method_id);
        }else{
            $paymend_method = new PaymentMethod();
        }
        $paymend_method->name = $this->paymend_method_name;
        $paymend_method->description = $this->paymend_method_description;
        $paymend_method->instruction = $this->paymend_method_instruction;
        if($paymend_method->save())
        {
            $this->emit('onSuccessSweetAlert', 'Berhasil Menyimpan Data');
        }else{
            $this->emit('onFailSweetAlert', 'Gagal Menyimpan Data');
        }
    }

    public function render()
    {
        return view('livewire.admin.payment-method.detail',);
    }

}
