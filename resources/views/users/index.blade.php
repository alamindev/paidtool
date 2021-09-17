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
                <h4 class="font-medium">Users</h4>
            </div>
            <div class="col l6 m6 s6 right-align">
                @if(Auth::user()->isAdmin())
                    <a href="/users/create" class="waves-effect waves-light btn green">New User</a>
                @endif
            </div>
        </div>
        <div class="row m-t-20 card">
            <div class="row">
                <div class="col s12">
                    @if(count($users))
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Country</th>
                                        <th>Address</th>
                                        <th>Packages</th>
                                        <th>Joining Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key => $user)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->country }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>
                                            @if(count($user->packages))
                                                @foreach($user->packages as $package)
                                                    <span class="label label-info">{{ $package->package_name }}</span>
                                                @endforeach
                                            @else
                                                <span class="label label-warning">No Packages</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                        <td>
                                            <div class="center-align">
                                                <div class="col">
                                                    <a href="/users/edit/{{$user->id}}" class="link d-flex align-items-center justify-content-center"><i class="material-icons font-20 m-r-5">edit</i>Edit</a>
                                                </div>
                                                <div class="col">
                                                    <a href="/users/delete/{{$user->id}}" class="link d-flex align-items-center justify-content-center"><i class="material-icons font-20 m-r-5">delete</i>Delete</a>
                                                </div>
                                            </div>
                                        </td>
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
            </div>
        </div>
    </div>
</div>
@endsection