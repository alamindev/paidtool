<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    public function __construct() {
        $this->middleware("auth");
    }

    public function payments()
    {
        if (Auth::user()->isAdmin()) {
            $subscriptions = User::with("packages")->latest()->get();
        }
        else{
            $subscriptions = User::with("packages")->whereHas("packages", function($query){
                $query->where("user_id", Auth::user()->id);
            })->latest()->get();
        }

        return view("payments.index", compact("subscriptions"));
    }
}