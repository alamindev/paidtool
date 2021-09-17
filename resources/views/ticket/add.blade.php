@extends('layouts.parent')

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
            <form method="POST" action="{{route('tickets-save')}}">
                    @csrf
                    <div class="form-body">
                        <h4 class="font-medium">New Ticket</h4>
                        <div class="card m-t-30">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s12">
                                    <div class="input-field">
                                        <input name="ticket_title" id="ticket_title" type="text" step="any" placeholder="Enter Title"  autocomplete="off" required>
                                        <label for="ticket_title">Ticket Title</label>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                    <div class="input-field">
                                        <textarea class="materialize-textarea" name="ticket_description" id="ticket_description" cols="30" rows="10" placeholder="Enter task description" required="" style="height: 45px;"></textarea>
                                        <label for="ticket_description">Ticket Description</label>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="form-action">
                                    <button class="btn waves-effect waves-light cyan" type="submit" name="action">Save
                                    </button>
                                    <a href="" class="btn waves-effect waves-light grey darken-4" name="action">Cancel
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