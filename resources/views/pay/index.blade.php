@extends('layouts.parent')

@section('js')
{{ $url ?? '' }}
    <script>
        $(document).ready(function(){
            $('.tabs').tabs();
        });
    </script>
@endsection

@section('content')
<?php

// unique_order_id|total_amount
$id = $package->id;
$_token = csrf_field();
$price = $package->package_price;
$plaintext = $id.'|'.$price;
$publickey = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC1mNdzfN+fbuSM6mD5Mthfh9Na
2WvmN3JR0zsvtwwlrPSokskwMls9tO1I8CBoDOAwG3JdpjXXxUTDw6eEcCSItyzr
wphMy2Rx05MZfslry3ehHbgCkuYylOWfPo+OdFLixdGYYECWVBXAZu1jK+F7uc0v
Fd18wdGk0nK1PX+48QIDAQAB
-----END PUBLIC KEY-----";
//load public key for encrypting
openssl_public_encrypt($plaintext, $encrypt, $publickey);

//encode for data passing
$payment = base64_encode($encrypt);
//checkout URL
$url = 'https://webxpay.com/index.php?route=checkout/billing';

//custom fields
//cus_1|cus_2|cus_3|cus_4
$custom_fields = base64_encode('custom_fields');

?>
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col l6 m6 s6">
                @if($package->package_price == 0)
                <h5 class="font-medium">Total Amount :  Free</h5>
                @else
                 <h5 class="font-medium">Total Amount :  {{$package->package_price}}/USD</h5>
                @endif
            </div>
        </div><hr>
        @if($package->package_price == 0)
         <form action="/packages/subscribe/" method="GET">
             {{ csrf_field() }}
             <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
             <input type="hidden" name="package_id" value="{{$package->id}}">
			First name: <input type="text" name="first_name" value="" required><br>
			Last name: <input type="text" name="last_name" value="" required><br>
			Email: <input type="text" name="email" value="" required><br>
			Contact Number: <input type="text" name="contact_number" value="" required><br>
			Address Line 1: <input type="text" name="address" value="" required><br>
			City: <input type="text" name="city" value="" required><br>
			State: <input type="text" name="state" value="" required><br>
			Zip/Postal Code: <input type="text" name="postal_code" value="" required><br>
			Country: <input type="text" name="country" value="" required><br>                      
			<button type="submit" class="waves-effect waves-light btn green">Get It Free</button>
        </form>   
       @else
       <form action="<?php echo $url; ?>" method="POST">
             {{ csrf_field() }}
             <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
			First name: <input type="text" name="first_name" value="" required><br>
			Last name: <input type="text" name="last_name" value="" required><br>
			Email: <input type="text" name="email" value="" required><br>
			Contact Number: <input type="text" name="contact_number" value="" required><br>
			Address Line 1: <input type="text" name="address_line_one" value="" required><br>
			Address Line 2: <input type="text" name="address_line_two" value="" required><br>
			City: <input type="text" name="city" value="" required><br>
			State: <input type="text" name="state" value="" required><br>
			Zip/Postal Code: <input type="text" name="postal_code" value="" required><br>
			Country: <input type="text" name="country" value="" required><br>
		    <input type="hidden" name="process_currency" value="USD"><br> <!-- currency value must be LKR or USD -->
			<input type="hidden" name="cms" value="PHP">
			<input type="hidden" name="custom_fields" value="{{Auth::user()->id}}">
			<input type="hidden" name="enc_method" value="JCs3J+6oSz4V0LgE0zi/Bg==">
			<br/>		   
			<!-- POST parameters -->
			<input type="hidden" name="secret_key" value="e1c84bd5-fd12-4835-8863-a3707cfb0f8c" >  
			<input type="hidden" name="payment" value="<?php echo $payment; ?>" >                         
			<button type="submit" class="waves-effect waves-light btn green">Pay Now</button>
        </form>  
       @endif

@endsection