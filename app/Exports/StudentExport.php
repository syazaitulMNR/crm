<?php

namespace App\Exports;

use App\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
// use Maatwebsite\Excel\Concerns\FromCollection;

// class StudentExport implements FromCollection
class StudentExport implements FromView
{
    private $product  = [], $package = [];

    public function __construct($product_list, $package_list){
        $this->product = $product_list;
        $this->package = $package_list;
    }

    public function view(): View
    {
        return view('admin.reports.import_format', [
            'product' => $this->product,
            'package' => $this->package,
        ]);
    }

    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return Student::all();
    // }
}
