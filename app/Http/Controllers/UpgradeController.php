<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpgradeController extends Controller
{
    public function choose_package(){
        return view('upgrade.choose_package');
    }
}
