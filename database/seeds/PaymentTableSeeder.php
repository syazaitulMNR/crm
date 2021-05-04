<?php

use Illuminate\Database\Seeder;
use App\Payment;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::create([
            'payment_id' => 'OD001',
            'pay_price' => '999',
            'totalprice' => '999',
            'quantity' => '1',
            'status' => 'succeeded',
            'upgrade_count' => '',
            'update_count' => '',
            'stud_id' => 'MI001',
            'product_id' => 'PRD001',
            'package_id' => 'PKD001',
            'stripe_id' => 'cus_001',
        ]);
    }
}
