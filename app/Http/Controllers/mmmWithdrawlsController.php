<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Withdrawl;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawlsController extends Controller
{
    public function __construct() {
        $this->middleware("auth");
    }

    public function withdrawls()
    {
        if (Auth::user()->isAdmin()) {
            $withdrawls     = Withdrawl::latest()->get();
            $total          = number_format(Withdrawl::sum("amount"), 2);
            $available      = number_format(Withdrawl::where("flag", 1)->sum("amount"), 2);
            $accepted       = number_format(Withdrawl::where("flag", 2)->sum("amount"), 2);
            $rejected       = number_format(Withdrawl::where("flag", 3)->sum("amount"), 2);
            $totalRequested = 0;
        }
        else{
            $withdrawls     = Auth::user()->withdrawls()->latest()->get();
            $total          = number_format(Auth::user()->withdrawls()->sum("amount"), 2);
            $available      = number_format(Auth::user()->balance, 2);
            $totalRequested = number_format(Auth::user()->withdrawls()->where("flag", 1)->sum("amount"), 2);
            $accepted       = number_format(Auth::user()->withdrawls()->where("flag", 2)->sum("amount"), 2);
            $rejected       = number_format(Auth::user()->withdrawls()->where("flag", 3)->sum("amount"), 2);
        }
        
        return view("withdrawls.index", compact("withdrawls", "total", "available", "accepted", "rejected", "totalRequested"));
    }

    public function generate()
    {
        if (Auth::user()->btc_detail && Auth::user()->balance >= Auth::user()->min_withdrawl) {
            
            $amountToBededucted = ($user = User::where("role_id", 1)->first()) ? $user->commission : 0;

            dd($amountToBededucted);

            Withdrawl::create([
                "user_id"     => Auth::user()->id,
                "amount"      => Auth::user()->balance - $amountToBededucted,
                "btc_address" => request()->btc_address
            ]);
            
            $user = Auth::user();
            $user->balance = 0;
            $user->save();

            return back();
        }
    }

    public function accept($id)
    {
        $withdrawl = Withdrawl::find($id);
        if ($withdrawl) {
            $withdrawl->flag = 2;
            $withdrawl->save();
        }
        return back();
    }
    
    public function reject($id)
    {
        $withdrawl = Withdrawl::find($id);
        if ($withdrawl) {
            $withdrawl->flag = 3;
            $withdrawl->save();
        }
        return back();
    }

    public function update(Request $request)
    {
        $users = User::all();
        foreach ($users as $key => $user) {
            $user->min_withdrawl = $request->min_withdrawl;
            $user->commission    = $request->commission;
            $user->save();
        }
        return back();
    }
}