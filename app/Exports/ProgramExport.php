<?php

namespace App\Exports;

use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProgramExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection($payment)
    {
        return Payment::where('product_id', $payment)->get();
    }
}
