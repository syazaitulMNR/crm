<?php

namespace App\Http\Controllers;

use App\VoucherClaimed;
use Illuminate\Http\Request;
use App\Voucher;
use App\Product;
use App\Package;
use App\Student;
use App\Ticket;
use DB;
use PDF;

class VoucherClaimedController extends Controller
{
    public function ic_check($voucher_id)
    {
        $voucher = Voucher::where('voucher_id', $voucher_id)->first();

        if($voucher->status == 'Active')
        {
            return view('customer_voucher.one_getic', compact('voucher'));
        } else {
            return view('customer_voucher.deactive');
        }
            

    }

    public function checking_ic($voucher_id, Request $request)
    {
        $voucher = Voucher::where('voucher_id', $voucher_id)->first();
        $student = Student::where('ic', $request->ic)->first();

        if ($voucher->product_id == null && $voucher->package_id == null) {
            if ($student != null) {
                return redirect('voucher/details/' . $voucher_id . '/' . $student->stud_id);
            } else {
                return view('customer_voucher.not_found');
            }
        } elseif ($voucher->product_id != null && $voucher->package_id == null) {

            $ticket = Ticket::where('product_id', $voucher->product_id)->where('ic', $request->ic)->first();
            if($ticket != null)
            {
                return redirect('voucher/details/' . $voucher_id . '/' . $ticket->stud_id);
            } else {
                return view('customer_voucher.not_found');
            }

        } elseif ($voucher->product_id != null && $voucher->package_id != null) {

            $ticket = Ticket::where('product_id', $voucher->product_id)->where('package_id', $voucher->package_id)->where('ic', $request->ic)->first();
            if($ticket != null)
            {
                return redirect('voucher/details/' . $voucher_id . '/' . $ticket->stud_id);
            } else {
                return view('customer_voucher.not_found');
            }
        }
    }

    public function voucher_form($voucher_id, $stud_id) {
        $student = Student::where('stud_id', $stud_id)->first();
        $voucher = Voucher::where('voucher_id', $voucher_id)->first();

        $claimed = VoucherClaimed::where('voucher_id', $voucher_id)->where('stud_id', $student->stud_id)->first();
        $totalClaim = VoucherClaimed::where('voucher_id', $voucher_id)->count();

        if($voucher->max == null)
        {
            return view('customer_voucher.two_detailform', compact('student', 'voucher', 'claimed'));
        } else {
            if($totalClaim > $voucher->max)
            {
                return view('customer_voucher.overlimit');
            } else {
                return view('customer_voucher.two_detailform', compact('student', 'voucher', 'claimed'));
            }
        }
    }

    public function voucher_save($voucher_id, $stud_id, Request $request) {
        $student = Student::where('stud_id', $stud_id)->first();
        $seriesNum = VoucherClaimed::orderBy('series_no','desc')->where('voucher_id', $voucher_id)->first();
        $claimed = VoucherClaimed::where('voucher_id', $voucher_id)->where('stud_id', $stud_id)->first();
        
        if ($claimed != null) {
            $student->ic            = $request->ic;
            $student->first_name    = $request->first_name;
            $student->last_name     = $request->last_name;
            $student->email         = $request->email;
            $student->phoneno       = $request->phoneno;

            $student->save();

            return redirect('claimed_success/' . $voucher_id . '/' . $stud_id . '/' . $claimed->series_no)->with('Done');

        } else {

            if(!empty($seriesNum)) {
                $seriesNo = $seriesNum->series_no + 1;
            } else {
                $seriesNo = '1001';
            }

            $student->ic            = $request->ic;
            $student->first_name    = $request->first_name;
            $student->last_name     = $request->last_name;
            $student->email         = $request->email;
            $student->phoneno       = $request->phoneno;

            $student->save();
    
            VoucherClaimed::create([
                'series_no'     => $seriesNo,
                'voucher_id'    => $voucher_id,
                'stud_id'       => $stud_id,
                'fb_page'       => $request->fb_page,
                'status'        => 'In Progress'
            ]);
    
            return redirect('claimed_success/' . $voucher_id . '/' . $stud_id . '/' . $seriesNo);
        }
    }

    public function voucher_success($voucher_id, $stud_id, $series_no) {
        $student = Student::where('stud_id', $stud_id)->first();
        $voucher = Voucher::where('voucher_id', $voucher_id)->first();
        $claimed = VoucherClaimed::where('series_no', $series_no)->first();

        return view('customer_voucher.claimed_success', compact('voucher_id', 'stud_id', 'series_no', 'student', 'voucher', 'claimed'));
    }

    public function extract_voucher($voucher_id, $stud_id, $series_no){
        $student = Student::where('stud_id', $stud_id)->first();
        $voucher = Voucher::where('voucher_id', $voucher_id)->first();
        $claimed = VoucherClaimed::where('series_no', $series_no)->first();
            
        //data in voucher
        // $data['img_path']   = $voucher->img_path;
        // $data['name']       = $voucher->name;

        // $data['series_no']  = $claimed->series_no;
        // $data['created_at'] = date('d/m/Y g:i A', strtotime($claimed->created_at. '+8hours'));

        // $data['first_name']=$student->first_name;
        // $data['last_name']=$student->last_name;
        // $data['ic']=$student->ic;

        // $pdf = PDF::loadView('customer_voucher.evoucher', compact('student', 'voucher', 'claimed')('student', 'voucher', 'claimed'));
        // return $pdf->download( $voucher->name . '.pdf');

        $pdf = PDF::loadView('customer_voucher.evoucher', compact('student', 'voucher', 'claimed'))->setPaper('a4', 'landscape');
        // return $pdf->download( 'pdf-download-voucher.pdf');
    }

}