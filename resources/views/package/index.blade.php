@extends('layouts.parent')

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        @if(Session::has("error"))
            <div class="alert alert-danger">{{ Session::get("error") }}</div>
        @elseif(Session::has("success"))
            <div class="alert alert-success">{{ Session::get("success") }}</div>
        @endif
        <div class="row">
            <div class="col l6 m6 s6">
            @if(!Auth::user()->isAdmin())
                <h4 class="font-medium">Dashboard</h4>
            @else
                <h4 class="font-medium">Packages</h4>
            @endif
            </div>
            <div class="right-align">
                @if(Auth::user()->isAdmin())
                    <a href="{{route('addPackage')}}" class="waves-effect waves-light btn green">New Package</a>
                @endif
            </div>    
        </div>

        @if(!Auth::user()->isAdmin())
            <div class="row">
                <div class="col l3 m6">
                    <div class="card">
                        <div class="card-content center-align">
                            <div>
                                <span class="green-text display-6"><i class="ti-map-alt"></i></span>
                            </div>
                            <div class="">
                                <h4>${{ $total }}</h4>
                                <h6 class="green-text font-medium m-b-0">Total</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col l3 m6">
                    <div class="card">
                        <div class="card-content center-align">
                            <div>
                                <span class="black-text display-6"><i class="ti-check-box"></i></span>
                            </div>
                            <div>
                                <h4>${{ $available }}</h4>
                                <h6 class="black-text font-medium m-b-0">Aavailable</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col l3 m6">
                    <div class="card">
                        <div class="card-content center-align">
                            <div>
                                <span class="blue-text display-6"><i class="ti-bar-chart-alt"></i></span>
                            </div>
                            <div>
                                <h4>${{ $accepted }}</h4>
                                <h6 class="blue-text font-medium m-b-0">Accepted</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col l3 m6">
                    <div class="card">
                        <div class="card-content center-align">
                            <div>
                                <span class="cyan-text display-6"><i class="ti-receipt"></i></span>
                            </div>
                            <div>
                                <h4>${{ $rejected }}</h4>
                                <h6 class="cyan-text font-medium m-b-0">Rejected</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="row">
            @if(count($packages))
                @foreach($packages as $package)
                <div class="col l4 m6 s12 m-t-20">
                    <div class="card">
                        <div class="card-content">
                            <h5 class="card-title center-align">{{ $package->package_name }}</h5>
                            @if($package->package_price == 0)
                                    <h3 class="text-warning center-align" style="color:#F36645">Free</h3>
                                    @else
                                    <h3 class="text-warning center-align" style="color:#F36645">${{ number_format($package->package_price, 2) }}</h3>
                                    @endif
                            <div class="profile-pic m-b-20 m-t-20 center-align">
                                <img src="https://ui-avatars.com/api/?background=273146&color=fff&size=128&name={{$package->package_name}}" width="100" class="circle" alt="user">
                            </div>
                            <div class="row m-t-20">
                                <div class="col l6 m6 s6">
                                    <h6>Package ID</h6>
                                </div>
                                <div class="col l6 m6 s6 right-align">
                                    <span class="label label-info">{{ $package->id }}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col l6 m6 s6">
                                    <h6>Work Type</h6>
                                </div>
                                <div class="col l6 m6 s6 right-align">
                                    <span class="label label cyan">{{ $package->work_type }}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col l6 m6 s6">
                                    <h6>Contract</h6>
                                </div>
                                <div class="col l6 m6 s6 right-align">
                                    <span class="label label cyan">{{ $package->contract_period }} years</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col l6 m6 s6">
                                    <h6>Tasks Per Day</h6>
                                </div>
                                <div class="col l6 m6 s6 right-align">
                                    <span class="label label cyan">{{ $package->total_task }} tasks</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col l6 m6 s6">
                                    <h6>Pay Per Task</h6>
                                </div>
                                <div class="col l6 m6 s6 right-align">
                                    <span class="label label cyan">${{ number_format($package->payment_task, 2) }}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row m-t-10">
                                <div class="col l6 m6 s6">
                                    <h6>Price</h6>
                                </div>
                                <div class="col l6 m6 s6 right-align">
                                    @if($package->package_price == 0)
                                    <span class="label label-warning">Free</span>
                                    @else
                                    <span class="label label-warning">${{ number_format($package->package_price, 2) }}</span>
                                    @endif
                                </div>
                            </div>

                            @if(Auth::user()->isAdmin())
                            <div class="row m-t-10">
                                <div class="col l6 m6 s6">
                                    <h6>Subscriptions</h6>
                                </div>
                                <div class="col l6 m6 s6 right-align">
                                    <span class="label label-warning">{{ count($package->users) }} subscriptions</span>
                                </div>
                            </div>
                            @endif

                            @if(Auth::user()->isAdmin())
                            <div class="row m-t-10">
                                <div class="col l6 m6 s6">
                                    <h6>Tasks Not Sent</h6>
                                </div>
                                <div class="col l6 m6 s6 right-align">
                                    <span class="label label-warning">{{ $tasks->where('package_id', $package->id )->count() }} tasks</span>
                                </div>
                            </div>
                            @endif
                            
                        </div>
                        <div class="p-25 b-t">
                            @if(Auth::user()->role_id == 1)
                            
                            <div class="row center-align">
                                <div class="col s3 b-r">
                                    <a href="/packages/edit/{{$package->id}}" class="waves-effect waves-light btn orange">Edit</a>
                                </div>
                                <div class="col s3 b-r">
                                    <a href="/packages/delete/{{$package->id}}" class="waves-effect waves-light btn red">Delete</a>
                                </div>
                                <div class="col s3">
                                    
                                    <a title="Send Task" href="/package/send/{{$package->id}}" class="waves-effect waves-light btn green">Send Task</a>
                                </div>
                                <div class="col s3">
                                    <a title="View Task" href="{{route('tasks', $package->id)}}" class="waves-effect waves-light btn blue">View Task</a>
                                </div>
                            </div>
                            @else 
                            <div class="row center-align">
                                <!--<a href="{{ route('packages.subscribe', $package->id) }}" class="waves-effect waves-light btn green">Subscribe now</a> -->
                                
                                <a href="{{ route('pay', $package->id) }}" class="waves-effect waves-light btn green">Subscribe now</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="card p-40 center">
                    <h4>No Records Found</h4>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection