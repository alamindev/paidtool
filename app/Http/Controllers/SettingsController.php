<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct() {
        $this->middleware("auth");
    }

    public function settings()
    {
        return view("settings.index");
    }

    public function btcDetailsUpdate(Request $request)
    {
        $btc_details = Auth::user()->btc_detail;
        $btc_details->pub_key = $request->pub_key;
        $btc_details->api_key = $request->api_key;
        $btc_details->save();
        return back();
    }
}