<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherClaimed extends Model
{
    protected $table = 'voucher_claimeds';

    protected $fillable = [
        'series_no',
        'voucher_id',
        'stud_id',
        'fb_page',
        'status'
    ];

    public function studClaim(){
        return $this->belongsTo('App\Student','stud_id','stud_id');
    }

    public function voucher(){
        return $this->belongsTo('App\Voucher','voucher_id','voucher_id');
    }
}
