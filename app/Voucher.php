<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $fillable = [
        'voucher_id',
        'name',
        'desc',
        'tnc',
        'start_date',
        'end_date',
        'product_id',
        'package_id',
        'max',
        'img_path',
        'status'
    ];

    public function proVoucher(){
        return $this->belongsTo('App\Product','product_id','product_id');
    }

    public function pacVoucher(){
        return $this->belongsTo('App\Package','package_id','package_id');
    }
}
