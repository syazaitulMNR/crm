<?php

namespace App\Http\Controllers;

use App\Voucher;
use Illuminate\Http\Request;
use App\VoucherClaimed;
use App\Student;
use App\Product;
use App\Package;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportClaimedVoucher;
use App\Exports\SurveyFormExport;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // MANAGE VOUCHER //////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function index()
    {
        $vouchers = Voucher::orderBy('id','desc')->paginate(15);
        $links = 'https://mims.momentuminternet.my/voucher/';

        return view('admin.voucher.indexvoucher', compact('vouchers', 'links'));
    }

    public function create()
    {
        $products = \DB::table('product')->orderby('id','desc')->get();

        return view('admin.voucher.createvoucher', compact('products'));
    }

    public function getPackage(Request $request) 
    {
        $packages = \DB::table('package')->where('product_id', $request->product_id)->orderBy('id','asc')->get();
        
        if (count($packages) > 0) {
            return response()->json($packages);
        }
    }

    public function store(Request $request)
    {
        $voucher = Voucher::orderBy('id','desc')->first();
        $check_image = $request->img_path;
        
        if (empty($check_image)) {
            $img_path = null;

        } else {
            $imagename = 'img_' . uniqid().'.'.$request->img_path->extension();
            $img_path = 'https://mims.momentuminternet.my/assets/images/voucher/' . $imagename;
            $request->img_path->move(public_path('assets/images/voucher'), $imagename);
        }

        if(!empty($voucher)) {
            $auto_inc_vch = $voucher->id + 1;
            $voucherId = 'VCH' . 0 . 0 . $auto_inc_vch;
        } else {
            $voucherId = 'VCH001';
        }

        Voucher::create([
            'voucher_id'    => $voucherId,
            'name'          => $request->name,
            'desc'          => $request->desc,
            'tnc'           => $request->tnc,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'product_id'    => $request->product_id,
            'package_id'    => $request->package_id,
            'max'           => $request->max,
            'img_path'      => $img_path,
            'status'        => $request->status
        ]);

        return redirect('/managevoucher')->with('success', 'Voucher Successfully Created');
    }

    public function edit($id)
    {
        $voucher = Voucher::where('voucher_id', $id)->first();
        $products = \DB::table('product')->orderby('id','desc')->get();

        return view('admin.voucher.editvoucher', compact('voucher', 'products'));
    }

    public function getPackageEdit(Request $request) 
    {
        $packages = \DB::table('package')->where('product_id', $request->product_id)->orderBy('id','asc')->get();
        
        if (count($packages) > 0) {
            return response()->json($packages);
        }
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::where('voucher_id', $id)->first();

        $check_image = $request->img_path;
        
        if (empty($check_image)) {
            $voucher->name          = $request->name;
            $voucher->desc          = $request->desc;
            $voucher->tnc           = $request->tnc;
            $voucher->start_date    = $request->start_date;
            $voucher->end_date      = $request->end_date;
            $voucher->product_id    = $request->product_id;
            $voucher->package_id    = $request->package_id;
            $voucher->max           = $request->max;
            $voucher->status        = $request->status;

        } else {
            $imagename = 'img_' . uniqid().'.'.$request->img_path->extension();
            $img_path = 'https://mims.momentuminternet.my/assets/images/voucher/' . $imagename;
            $request->img_path->move(public_path('assets/images/voucher'), $imagename);

            $voucher->name          = $request->name;
            $voucher->desc          = $request->desc;
            $voucher->tnc           = $request->tnc;
            $voucher->start_date    = $request->start_date;
            $voucher->end_date      = $request->end_date;
            $voucher->product_id    = $request->product_id;
            $voucher->package_id    = $request->package_id;
            $voucher->max           = $request->max;
            $voucher->img_path      = $img_path;
            $voucher->status        = $request->status;
        }

        $voucher->save();

        return redirect('voucher/edit/'.$voucher->voucher_id)->with('success', 'Voucher Successfully Updated');
    }

    public function destroy($id)
    {
        $voucher = Voucher::where('voucher_id', $id);

        $voucher->delete();

        return redirect('managevoucher')->with('delete', 'Voucher Successfully Deleted');
    }

    // REPORT CLAIMED VOUCHER ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function viewvoucher()
    {
        $vouchers = Voucher::orderBy('id','desc')->paginate(15);

        return view('admin.voucher.report', compact('vouchers'));
    }

    public function viewclaimed($voucher_id)
    {
        $voucher = Voucher::where('voucher_id', $voucher_id)->first();
        $claimed = VoucherClaimed::where('voucher_id', $voucher_id)->orderBy('series_no', 'desc')->paginate(15);
        // $students = Student::orderBy('id','desc')->get();

        // $today = Carbon::now()->format('Y-m-d');
        $today = Carbon::now()->subDays(14)->format('Y-m-d');
        $totalall = VoucherClaimed::where('voucher_id', $voucher_id)->count();
        $inprogress = VoucherClaimed::where('voucher_id', $voucher_id)->where('status', 'In Progress')->count();
        $complete = VoucherClaimed::where('voucher_id', $voucher_id)->where('status', 'Complete')->count();
        $pending = VoucherClaimed::where('voucher_id', $voucher_id)->where('status', 'In Progress')->where('created_at', '<' , $today)->count();

        return view('admin.voucher.reportvoucher', compact('voucher_id', 'voucher', 'claimed', 'today', 'totalall', 'inprogress', 'complete', 'pending'));
    }

    public function detailclaim($voucher_id, $series_no)
    {
        // $voucher = Voucher::where('voucher_id', $voucher_id)->first();
        $claimed = VoucherClaimed::where('voucher_id', $voucher_id)->where('series_no', $series_no)->first();
        // $student = Student::where('stud_id', $claimed->stud_id)->first();

        $today = Carbon::now()->subDays(14)->format('Y-m-d');

        return view('admin.voucher.reportclaimed', compact('voucher_id', 'series_no', 'claimed', 'today'));
    }

    public function updateClaimed($voucher_id, $series_no)
    {
        $claimed = VoucherClaimed::where('voucher_id', $voucher_id)->where('series_no', $series_no)->first();

        $claimed->status = 'Complete';
        $claimed->save();

        return redirect()->back()->with('success', 'Voucher Status Successfully Updated');
    }

    public function deleteClaimed($voucher_id, $series_no)
    {
        $claimed = VoucherClaimed::where('voucher_id', $voucher_id)->where('series_no', $series_no)->first();

        $claimed->delete();

        return redirect()->back()->with('success', 'Voucher Successfully Deleted');
    }

    public function updateStudent(Request $request, $stud_id)
    {
        $student = Student::where('stud_id', $stud_id)->first();

        $student->ic            = $request->ic;
        $student->phoneno       = $request->phoneno;
        $student->first_name    = $request->first_name;
        $student->last_name     = $request->last_name;
        $student->email         = $request->email;

        $student->save();

        return redirect()->back()->with('success', 'Student Detail Has Successfully Updated');
    }

    // Export Claimed Voucher List to Excel
    public function exportClaimed($voucher_id)
    {   
        $voucher = Voucher::where('voucher_id', $voucher_id)->first();

        return Excel::download(new ExportClaimedVoucher($voucher_id), '' .$voucher->name.' - ClaimedList.xlsx');
    }
}
