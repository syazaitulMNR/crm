<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessDetail extends Model
{
    protected $table = 'business_details';

    protected $fillable = [
        'ticket_id', 
        'business_role', 
        'business_type', 
        'business_amount', 
        'business_name', 
        'product_id',
        'first_name',
        'last_name',
        'ic',
        'phoneno',
        'email',
        'gender',
        'product_name'
    ];
}
