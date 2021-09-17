<?php

namespace App\Http\Controllers;
use App\Task;
use App\User;
use App\Package;
use Carbon\Carbon;
use App\AssignedTask;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayController extends Controller
{
    public function __construct() {
        $this->middleware("auth");
    }
    
    public function index($package){
        $package = Package::find($package);
        return view('pay.index', compact('package')); 
    }
    public function create(request $request){
        $input = $request->input();
        $first_name = 'Hamza';
        $last_name = 'Zafar';
        $email = 'email.com';
        $contact_number = '6765';
        $secret = 'e1c84bd5-fd12-4835-8863-a3707cfb0f8c';
        $cms = 'php';
        
$plaintext = '525|10';
$publickey = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC1mNdzfN+fbuSM6mD5Mthfh9Na
2WvmN3JR0zsvtwwlrPSokskwMls9tO1I8CBoDOAwG3JdpjXXxUTDw6eEcCSItyzr
wphMy2Rx05MZfslry3ehHbgCkuYylOWfPo+OdFLixdGYYECWVBXAZu1jK+F7uc0v
Fd18wdGk0nK1PX+48QIDAQAB
-----END PUBLIC KEY-----";
openssl_public_encrypt($plaintext, $encrypt, $publickey);

$payment = base64_encode($encrypt);
$url = 'https://webxpay.com/index.php?route=checkout/billing';
$parameters      = 'first_name=' .$first_name. '&last_name=' .$last_name. '&email=' .$email. '&contact_number=' .$contact_number. 
'&secret_key=' .$secret. '&payment=' .$payment. '&cms=' .$cms. '&process_currency = usd';
return redirect($url);
$custom_fields = base64_encode($input);

    }

}