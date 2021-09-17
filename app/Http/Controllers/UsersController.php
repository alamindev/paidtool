<?php

namespace App\Http\Controllers;

use App\User;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function __construct() {
        $this->middleware("auth");
    }

    public function users()
    {
        $users = User::with("packages")->where("role_id", 2)->get();
        return view("users.index", compact("users"));
    }
   
    public function createForm()
    {
        return view("users.add");
    }
    
    public function create(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'    => ['required', 'digits_between:8,16'],
            'address'  => ['required', 'string', 'max:250'],
            'country'  => ['required', 'string', 'max:50'],
        ]);
        
        User::create([
            "name"     => $request->name,
            "email"    => $request->email,
            "phone"    => $request->phone,
            "country"  => $request->country,
            "address"  => $request->address,
            "password" => Hash::make("admin@123"),
        ]);

        return redirect("/users");
    }
    
    public function uploadSheet(Request $request)
    {
        Excel::import(new UsersImport, $request->file("users_sheet"));
        return redirect("/users");
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view("users.edit", compact("user"));
    }
    
    public function update($id, Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.Auth::user()->id],
            'phone'    => ['required', 'digits_between:8,16'],
            'address'  => ['required', 'string', 'max:250'],
            'country'  => ['required', 'string', 'max:50'],
        ]);

        $user          = User::find($id);
        $user->name    = request()->name;
        $user->email   = request()->email;
        $user->phone   = request()->phone;
        $user->address = request()->address;
        $user->country = request()->country;
        $user->save();

        return back();
    }
}