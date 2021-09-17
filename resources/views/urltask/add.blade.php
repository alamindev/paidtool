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
                    <h4 class="font-medium">Add Url Task</h4>
                    <br>
                    <ul class="tabs">
                        <li class="tab col s3"><a class="active" href="#SingleCreate">Single Create</a></li>
                        <li class="tab col s3"><a href="#BulkUpload">Bulk Upload</a></li>
                        <li class="tab col s3"><a href="#SampleSheet">Sample Sheet</a></li>
                    </ul>
                </div>
                <div id="SingleCreate" class="col s12">
                    <form method="POST" action="{{route('saveurltask')}}">
                        @csrf
                        <div class="form-body">
                            <div class="card m-t-30">
                                <div class="card-content">
                                    <div class="row m-t-20">
                                        <div class="col s12 m12 l12">
                                            <div class="input-field">
                                                <input  placeholder="Enter url " id="task_name" type="url" name="url" autocomplete="off" required>
                                                <input name="type" type="hidden" value="1" >
                                                <label for="task_name">URL</label>
                                            </div>
                                        </div> 
                                        <div class="col s12 m12 l12">
                                        <div class="input-field">
                                            <input  name="time" placeholder="example:- 30" id="title" type="number" autocomplete="off" required>
                                            <label for="title">Time</label>
                                        </div>
                                    </div> 
                                        <div class="col s12 m12 l12">
                                            <div class="input-field">
                                                <select name="package_id" required>
                                                    <option value="" disabled selected>-- Select Package --</option>
                                                    @foreach($packages as $package)
                                                        <option  value={{$package->id}}>{{$package->package_name}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="task_description">Package</label>
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
                <div id="BulkUpload" class="col s12">
                    <form method="POST" action="/tasks/url/upload/sheet" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="card m-t-30">
                                <div class="card-content">
                                    <div class="row m-t-20">
                                        <div class="col s12 m12 l12">
                                            <div class="input-field">
                                                <h6>URl tasks Sheet</h6>
                                                <input name="tasks_sheet" id="tasks_sheet" type="file" name="tasks_sheet"> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="form-action">
                                        <button class="btn waves-effect waves-light cyan" type="submit">Upload
                                        </button>
                                        <a href="/tasks" class="btn waves-effect waves-light grey darken-4">Cancel
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
                                    <a href="{{asset('UrlTasksSheet.xlsx')}}" class="btn waves-effect waves-light grey darken-4" download>Download Sample Sheet <i class="fa fa-download"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection