<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'invoice_id', 'price', 'for_date', 'status', 'tax', 'taxable_amount', 'product_features_name', 'product_features_id', 'student_id', 'quantity'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
