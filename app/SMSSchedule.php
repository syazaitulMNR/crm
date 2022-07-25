<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSSchedule extends Model
{
    protected $table = 'sms_schedule';
	
	protected $fillable = [
        'name', 'product_id', 'template_id', 'date', 'time', 'day_before', 'status'
    ];

    public function smstemp(){
        return $this->belongsTo('App\SMSTemplateModel','template_id','id');
    }

    public function products(){
        return $this->belongsTo('App\Product','product_id','product_id');
    }
}