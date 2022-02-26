<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'invoice_id', 'price', 'for_date', 'status', 'description_features', 'product_features_name', 'product_features_id', 'student_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
