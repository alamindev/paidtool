@extends('layouts.parent') 

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <form method="POST" action="{{route('Reply.save',$task->id)}}" enctype="multipart/form-data" class="dropzone">
                    @csrf
                    <div class="form-body">
                        <div class="card-content">
                            <h5 class="font-bold">Task Title: <br>{{ $task->title}}</h5><br>
                            <h5 class="font-bold">Tasks:</h5>
                            <h4 class="font-bold" style="color:red">{{ $task->description }}</h4>

                            <div class="Input-field m-t-20 m-b-20">
                                <textarea name="task_reply" rows="40" style="height: 200px"></textarea>
                            </div>
                            <h5 class="card-title"><i class="ti-link"></i> Attachment</h5>
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>File</span>
                                    <input type="file" name="attachment">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="attach one or more files">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn green m-t-20">Send</button>
                        <a href="/tasks" class="btn grey darken-4 m-t-20">Discard</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
