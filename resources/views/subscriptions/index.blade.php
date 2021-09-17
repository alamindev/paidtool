@extends('layouts.parent')

@section('js')
    <script>
        $(document).ready(function(){
            $('.tabs').tabs();
        });
    </script>
@endsection

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col l6 m6 s6">
                <h4 class="font-medium">Subscriptions</h4>
            </div>
                        <div class="right-align">
                        <a href="{{route('subscriptions.add')}}" class="waves-effect waves-light btn green">New Subscription</a>
                        </div>
        </div>
        <div class="row m-t-20 card">
            <div class="row">
                <div class="col s12">
                    @if(count($subscriptions))
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Package</th>
                                        <th>Balance</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Subscription Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscriptions as $key => $user)
                                        @foreach($user->packages as $key => $subscription)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $subscription->package_name }}</td>
                                                <td>${{ number_format($user->balance, 2) }}</td>
                                                <td>${{ number_format($subscription->package_price, 2) }}</td>
                                                 @if($subscription->pivot->is_activated == 1)
                                                    <td><label class="label label-success">Activated</td>
                                                @else
                                                    <td><label class="label label-danger">Not Activate</td>
                                                @endif
                                                <td>{{ $subscription->pivot->created_at->diffForHumans() }}</td>
                                                <td>
                                                    @if($subscription->pivot->is_activated == 1)
                                                        <a href="{{ route('subscriptions.deactivate', $subscription->pivot->id) }}" class="waves-effect waves-light btn orange">Deactivate</a>
                                                    @else
                                                        <a href="{{ route('subscriptions.activate', $subscription->pivot->id) }}" class="waves-effect waves-light btn green">Activate</a>
                                                    @endif
                                                    <a href="{{ route('subscriptions.unsubscribe', $subscription->pivot->id) }}" class="waves-effect waves-light btn red">Unsubscribe</a>
                                                </td>
                                            </tr>
                                        @endforeach
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
    </div>
</div>
@endsection
