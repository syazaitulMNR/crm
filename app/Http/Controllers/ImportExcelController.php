<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Exports\StudentExport;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelController extends Controller
{
    public function index()
    {
        $data = Student::orderBy('id','desc')->paginate(15);

        return view('admin.importexcel', compact('data'));
    }

    function import()
    {
        (new StudentImport)->import(request()->file('file'));

        return back()->with('success', 'The file has been inserted to queue, it may take a while to successfully import.');
    }

    public function export()
    {
        return Excel::download(new StudentExport, 'Students.xlsx');
    }
}
