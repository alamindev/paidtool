@extends('layouts.parent')
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col s12">
                    <h4 class="font-medium">New Subscription</h4>
                    <br>
                </div>
                <div id="SingleCreate" class="col s12">
                <form method="POST" action="{{route('subscriptions.save')}}">
                        @csrf
                        <div class="form-body">
                            <div class="card m-t-30">
                                <div class="card-content">
                                    <div class="row m-t-20">
                                        <div class="col s12 m12 l12">
                                            <div class="input-field">
                                                <select name="package_id" required>
                                                    <option value="" disabled selected>-- Select Package --</option>
                                                    @foreach ($packages as $package)
                                                        <option  value={{$package->id}}>{{$package->package_name}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="task_description">Package</label>
                                            </div>
                                        </div>
                                        <div class="col s12 m12 l12">
                                            <div class="input-field">
                                                <select name="user_id" required>
                                                    <option value="" disabled selected>-- Select User --</option>
                                                    @foreach ($users as $user)
                                                        <option  value={{$user->id}}>{{$user->name}}</option>
                                                     @endforeach
                                                </select>
                                                <label for="task_description">User</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="form-action">
                                        <button class="btn waves-effect waves-light cyan" type="submit">Save
                                        </button>
                                        <a href="/tasks" class="btn waves-effect waves-light grey darken-4">Cancel
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