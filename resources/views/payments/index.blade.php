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
                <h4 class="font-medium">Payment History</h4>
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
                                        <th>Package</th>
                                        <th>Amount</th>
                                        <th>Invoice</th>
                                        <th>BTC Token</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscriptions as $key => $user)
                                        @foreach($user->packages as $key => $subscription)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $subscription->package_name }}</td>
                                                <td><label class="label label-info">${{ number_format($subscription->package_price, 2) }}</label></td>
                                                <td><label class="label cyan">{{ $subscription->pivot->invoice_id }}</label></td>
                                                <td><label class="label label-info">{{ $subscription->pivot->address }}</label></td>
                                                @if($subscription->pivot->payment_status == 1)
                                                    <td><label class="label label-success">Payment Made</td>
                                                @else
                                                    <td><label class="label label-success">Payment Made</td>
                                                @endif
                                                <td>{{ $subscription->pivot->created_at->diffForHumans() }}</td>
                                                <td>{{ $subscription->pivot->updated_at->diffForHumans() }}</td>
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