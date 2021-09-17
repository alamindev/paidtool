@extends('layouts.parent')

@section('content')
<div class="page-wrapper">
    <div class="page-titles">
        <div class="d-flex align-items-center">
            <h5 class="font-medium m-b-0">Ticket List</h5>
            @if(!Auth::user()->isAdmin())
            <div class="ml-auto">
            <a href="{{route('tickets-add')}}" class="waves-effect waves-light btn green">Create Ticket</a>
            </div>
            @endif
     <!-- ============================================================== -->
    <!-- Close ticket button will be added here  -->
    <!-- ============================================================== -->
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                @if(count($tickets))
                <div class="card">
                    <div class="card-content">
                        <h5 class="card-title">Ticket</h5>
                        <div class="row">
                            <div class="col l3 m6">
                                <div class="card danger-gradient">
                                    <div class="card-content">
                                        <div class="center-align">
                                            <h3 class="white-text m-b-0">{{ number_format($stats->total) }}</h3>
                                            <span class="white-text">Total</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col l3 m6">
                                <div class="card info-gradient">
                                    <div class="card-content">
                                        <div class="center-align">
                                            <h3 class="white-text m-b-0">{{ number_format($stats->opened) }}</h3>
                                            <span class="white-text">Opened</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col l3 m6">
                                <div class="card warning-gradient">
                                    <div class="card-content">
                                        <div class="center-align">
                                            <h3 class="white-text m-b-0">{{ number_format($stats->inProgress) }}</h3>
                                            <span class="white-text">In Progress</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col l3 m6">
                                <div class="card success-gradient">
                                    <div class="card-content">
                                        <div class="center-align">
                                            <h3 class="white-text m-b-0">{{ number_format($stats->resolved) }}</h3>
                                            <span class="white-text">Closed</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>ID</th>
                                        <th>Created by</th>
                                        <th>Date</th>
                                        {{-- <th>Agent</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tickets as $ticket)
                                    <tr>
                                        @if($ticket->status==1)
                                        <td><span class="label label-success">Opened</span></td>
                                        @endif
                                        @if($ticket->status==2)
                                        <td><span class="label label-warning">In Progress</span></td>
                                        @endif
                                        @if($ticket->status==3)
                                        <td><span class="label label-danger">Close</span></td>
                                        @endif
                                        <td><a href="{{ route('ticket-details', $ticket->id) }}" class="link">{{$ticket->title}}</a></td>
                                        <td title="{{$ticket->description}}">{!! nl2br(e($ticket->description)) !!}...</td>
                                        <td><a href="{{ route('ticket-details', $ticket->id) }}" class="font-medium link">{{$ticket->ticket_id}}</a></td>
                                        <td>{{$ticket->user->name}}</td>
                                        <td>{{$ticket->created_at->diffForHumans()}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                              
                            </table>
                        </div>
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
    
</div>
@endsection