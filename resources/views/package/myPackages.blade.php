@extends('layouts.parent')

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col l6 m6 s6">
                <h4 class="font-medium">My Packages</h4>
            </div> 
        </div>
        <div class="card p-20">
            @if(count($packages))
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Payment Method</th>
                            <th>Tasks Per Day</th>
                            <th>Price Per Task</th>
                            <th>Status</th>
                            <th>Subscription Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($packages as $index => $package)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td><span class="label cyan">{{ $package->package_name }}</span></td>
                            <td>${{ number_format($package->package_price, 2) }}</td>
                            <td><span class="label label-info">Debit</span></td>
                            <td>{{ $package->total_task }}</td>
                            <td>${{ number_format($package->payment_task, 2) }}</td>
                            @if($package->pivot->is_activated == 1)
                                <td><span class="label label-success">Active</span></td>
                            @else
                                <td title="Waiting for the payment"><span class="label label-danger">Not Active</span></td>
                            @endif
                            <td>{{ $package->pivot->created_at->diffForHumans() }}</td>
                            <td>
                                @if($package->pivot->is_activated == 1)
                                    <a href="{{route('tasks', $package->id)}}" class="waves-effect waves-light btn cyan">Tasks</a>
                                @endif
                                <a href="{{ route('packages.unSubscribe', $package->id) }}" class="waves-effect waves-light btn red">Unsubscribe</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>   
                </table>
            </div>
            @else
                <div class="card p-40 center">
                    <h4>No Records Found</h4>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection