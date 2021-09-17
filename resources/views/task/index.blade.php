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
                <h4 class="font-medium">Tasks</h4>
            </div>
            <div class="col l6 m6 s6 right-align">
                @if(Auth::user()->isAdmin())
                    <a href="{{route('addtask')}}" class="waves-effect waves-light btn green">New Task</a>
                @endif
            </div>
        </div>
        <div class="row m-t-20 card">


            <div class="row">
                
                <div class="col s12">
                    <div class="">
                                        <p class="font-bold " style="color: red;"><br>
                                        # Please follow the youtube link to know how to do the task and get paid
                                        - <a href="https://www.youtube.com/watch?v=eLloPoLxB4g" target="_blank">https://www.youtube.com/watch?v=tonDqYp_KMw</a><br>
                                        
                                    </div>
                    <ul class="tabs">
                        
                    @if(Auth::user()->isAdmin())
                    
                        <li class="tab col s3"><a href="#TasksReplied" class="active">Tasks Replied</a></li>
                    @else
                        <li class="tab col s3"><a class="active" href="#TasksSent">My Tasks</a></li>
                        <li class="tab col s3"><a href="#TasksReplied">Tasks Replied</a></li>
                    @endif
                        
                    </ul>
                </div>
                @if(Auth::user()->isAdmin())
                    <div id="TasksNotSent" class="col s12" style="display:none">
                        @if(count($tasksNotSent))
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Package</th>
                                            @if(!Auth::user()->isAdmin())
                                                <th>Replied</th>
                                                <th>Accepted</th>
                                            @endif
                                            <th>Created Date</th>
                                            <th>Updated Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tasksNotSent as $task)
                                        <tr>
                                            <td>
                                                <div class="chip">
                                                    <img src="https://ui-avatars.com/api/?background=273146&color=fff&size=128&name={{$task->title}}" alt="Contact Person"> {{ $task->title }}
                                                </div>
                                            </td>
                                            <td title="{{$task->description}}">{{ substr($task->description, 0, 20) }}...</td>
                                            <td>
                                                <span class="label label-info">{{$task->package->package_name}}</span>
                                            </td>

                                            @if(!Auth::user()->isAdmin())
                                                @if($task->pivot->is_replied == 1)
                                                    <td><span class="label label-warning">Replied</span></td>
                                                @else
                                                    <td><span class="label label-danger">Not Replied</span></td>
                                                @endif
                                                
                                                @if($task->pivot->is_accepted == 1)
                                                    <td><span class="label label-success">Yes</span></td>
                                                @else
                                                    <td><span class="label label-danger">No</span></td>
                                                @endif
                                            @endif
                                            <td>{{$task->created_at->diffForHumans()}}</td>
                                            <td>{{$task->updated_at->diffForHumans()}}</td>
                                            @if(Auth::user()->isAdmin())
                                                <td width="10%" class="blue-grey-text d-flex text-darken-4 font-medium"> 
                                                    <a href="/task/edit/{{$task->id}}" class="link m-auto align-items-center justify-content-center"><i title="Edit" class="material-icons font-20 m-r-5">edit</i></a>
                                                    <a href="/task/delete/{{$task->id}}" class="link m-auto align-items-center justify-content-center"><i title="Delete" class="material-icons font-20 m-r-5">delete</i></a>
                                                    <a href="{{route('task.showReply',$task->id)}}" class="link m-auto align-items-center justify-content-center"><i title="View Replies" class="fas fa-eye"></i></a>
                                                </td>
                                            @else
                                                <td class="blue-grey-text d-flex text-darken-4 font-medium"> 
                                                    @if($task->pivot->is_accepted == 0)
                                                        <a href="{{route('task.addreply',$task->id)}}" class="waves-effect waves-light btn blue">Add Reply</a>
                                                    @endif
                                                    @if($task->pivot->is_replied == 1)
                                                        <a href="{{route('task.showReply',$task->id)}}" class="waves-effect waves-light btn green m-l-5">View Replies</a>
                                                        <a style="color:white;padding:10px; background:red;" href={{"deletetask/". $task->id}} >
                                        Delete</a>
                                        
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                              {{ $tasksNotSent->links() }}
                        @else
                            <div class="card p-40 center">
                                <h4>No Records Found</h4>
                            </div>
                        @endif
                    </div>
                    
                @endif
                <div id="TasksSent" class="col s12" style="display:none">
                    @if(count($tasksSent ?? ''))
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Package</th>
                                        @if(!Auth::user()->isAdmin())
                                            <th>Replied</th>
                                            <th>Accepted</th>
                                        @endif
                                        <th>Created Date</th>
                                        <th>Updated Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if(!Auth::user()->isAdmin())
                                        @foreach($tasksSent ?? '' as $task)
                                            @if($task->pivot->is_replied != 1)
                                                <tr>
                                                    <td>
                                                        @if($task->type == 0)
                                                        <div class="chip">
                                                            <img src="https://ui-avatars.com/api/?background=273146&color=fff&size=128&name={{$task->title}}" alt="Contact Person"> {{ $task->title }}
                                                        </div>
                                                        @else
                                                        ---
                                                        @endif
                                                    </td>
                                                    @if($task->type == 0)
                                                        <td title="{{$task->description}}">{{ substr($task->description, 0, 20) }}...</td>
                                                    @else
                                                    <td title="{{$task->url}}">{{ substr($task->url, 0, 20) }}...</td>
                                                    @endif
                                                    <td>
                                                        <span class="label label-info">{{$task->package->package_name}}</span>
                                                    </td>
                                                        @if($task->type == 0)
                                                            @if($task->pivot->is_replied == 1)
                                                                <td><span class="label label-warning">Replied</span></td>
                                                            @else
                                                            <td><span class="label label-danger">Not Replied</span></td>
                                                            @endif
                                                        @else
                                                        <td>---</td>
                                                        @endif
                                                     @if($task->type == 0)   
                                                        @if($task->pivot->is_accepted == 1)
                                                            <td><span class="label label-success">Yes</span></td>
                                                        @else
                                                        <td><span class="label label-danger">No</span></td>
                                                        @endif
                                                    @else
                                                    
                                                    <td>---</td>
                                                    @endif
                                                    <td>{{$task->created_at->diffForHumans()}}</td>
                                                    <td>{{$task->updated_at->diffForHumans()}}</td>
                                                
                                                        <td class="blue-grey-text d-flex text-darken-4 font-medium"> 
                                                            @if($task->pivot->is_accepted == 0)
                                                                @if($task->type == 0)   
                                                                    <a href="{{route('task.addreply',$task->id)}}" class="waves-effect waves-light btn blue">Add Reply</a>
                                                                @else
                                                                <a href="{{route('task.visitUrl',$task->id)}}" class="waves-effect waves-light btn blue">Visit the URL</a>
                                                                @endif  
                                                                <a  class="waves-effect waves-light btn red" href={{"deletetask/". $task->id}} >Delete</a>
                                                            @endif
                                                            @if($task->pivot->is_replied == 1)
                                                                <a href="{{route('task.showReply',$task->id)}}" class="waves-effect waves-light btn green m-l-5">View Replies</a>
                                                                
                                                            @endif
                                                        </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif

                                    @if(Auth::user()->isAdmin())
                                        @foreach($tasksSent ?? '' as $task)
                                            <tr>
                                                <td>
                                                    <div class="chip">
                                                        <img src="https://ui-avatars.com/api/?background=273146&color=fff&size=128&name={{$task->title}}" alt="Contact Person"> {{ $task->title }}
                                                    </div>
                                                </td>
                                                <td title="{{$task->description}}">{{ substr($task->description, 0, 20) }}...</td>
                                                <td>
                                                    <span class="label label-info">{{$task->package->package_name}}</span>
                                                </td>

                                                <td>{{$task->created_at->diffForHumans()}}</td>
                                                <td>{{$task->updated_at->diffForHumans()}}</td>
                                            
                                                <td width="10%" class="blue-grey-text d-flex text-darken-4 font-medium"> 
                                                    <a href="/task/edit/{{$task->id}}" class="link m-auto align-items-center justify-content-center"><i title="Edit" class="material-icons font-20 m-r-5">edit</i></a>
                                                    <a href="/task/delete/{{$task->id}}" class="link m-auto align-items-center justify-content-center"><i title="Delete" class="material-icons font-20 m-r-5">delete</i></a>
                                                    <a href="{{route('task.showReply',$task->id)}}" class="link m-auto align-items-center justify-content-center"><i title="View Replies" class="fas fa-eye"></i></a>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $tasksSent ?? ''->links() }}
                        </div>
                    @else
                        <div class="card p-40 center">
                            <h4>No Records Found</h4>
                        </div>
                    @endif
                </div>
                <div id="TasksReplied" class="col s12">
                    @if(count($tasksReplied))
                        @if(Auth::user()->isAdmin())
                            <br>
                            <button id="select-all" class="waves-effect waves-light btn blue">Select All</button>
                            <button class="waves-effect waves-light btn green" onClick="acceptSelected()">Accept</button>
                            <button class="waves-effect waves-light btn red" onClick="rejectSelected()">Reject</button>
                        @endif
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        @if(Auth::user()->isAdmin())
                                            <td>
                                            </td>
                                        @endif
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Package</th>
                                        @if(!Auth::user()->isAdmin())
                                            <th>Replied</th>
                                            <th>Accepted</th>
                                        @else
                                            <th>Replies</th>
                                        @endif
                                        <th>Created Date</th>
                                        <th>Updated Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasksReplied as $task)
                                    <tr>
                                        @if(Auth::user()->isAdmin())
                                            <td>
                                                <input type="checkbox" data-id="{{ $task->id }}" class="filled-in taskReplies" name="tasksSelected" style="position: inherit; opacity: 1;" />
                                            </td>
                                        @endif
                                        <td>
                                            @if($task->type == 0)
                                                <div class="chip">
                                                    <img src="https://ui-avatars.com/api/?background=273146&color=fff&size=128&name={{$task->title}}" alt="Contact Person"> {{ $task->title }}
                                                </div>
                                            @else
                                            ---
                                            @endif 
                                        </td>
                                        @if($task->type == 0)
                                            <td title="{{$task->description}}">{{ substr($task->description, 0, 20) }}...</td>
                                        @else
                                            <td title="{{$task->url}}">{{ substr($task->url, 0, 20) }}...</td>
                                        @endif 
                                        <td>
                                            <span class="label label-info">{{$task->package->package_name}}</span>
                                        </td>

                                        @if(!Auth::user()->isAdmin())
                                            @if($task->pivot->is_replied == 1)
                                                <td><span class="label label-warning">Replied</span></td>
                                            @else
                                                <td><span class="label label-danger">Not Replied</span></td>
                                            @endif
                                            
                                            @if($task->pivot->is_accepted == 1)
                                                <td><span class="label label-success">Yes</span></td>
                                            @else
                                                <td><span class="label label-danger">No</span></td>
                                            @endif
                                        @else
                                            <td><span class="label cyan">{{ $task->replies_count }} Replies</span></td>
                                        @endif
                                        <td>{{$task->created_at->diffForHumans()}}</td>
                                        <td>{{$task->updated_at->diffForHumans()}}</td>
                                        @if(Auth::user()->isAdmin())
                                            <td width="10%" class="blue-grey-text d-flex text-darken-4 font-medium"> 
                                                <a href="/task/edit/{{$task->id}}" class="link m-auto align-items-center justify-content-center"><i title="Edit" class="material-icons font-20 m-r-5">edit</i></a>
                                                <a href="/task/delete/{{$task->id}}" class="link m-auto align-items-center justify-content-center"><i title="Delete" class="material-icons font-20 m-r-5">delete</i></a>
                                                <a href="{{route('task.showReply',$task->id)}}" class="link m-auto align-items-center justify-content-center"><i title="View Replies" class="fas fa-eye"></i></a>
                                            </td>
                                        @else
                                        @if($task->type == 0)
                                            <td class="blue-grey-text d-flex text-darken-4 font-medium"> 
                                                @if($task->pivot->is_accepted == 0)
                                                    <a href="{{route('task.addreply',$task->id)}}" class="waves-effect waves-light btn blue">Add Reply</a>
                                                     
                                                @endif
                                                @if($task->pivot->is_replied == 1)
                                                    <a href="{{route('task.showReply',$task->id)}}" class="waves-effect waves-light btn green m-l-5">View Replies</a>
                                                    
                                                @endif
                                            </td>
                                         @else
                                            <td>---</td>
                                        @endif
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>  
                        </div>
                    @else
                        <div class="card p-40 center">
                            <h4>No Records Found</h4>
                        </div>
                    @endif
                </div>
                @if(Auth::user()->isAdmin()) 
                <div id="TasksAccepted" class="col s12" style="display:none">
                    @if(count($tasksAccepted))
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Package</th>
                                        @if(!Auth::user()->isAdmin())
                                            <th>Replied</th>
                                            <th>Accepted</th>
                                        @else
                                            <th>Status</th>
                                        @endif
                                        <th>Created Date</th>
                                        <th>Updated Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasksAccepted as $task)
                                    <tr>
                                        <td>
                                            <div class="chip">
                                                <img src="https://ui-avatars.com/api/?background=273146&color=fff&size=128&name={{$task->title}}" alt="Contact Person"> {{ $task->title }}
                                            </div>
                                        </td>
                                        <td title="{{$task->description}}">{{ substr($task->description, 0, 20) }}...</td>
                                        <td>
                                            <span class="label label-info">{{$task->package->package_name}}</span>
                                        </td>

                                        @if(!Auth::user()->isAdmin())
                                            @if($task->pivot->is_replied == 1)
                                                <td><span class="label label-warning">Replied</span></td>
                                            @else
                                                <td><span class="label label-danger">Not Replied</span></td>
                                            @endif
                                            
                                            @if($task->pivot->is_accepted == 1)
                                                <td><span class="label label-success">Yes</span></td>
                                            @else
                                                <td><span class="label label-danger">No</span></td>
                                            @endif
                                        @else
                                            <td><span class="label label-success">Accepted</span></td>
                                        @endif
                                        <td>{{$task->created_at->diffForHumans()}}</td>
                                        <td>{{$task->updated_at->diffForHumans()}}</td>
                                        @if(Auth::user()->isAdmin())
                                            <td width="10%" class="blue-grey-text d-flex text-darken-4 font-medium"> 
                                                <a href="/task/edit/{{$task->id}}" class="link m-auto align-items-center justify-content-center"><i title="Edit" class="material-icons font-20 m-r-5">edit</i></a>
                                                <a href="/task/delete/{{$task->id}}" class="link m-auto align-items-center justify-content-center"><i title="Delete" class="material-icons font-20 m-r-5">delete</i></a>
                                                <a href="{{route('task.showReply',$task->id)}}" class="link m-auto align-items-center justify-content-center"><i title="View Replies" class="fas fa-eye"></i></a>
                                            </td>
                                        @else
                                            <td class="blue-grey-text d-flex text-darken-4 font-medium"> 
                                                @if($task->pivot->is_accepted == 0)
                                                    <a href="{{route('task.addreply',$task->id)}}" class="waves-effect waves-light btn blue">Add Reply</a>
                                                   
                                                @endif
                                                @if($task->pivot->is_replied == 1)
                                                    <a href="{{route('task.showReply',$task->id)}}" class="waves-effect waves-light btn green m-l-5">View Replies</a>
                                                    
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $tasksAccepted->links() }}
                        </div>
                    @else
                        <div class="card p-40 center">
                            <h4>No Records Found</h4>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>

var clicked = false;
        $("#select-all").on("click", function() {
            $(".taskReplies").prop("checked", !clicked);
            clicked = !clicked;
            this.innerHTML = clicked ? 'Deselect' : 'Select All';
        });

        function acceptSelected() {
            var ids = [];
            
            $('input[name="tasksSelected"]:checked').each(function() {
                ids.push($(this).data("id"));
            });

            var data = {
                "_token" : "<?php echo csrf_token() ?>",
                "ids"    : ids,
            };

            $.ajax({
                type  : 'POST',
                url   : '/task/acceptSelected',
                data  : data,
                success:function(response) {
                    window.location.replace("/tasks");
                }
            });
        }
        
        function rejectSelected() {
            var ids = [];
            
            $('input[name="tasksSelected"]:checked').each(function() {
                ids.push($(this).data("id"));
            });

            var data = {
                "_token" : "<?php echo csrf_token() ?>",
                "ids"    : ids,
            };

            $.ajax({
                type  : 'POST',
                url   : '/task/rejectSelected',
                data  : data,
                success:function(response) {
                    window.location.replace("/tasks");
                }
            });
        }

</script>
@endsection