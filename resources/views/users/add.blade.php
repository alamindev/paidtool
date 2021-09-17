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
                    <h4 class="font-medium">Add User</h4>
                    <br>
                    <ul class="tabs">
                        <li class="tab col s3"><a class="active" href="#SingleCreate">Single Create</a></li>
                        <li class="tab col s3"><a href="#BulkUpload">Bulk Upload</a></li>
                        <li class="tab col s3"><a href="#SampleSheet">Sample Sheet</a></li>
                    </ul>
                </div>
                <div id="SingleCreate" class="col s12">
                    <form method="POST" action="/users/create">
                        @csrf
                        <div class="form-body">
                            <div class="card m-t-30">
                                <div class="card-content">
                                    <div class="alert blue text-white">
                                        The default password of each user is <b>admin@123</b>
                                    </div>
                                    <div class="row m-t-20">
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
                <div id="BulkUpload" class="col s12">
                    <form method="POST" action="/users/upload/sheet" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="card m-t-30">
                                <div class="card-content">
                                    <div class="row m-t-20">
                                        <div class="alert blue text-white">
                                            The default password of each user is <b>admin@123</b>
                                        </div>
                                        <div class="col s12 m12 l12">
                                            <div class="input-field">
                                                <h6>Users Sheet</h6>
                                                <input name="users_sheet" id="users_sheet" type="file" name="users_sheet">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="form-action">
                                        <button class="btn waves-effect waves-light cyan" type="submit">Upload
                                        </button>
                                        <a href="/users" class="btn waves-effect waves-light grey darken-4">Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="SampleSheet" class="col s12">
                    <div class="form-body">
                        <div class="card m-t-30">
                            <div class="card-content">
                                <div class="form-action center">
                                    <a href="{{asset('UsersSheet.xlsx')}}" class="btn waves-effect waves-light grey darken-4" download>Download Sample Sheet <i class="fa fa-download"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection