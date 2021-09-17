@extends('layouts.parent')
@section('content')
<div class="page-wrapper">
    <div class="page-titles">
        <div class="d-flex align-items-center">
            <h5 class="font-medium m-b-0">Ticket Detail</h5>
            <div class="ml-auto">
                @if(Auth::user()->isAdmin() && $ticket->status != 3)
                    <a href="{{route('resolve-ticket', $ticket->id)}}" class="waves-effect waves-light btn green">Close Ticket</a>
                @endif
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col s8">
                <div class="card">
                    <div class="card-content">
                    
                    <h5 class="card-title">{{$ticket->title}}</h5>
                        <p>{!! nl2br(e($ticket->description)) !!}</p>
                    </div>
                </div>
                <h5 class="card-title">Ticket Replies</h5>
                <div class="card">
                    <div class="card-content">
                        <ul class="m-t-40">
                            @foreach($ticketReplies as $ticketReply)
                            <li class="d-flex align-items-center">
                                @if($ticketReply->type == 1)
                                <img src="https://ui-avatars.com/api/?background=fb6340&amp;color=fff&amp;size=64&amp;name={{$adminName->name}}" width="50" class="circle" alt="user">
                                @endif
                                    @if($ticketReply->type == 2)
                                <img src="https://ui-avatars.com/api/?background=273146&amp;color=fff&amp;size=64&amp;name={{$ticketReply->ticket->user->name}}" width="50" class="circle" alt="user">
                                @endif
                                <div class="m-l-15">
                                   
                                    @if($ticketReply->type == 1)
                                        <h5 class="m-b-0">{{$adminName->name}}</h5>
                                    @endif

                                    @if($ticketReply->type == 2)
                                        <h5 class="m-b-0">{{$ticketReply->ticket->user->name}}</h5>
                                    @endif
                                    {!! nl2br(e($ticketReply->message)) !!}

                                </div>
                            </li>
                            <hr>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @if($ticket->status != 3)
                    <div class="card">
                        <div class="card-content">
                            <h5 class="card-title m-b-20">Write a reply</h5>
                            <form method="post" action="{{ route('respond-ticket', $ticket->id) }}">
                            @csrf
                                <textarea id="ticketMessages" name="ticketMessages"></textarea>
                                <button type="submit" class="m-t-20 btn waves-effect waves-light green">Reply</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col s4">
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Ticket Info</h5>
                    </div>
                    <div class="card-content bg-light">
                        <div class="row center-align">
                            <div class="col s6 m-t-10 m-b-10">
                                @if($ticket->status==1)
                                <span class="label label-success">Opened</span>
                                @endif
                                @if($ticket->status==2)
                                <span class="label label-warning">In Progress</span>
                                @endif
                                @if($ticket->status==3   )
                                <span class="label label-red">Closed</span>
                                @endif
                            </div>
                            <div class="col s6 m-t-10 m-b-10">
                                {{$ticket->updated_at->diffForHumans()}}
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <h6 class="p-t-20">{{$ticket->user->name}}</h6>
                        <span>Freelancer</span>
                        <h6 class="m-t-30">Admin</h6>
                        <span>{{$adminName->name }}</span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content center-align">
                        <h5 class="card-title">User Info</h5>
                        <div class="profile-pic m-b-20 m-t-20">

                            <img src="https://ui-avatars.com/api/?background=273146&amp;color=fff&amp;size=128&amp;name={{$ticket->user->name}}" width="50" class="circle" alt="user">
                            <h4 class="m-t-20 m-b-0">{{$ticket->user->name}}</h4>
                            <a href="mailto:{{ $ticket->user->email }}">{{$ticket->user->email}}</a>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Container fluid scss in scafholding.scss -->
    <!-- ============================================================== -->
    <footer class="center-align m-b-30">All Rights Reserved by Materialart. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.</footer>
</div>

@endsection