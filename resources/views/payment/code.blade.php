@extends('layouts.parent')

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col l6 m6 s6">
                <h4 class="font-medium">Payment</h4>
            </div> 
        </div>
        <div class="row">
        <div class="card">
            <div class="card-content">
                <h5 class="card-title center">Payment Information</h5>
            </div>
            <div class="card-content bg-light">
                <div class="row center-align">
                    <div class="col s12">
                        <h5>You are successfully subscribed to <b>{{ $package->package_name }}</b>, please make a payment of <b>${{ number_format($package->package_price, 2) }}</b> to the address below via you blockchain account in order to activate this package. Once you made the payment your account will be activated in 24 hours.</h5>
                        <br><br>
                        {{\LaravelQRCode\Facades\QRCode::text($object->address)->svg()}}
                        <br><br><br><br>

                        <span class="label label-success hide-on-small-only" style="font-size: 2em;">{{ $object->address }}</span>
                        <span class="label label-success hide-on-large-only" style="font-size: 0.8em;">{{ $object->address }}</span>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <h6 class="p-t-20">Package Name</h6>
                <span>{{ $package->package_name }}</span>
                <h6 class="m-t-30">Package Price</h6>
                <span>${{ number_format($package->package_price, 2) }}</span>
                <br>
                <a href="/my-packages"><button type="button" class="m-t-20 btn waves-effect waves-light teal center">My Packages</button></a>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection