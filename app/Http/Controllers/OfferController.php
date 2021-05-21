<?php

namespace App\Http\Controllers;
use Offer;

use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

}
