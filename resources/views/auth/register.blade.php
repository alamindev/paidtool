@extends('layouts.app')

@section('content')
    <div id="loginform">
        <div class="p-l-10">
            <h5 class="font-medium m-b-0">Sign Up</h5>
            <small>Register your free account</small>
        </div>
        <!-- Form -->
        <div class="row">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input  value="{{ app('request')->input('ref') }}" name="ref" type="hidden" class="validate">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name" value="{{ old('name') }}" name="name" type="text" class="validate" required>
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
                        <input id="email" value="{{ old('email') }}" name="email" type="email" class="validate" required>
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
                        <input id="phone" value="{{ old('phone') }}" name="phone" type="number" class="validate" required>
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
                        <input id="country" value="{{ old('country') }}" name="country" type="text" class="validate" required>
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
                        <textarea name="address" id="address" class="validate materialize-textarea" required>{{ old('phone') }}</textarea>
                        <label for="address">Address</label>
                        @error('address')
                            <span class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12">
                        <input id="password" value="{{ old('password') }}" name="password" type="password" class="validate" required>
                        <label for="password">Password</label>
                        @error('password')
                            <span class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12">
                        <input id="password_confirmation" value="{{ old('password_confirmation') }}" name="password_confirmation" type="password" class="validate" required>
                        <label for="password_confirmation">Confirm Password</label>
                        @error('password')
                            <span class="password_confirmation" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row m-t-40">
                    <div class="col s12">
                        <button class="btn-large w100 blue accent-4" type="submit">Register</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="center-align m-t-20 db">
            Already have an account? <a href="{{ route('login') }}">Sign In!</a>
        </div>
    </div>
@endsection