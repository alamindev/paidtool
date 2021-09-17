@extends('layouts.parent')

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
             <chat-component role="{{auth()->user()->role_id}}"  user_id="{{auth()->user()->id}}"></chat-component>
        </div>
    </div>
@endsection

@section('javascript')
<script src="/js/app.js"></script>
@endsection
