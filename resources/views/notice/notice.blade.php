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
            <div class="col l6 m6 s6">
                <h4 class="font-medium">Notice Board</h4>
            </div>
        </div><hr>
        @if(Auth::user()->isAdmin())
        <form method="POST" action="/notice/add">
            @csrf
        <div>
            <lable>Enter Title</lable>
            <input type="text" name="notice_title" required>
            <lable>Enter Notice Detail</lable>
            <textarea row="10" style="background:white;" name="notice_description" required></textarea>
            <button type="submit" class="btn btn-sm">Add</button>
        </div>
        </form>
        @endif
        <div class="row m-t-20 card">
            <div class="row">
                <div class="col s12" style="padding:20px">
                    
                    @if(count($notices))
                    @foreach ($notices as $key => $noti)
                    <h4><b>{{ $noti->title }}</b></h4>
                        <p>{!! nl2br(e($noti->description)) !!}</p>
                        
                        
                        @if(Auth::user()->isAdmin())
                        <div align="right">
                            <a class="waves-effect waves-light btn red" href={{"delete/". $noti->id}} >Delete</a>
                        </div>
                        @else
                        <div align="right" style="display:none">
                            <a class="waves-effect waves-light btn red"  href={{"delete/". $noti->id}} >Delete</a>
                        </div>
                        @endif
                        <hr>
                     @endforeach
                    @else
                        <div class="card p-40 center">
                            <h4>No Records Found</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection