<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class MidtransPaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //---------------------------
        //-----------Level-----------
        //---------------------------
        PaymentMethod::create([
            "name" => PaymentMethod::MIDTRANS_PAYMENT_METHOD,
            "description" => PaymentMethod::MIDTRANS_PAYMENT_METHOD,
            "is_editable" => false,
        ]);
    }
}
