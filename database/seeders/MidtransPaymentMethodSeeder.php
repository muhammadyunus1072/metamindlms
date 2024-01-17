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
            "name" => "Midtrans",
            "description" => "Midtrans",
            "is_editable" => false,
        ]);
    }
}
