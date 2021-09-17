<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;
use App\Package;
use Carbon\Carbon;

class SubscriptionsController extends Controller
{
    public function __construct() {
        $this->middleware("auth");
    }

    public function subscriptions()
    {
        $subscriptions = User::with("packages")->latest()->get();
        return view("subscriptions.index", compact("subscriptions"));
    }

    public function activate($id)
    {
        $subscription = DB::table("package_user")->find($id);
        if ($subscription) {
            DB::table('package_user')
              ->where('id', $id)
              ->update(['is_activated' => 1]);
        }
        return back();
    }
    
    public function deactivate($id)
    {
        $subscription = \DB::table("package_user")->find($id);
        if ($subscription) {
            DB::table('package_user')
              ->where('id', $id)
              ->update(['is_activated' => 0]);
        }
        return back();
    }
    
    public function unsubscribe($id)
    {
        $subscription = \DB::table("package_user")->find($id);
        if ($subscription) {
            DB::table('package_user')
              ->where('id', $id)
              ->delete();
        }
        return back();
    }

    public function addSubscription(){
        $packages = Package::all();
        $users = User::where('role_id',2)->get();
        return view('subscriptions.addSubscription',compact('packages','users'));
    }

    public function newSubscription(Request $rquest){
       

    }

    public function saveSubscription(Request $request){
        $subscription = DB::table("package_user")->where("package_id", $request->package_id)->where("user_id", $request->user_id)->first();
        if (!$subscription) {
          
            \DB::table('package_user')->insert([
                "user_id"        => $request->user_id,
                "package_id"     => $request->package_id,
                "is_activated"   => 1,
                "invoice_id"     => "Manual",
                "address"        => "Manual",
                "payment_status" => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);
          
    $pp = Package::where('id',$request->package_id)->first();
        $user = User::where('id',$request->user_id)->first();
        if($user->ref !='0'){
            $refuser = User::where('id',$user->ref)->first();
            $com = ($pp->package_price * $pp->com) /100;
            $refuser->balance = $refuser->balance + $com;
             $refuser->refcommission = $refuser->refcommission + $com;
            $refuser->save();
            
            
        }
        }
        return redirect(route('subscriptions'));

    }
}