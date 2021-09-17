<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function __construct(Type $var = null) {
        $this->middleware("auth");
    }
    
    public function index(){
        return redirect("/packages");
    }
}

