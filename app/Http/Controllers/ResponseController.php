<?php

namespace App\Http\Controllers;
use DB;
use App\User;
use App\AddPackage;
use App\Package;
use App\CheckPackage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ResponseController extends Controller
{   
    

    public function index(Request $request)
    {

    //decode & get POST parameters
$payment = base64_decode($_POST ["payment"]);
$signature = base64_decode($_POST ["signature"]);
$custom_fields = base64_decode($_POST ["custom_fields"]);
$status = $_POST["status_code"];
//load public key for signature matching
$publickey = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC1mNdzfN+fbuSM6mD5Mthfh9Na
2WvmN3JR0zsvtwwlrPSokskwMls9tO1I8CBoDOAwG3JdpjXXxUTDw6eEcCSItyzr
wphMy2Rx05MZfslry3ehHbgCkuYylOWfPo+OdFLixdGYYECWVBXAZu1jK+F7uc0v
Fd18wdGk0nK1PX+48QIDAQAB
-----END PUBLIC KEY-----";
openssl_public_decrypt($signature, $value, $publickey);

$signature_status = false ;
if($value == $payment){
	$signature_status = true ;
}

//get payment response in segments
//payment format: order_id|order_refference_number|date_time_transaction|payment_gateway_used|status_code|comment;
$responseVariables = explode('|', $payment);      

if($status == 00)
{
        $package = new AddPackage();
        $package->user_id = $request->custom_fields;
        $package->package_id = $request->order_id;
        $package->is_activated = '1';
        $package->save();
        $pp = Package::where('id',$request->order_id)->first();
        $user = User::where('id',$package->user_id)->first();
        if($user->ref !='0'){
            $refuser = User::where('id',$user->ref)->first();
            $com = ($pp->package_price * $pp->com) /100;
            $refuser->balance = $refuser->balance + $com;
             $refuser->refcommission = $refuser->refcommission + $com;
            $refuser->save();
            
            
        }
        
      // }
        
        return redirect('packages');
}else
{
	echo 'Payment Declined - Please try an alternative card'; 
}
	
	
    }
}