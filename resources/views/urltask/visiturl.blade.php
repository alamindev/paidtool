@extends('layouts.parent')
@section('js')
<script>  
 window.onbeforeunload = function () {
  return '';
 }
var timer = "{{ $task->time }}";   
    function startTimer(){
        timer = timer - 1;
        $("#timer").html(timer);
        if(timer == 0){
            clearInterval(timerInterval);  
            $.ajax({
                type:'POST',
                url:'/task/url/{{request()->taskID}}/complete', 
                success:function(data){
                  if(data.success == true){
                     window.onbeforeunload = null;
                      window.location = '/tasks'
                  }
                }
            });
        }
    } 
    var timerInterval;
    timerInterval = setInterval(startTimer, 1000); 

    $(window).focus(function() {
       var time =  $("#timer").html();
       if(time > 0){
            if (!timerInterval) 
                timerInterval = setInterval(startTimer, 1000);  
       } 
    });

    $(window).blur(function() {
        clearInterval(timerInterval);
        timerInterval = 0;
    });
    
</script>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="visit--url">
            <p><span id="timer">{{ $task->time }}</span>
            <span>Seconds</span></p>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{{ $task->url }}" allowfullscreen></iframe>
                    </div>
                </div> 
            </div>
        </div>
    </div>
@endsection