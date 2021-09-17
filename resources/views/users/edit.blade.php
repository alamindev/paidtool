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
                    <h4 class="font-medium">Edit User</h4>
                </div>
                <div class="col s12">
                    <form method="POST" action="/users/update/{{ $user->id }}">
                        @csrf
                        <div class="form-body">
                            <div class="card m-t-30">
                                <div class="card-content">
                                <div class="row">
                                        <div class="input-field col s12">
                                                <input id="name" value="{{ $user->name }}" name="name" type="text" class="validate" required>
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
                                                <input id="email" value="{{ $user->email }}" name="email" type="email" class="validate" required>
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
                                                <input id="phone" value="{{ $user->phone }}" name="phone" type="number" class="validate" required>
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
                                                <input id="country" value="{{ $user->country }}" name="country" type="text" class="validate" required>
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
                                                <textarea name="address" id="address" class="validate materialize-textarea" required>{{ $user->address }}
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
                                        <a href="/users" class="btn waves-effect waves-light grey darken-4">Cancel
                                        </a>
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