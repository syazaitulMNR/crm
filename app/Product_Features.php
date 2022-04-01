<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Features extends Model
{
    protected $table = 'product_features';

    protected $fillable = [
        'product_features_name', 'product_features_id', 'features_price', 'features_tax', 'description_features'
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
