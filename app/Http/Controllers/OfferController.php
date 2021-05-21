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

    public function create(Request $request)
    {
        $offers = Offer::orderBy('id','desc');
        
        dd($offers);
        // $auto_inc_offer = $offers->id + 1;
        // $offer_id = 'OFF' . 0 . 0 . $auto_inc_offer;

        // Offer::create([
        //     'offer_id' => $offer_id,
        //     'name' => $request->name
        // ]);

        // return redirect('view-offer')->with('add-success', 'Offer Successfully Created');
    }

}
