@extends('layouts.app')

@section('content')
    <div id="loginform">
        <div class="p-l-10">
            <h5 class="font-medium m-b-0 m-t-40">Sign In</h5>
            <small>Just login to your account</small>
        </div>
        <!-- Form -->
        <div class="row">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- email -->
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
                <!-- pwd -->
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
                <!-- pwd -->
                <div class="row m-t-5">
                    <div class="col s7">
                        <label>
                            <input type="checkbox" name="remember" />
                            <span>Remember Me?</span>
                        </label>
                    </div>
                    <div class="col s5 right-align">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link">Forgot Password?</a>
                        @endif
                    </div>
                </div>
                <!-- pwd -->
                <div class="row m-t-40">
                    <div class="col s12">
                        <button class="btn-large w100 blue accent-4" type="submit">Login</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="center-align m-t-20 db">
            Don't have an account? <a href="{{ route('register') }}">Sign Up!</a>
        </div>
    </div>
@endsection