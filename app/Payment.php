<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $fillable = [
        'payment_id', 'pay_price', 'totalprice', 'quantity', 'status', 'upgrade_count', 'update_count', 'attendance', 'pay_method', 'email_status', 'stud_id', 'product_id', 'package_id', 'offer_id', 'bankname', 'date_payment', 'cheque_no', 'membership_id', 'level_id', 'stripe_id', 'billplz_id', 'user_id', 'user_invite','pay_datetime'
    ];
}
