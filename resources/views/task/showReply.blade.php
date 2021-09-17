@extends('layouts.parent')

@section('content')
<div class="page-wrapper">
    <div class="page-titles">
        <div class="d-flex align-items-center">
            <h5 class="font-medium m-b-0">Ticket Replies - {{ $taskTitle->title }}</h5>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col s8">
                @if(count($taskReplies))
                <div class="card">
                    <div class="card-content">
                        <ul class="m-t-40">
                            @foreach($taskReplies as $taskReply)
                                <li class="d-flex align-items-center">
                                  <label>
                                      <span>
                                        <img src="https://ui-avatars.com/api/?background=273146&amp;color=fff&amp;size=64&amp;name={{$taskReply->user->name}}" width="60" alt="Generic placeholder image">
                                      </span>
                                  </label>
                                    <div class="m-l-15">
                                        <h6 class="m-b-0">{{ $taskReply->user->name }}</h6>
                                        <p>{!! nl2br(e($taskReply->task_reply)) !!}</p>
                                    </div>
                                </li>
                                    <div class="m-t-10">
                                        @if(!$taskReply->task->accepted && Auth::user()->isAdmin())
                                        <a href="/task/accept/{{$taskReply->task_id}}/{{ $taskReply->user->id }}/{{ $taskReply->task->package->id }}/{{ $taskReply->id }}" class=" btn waves-effect waves-light green"  name="action">Accept</a>
                                        <a href="/task/reject/{{$taskReply->task_id}}/{{ $taskReply->user->id }}/{{ $taskReply->task->package->id }}" class=" btn waves-effect waves-light red"  name="action">Resubmit</a>
                                        @endif
                                        @if($taskReply->task_attachment)
                                        <a href="{{ url($taskReply->task_attachment) }}" class=" btn waves-effect waves-light blue" download>Download</a>
                                        @endif
                                    </div>
                                <hr>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @else
                    <div class="card p-40 center">
                        <h4>No Records Found</h4>
                    </div>
                @endif
            </div>

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Container fluid scss in scafholding.scss -->
    <!-- ============================================================== -->
    <footer class="center-align m-b-30">All Rights Reserved by Materialart. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.</footer>
</div>
@endsection
