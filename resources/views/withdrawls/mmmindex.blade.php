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
                <h4 class="font-medium">Withdrawls</h4>
            </div>
        </div>

        <div class="row m-t-20">
            <div class="col s12">
                <div class="alert blue text-white">
                    Minimum withdrawl is <b>${{number_format(Auth::user()->min_withdrawl, 2)}}</b> and system will deduct <b>${{ number_format(Auth::user()->commission, 2) }}</b> on each withdrawl as per service fee.
                </div>
            </div>
        </div>

        @if(Auth::user()->isAdmin())
            <div class="row card">
                <div class="col s12">
                    <form method="POST" action="/withdrawls/update">
                        @csrf
                        <div class="form-body">
                            <div class="card m-t-30 card-content">
                                <div class="row m-t-20">
                                    <div class="input-field col s12">
                                        <input id="min_withdrawl" value="{{ old('min_withdrawl') }}" name="min_withdrawl" type="number" class="validate" placeholder="e.g. $100" required>
                                        <label for="min_withdrawl">Min Withdrawl</label>
                                        @error('min_withdrawl')
                                            <span class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row m-t-20">
                                    <div class="input-field col s12">
                                        <input id="commission" value="{{ old('commission') }}" name="commission" type="number" class="validate" step="0.00" placeholder="e.g. 0.50 usd" required>
                                        <label for="commission">Commission in amount ($)</label>
                                        @error('commission')
                                            <span class="error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-action">
                                    <button class="btn waves-effect waves-light cyan" type="submit">Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @elseif(!Auth::user()->isAdmin() && Auth::user()->btc_detail && Auth::user()->balance >= Auth::user()->min_withdrawl)
            <div class="row card">
                <div class="col s12">
                    <form method="POST" action="/withdrawls/generate/request">
                        @csrf
                        <div class="form-body">
                            <div class="card m-t-30 card-content">
                                <div>
                                    <div class="row m-t-20">
                                        <div class="input-field col s12">
                                            <input id="btc_address" value="{{ old('btc_address') }}" name="btc_address" type="text" class="validate" placeholder="e.g. KBKNLjkbhjkfvjht67yuhkjHJHGKL" required>
                                            <label for="btc_address">BTC Address</label>
                                            @error('btc_address')
                                                <span class="error" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-action">
                                        <button class="btn waves-effect waves-light cyan" type="submit">Generate Withdrawl Requested
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <div class="row card">

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
                                @if(Auth::user()->isAdmin())
                                    <h6 class="black-text font-medium m-b-0">Requested</h6>
                                @else
                                    <h6 class="black-text font-medium m-b-0">Aavailable</h6>
                                @endif
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

            <div class="row">
                <div class="col s12">
                    @if(count($withdrawls))
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>BTC Address</th>
                                        <th>Status</th>
                                        <th>Generated At</th>
                                        <th>Last Update</th>
                                        @if(Auth::user()->isAdmin())
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($withdrawls as $key => $withdrawl)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $withdrawl->user->name }}</td>
                                        <td><span class="label label-info">${{ number_format($withdrawl->amount, 2) }}</span></td>
                                        <td><span class="label label-warning">{{ $withdrawl->btc_address }}</span></td>
                                        @if($withdrawl->flag == 1)
                                            <td><span class="label label-info">Not Sent</span></td>
                                        @elseif($withdrawl->flag == 2)
                                            <td><span class="label label-success">Sent</span></td>
                                        @else
                                            <td><span class="label label-danger">Rejected</span></td>
                                        @endif
                                        <td>{{ $withdrawl->created_at->diffForHumans() }}</td>
                                        <td>{{ $withdrawl->updated_at->diffForHumans() }}</td>
                                        @if(Auth::user()->isAdmin())
                                            @if($withdrawl->flag == 1)
                                                <td>
                                                    <div class="center-align">
                                                        <div class="col">
                                                            <a href="{{ route('accept', $withdrawl->id) }}" class="waves-effect waves-light btn green">Mark As Paid</a>
                                                            <a href="{{ route('reject', $withdrawl->id) }}" class="waves-effect waves-light btn red">Reject</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            @else
                                                <td class="center">---</td>
                                            @endif
                                        @endif
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
    </div>
</div>
@endsection
