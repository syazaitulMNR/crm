<?php

namespace App\Exports;

use App\Student;
use App\Payment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithChunkReading;
// use Maatwebsite\Excel\Concerns\FromCollection;

// class StudentExport implements FromCollection
class Attendance_Download implements FromView
{

    private $productid, $packageid;

    public function __construct($product_id, $package_id){

        $this->productid = $product_id;
        $this->packageid = $package_id;
    }

    public function view(): View
    {
        $payment = Payment::where('status', 'paid')->where('product_id', $this->productid)->where('package_id', $this->packageid)->where('attendance', 'kehadiran disahkan')->get();
        $student = Student::all();


        return view('admin.reports.download_attendance', compact('payment', 'student'));
    }

    // public function chunkSize(): int
    // {
    //     return 1000;
    // }
}
