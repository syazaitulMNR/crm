<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $fillable = [
        'payment_id', 'totalprice', 'quantity', 'status', 'update_count', 'pay_method', 'stud_id', 'product_id', 'package_id', 'stripe_id'
    ];
}
