<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Product;
use App\Package;
use App\Exports\StudentExport;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($product_id, $package_id)
    {
        $product = Product::where('product_id', $product_id)->first();
        $package = Package::where('package_id', $package_id)->first();
        $data = Student::orderBy('id','desc')->paginate(15);

        return view('admin.importexcel', compact('data', 'product', 'package'));
    }

    function import()
    {
        Excel::import(new UsersImport, request()->file('file'));
        // (new StudentImport)->toCollection(request()->file('file'));
        // (new StudentImport)->import(request()->file('file'));

        return back()->with('success', 'The file has been inserted to queue, it may take a while to successfully import.');
    }

    public function export()
    {
        return Excel::download(new StudentExport, 'Students.xlsx');
    }
}
