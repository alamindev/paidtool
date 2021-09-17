@extends('layouts.parent')

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <form method="POST" action="/task/{{$task->id}}">
                    @csrf
                    <div class="form-body">
                        <h4 class="font-medium">Edit Task</h4>
                        <div class="card m-t-30">
                            <div class="card-content">
                                <div class="row m-t-20">
                                    <div class="col s12 m12 l12">
                                        <div class="input-field">
                                            <input value="{{ $task->title }}" name="task_name" placeholder="Enter task title" id="title" type="text" autocomplete="off" required>
                                            <label for="title">Title</label>
                                        </div>
                                    </div>
                                    <div class="col s12 m12 l12">
                                        <div class="input-field">
                                            <textarea class="materialize-textarea" name="task_description" id="description" cols="30" rows="10" placeholder="Enter task description" required>{{ $task->description }}</textarea>
                                            <label for="description">description</label>
                                        </div>
                                    </div>
                                    <div class="col s12 m12 l12">
                                        <div class="input-field">
                                            <select name="package_id" required>
                                                @foreach($packages as $package)
                                                    <option value={{$package->id}} {{ ($task->package_id == $package->id) ? "selected" : "" }}>{{$package->package_name}}</option>
                                                @endforeach
                                            </select>
                                            <label for="description">Package</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="form-action">
                                    <button class="btn waves-effect waves-light cyan" type="submit" name="action">Save
                                    </button>
                                    <a href="/tasks" class="btn waves-effect waves-light grey darken-4" name="action">Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection