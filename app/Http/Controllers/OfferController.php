<?php

namespace App\Http\Controllers;
use App\Offer;

use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view()
    {
        $offers = Offer::orderBy('id','asc')->paginate(15);
        return view('admin.viewoffer', compact('offers'));
    }

}
