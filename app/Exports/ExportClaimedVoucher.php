<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use App\Voucher;
use App\VoucherClaimed;
use App\Student;
use App\Product;
use App\Package;

class ExportClaimedVoucher implements FromView
{
    public function __construct(string $voucher_id)
    {
        $this->voucher_id = $voucher_id;

        return $this;
    }

    public function view(): View
    {
        $voucher = Voucher::where('voucher_id', $this->voucher_id)->get();
        $claimeds = VoucherClaimed::where('voucher_id', $this->voucher_id)->orderBy('series_no', 'asc')->get();

        return view('admin.reports.download_claimedvoucher',compact('voucher', 'claimeds'));
    }
}
