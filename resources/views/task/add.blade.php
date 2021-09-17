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
                    <h4 class="font-medium">Add Task</h4>
                    <br>
                    <ul class="tabs">
                        <li class="tab col s3"><a class="active" href="#SingleCreate">Single Create</a></li>
                        <li class="tab col s3"><a href="#BulkUpload">Bulk Upload</a></li>
                        <li class="tab col s3"><a href="#SampleSheet">Sample Sheet</a></li>
                    </ul>
                </div>
                <div id="SingleCreate" class="col s12">
                    <form method="POST" action="{{route('addtask')}}">
                        @csrf
                        <div class="form-body">
                            <div class="card m-t-30">
                                <div class="card-content">
                                    <div class="row m-t-20">
                                        <div class="col s12 m12 l12">
                                            <div class="input-field">
                                                <input name="task_name" placeholder="Enter task title " id="task_name" type="text" name="task_name" autocomplete="off" required>
                                                <label for="task_name">Name</label>
                                            </div>
                                        </div>
                                        <div class="col s12 m12 l12">
                                            <div class="input-field">
                                                <textarea class="materialize-textarea" name="task_description" id="task_description" cols="30" rows="10" placeholder="Enter task description" required></textarea>
                                                <label for="task_description">Description</label>
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
                    <form method="POST" action="/tasks/upload/sheet" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="card m-t-30">
                                <div class="card-content">
                                    <div class="row m-t-20">
                                        <div class="col s12 m12 l12">
                                            <div class="input-field">
                                                <h6>Tasks Sheet</h6>
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
                                    <a href="{{asset('TasksSheet.xlsx')}}" class="btn waves-effect waves-light grey darken-4" download>Download Sample Sheet <i class="fa fa-download"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection