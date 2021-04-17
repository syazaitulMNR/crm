<?php

namespace App\Exports;

use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProgramExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection($product_id)
    {
        return Payment::where('product_id', $product_id)->get();
    }
}
