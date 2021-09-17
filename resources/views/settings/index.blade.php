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
                <div class="col s12">
                    <h4 class="font-medium">Settings</h4>
                    <br>
                    <ul class="tabs">
                        <li class="tab col s6"><a class="active" href="#Profile">Profile</a></li>
                        @if(Auth::user()->isAdmin())
                            <li class="tab col s6"><a href="#BTCSettings">BTC Settings</a></li>
                        @endif
                    </ul>
                </div>
                @if(Auth::user()->isAdmin())
                    <div id="BTCSettings" class="col s12">
                        <form method="POST" action="/settings/btc/update">
                            @csrf
                            <div class="form-body">
                                <div class="card m-t-30">
                                    <div class="card-content">
                                        <div class="row m-t-20">
                                            <div class="input-field col s12">
                                                <input id="pub_key" value="{{ Auth::user()->btc_detail->pub_key }}" name="pub_key" type="text" class="validate" required>
                                                <label for="pub_key">PUB Key</label>
                                                @error('pub_key')
                                                    <span class="error" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <input id="api_key" value="{{ Auth::user()->btc_detail->api_key }}" name="api_key" type="text" class="validate" required>
                                                    <label for="api_key">API Key</label>
                                                    @error('api_key')
                                                        <span class="error" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="form-action">
                                            <button class="btn waves-effect waves-light cyan" type="submit">Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                <div id="Profile" class="col s12">
                    <form method="POST" action="/users/update/{{ Auth::user()->id }}">
                        @csrf
                        <div class="form-body">
                            <div class="card m-t-30">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="input-field col s12">
                                                <input id="name" value="{{ Auth::user()->name }}" name="name" type="text" class="validate" required>
                                                <label for="name">Name</label>
                                                @error('name')
                                                    <span class="error" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="email" value="{{ Auth::user()->email }}" name="email" type="email" class="validate" required>
                                                <label for="email">Email</label>
                                                @error('email')
                                                    <span class="error" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="phone" value="{{ Auth::user()->phone }}" name="phone" type="number" class="validate" required>
                                                <label for="phone">Phone</label>
                                                @error('phone')
                                                    <span class="error" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="country" value="{{ Auth::user()->country }}" name="country" type="text" class="validate" required>
                                                <label for="country">Country</label>
                                                @error('country')
                                                    <span class="error" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea name="address" id="address" class="validate materialize-textarea" required>{{ Auth::user()->address }}
                                                </textarea>
                                                <label for="address">Address</label>
                                                @error('address')
                                                    <span class="error" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="form-action">
                                        <button class="btn waves-effect waves-light cyan" type="submit">Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection