@extends('layouts.parent')

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        @if(Session::has("error"))
            <div class="alert alert-danger">{{ Session::get("error") }}</div>
        @elseif(Session::has("success"))
            <div class="alert alert-success">{{ Session::get("success") }}</div>
        @endif
        <div class="row">
            <div class="col l6 m6 s6">
            
                <h4 class="font-medium">Affiliates</h4>
         
            </div>
          
        </div>

       
            <div class="row">
                <div class="col l6 m12">
                    <div class="card">
                        <div class="card-content center-align">
                            <div>
                                <h6 class="green-text font-medium m-b-0">Referral Link:</h6>
                            </div>
                            <div class="">
                                <h4>{{url('/')}}/register?ref={{Auth::user()->email}}</h4>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col l6 m12">
                    <div class="card">
                        <div class="card-content center-align">
                            <div>
                               <h6 class="black-text font-medium m-b-0">Affilate Earnings:</h6>
                            </div>
                            <div>
                                <h4>{{ Auth::user()->refcommission }} $</h4>
                                
                            </div>
                        </div>
                    </div>
                </div>
               
            </div> <div class="card p-20">
      <div class="table-responsive">
                <table  class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                @php $refs  = App\User::where('ref',Auth::user()->id)->paginate(10);@endphp
                @if(count($refs) < 1 )
                <tr>
                            <td>No Affilates Found</td>
                            </tr>@endif
                @foreach($refs as $index => $ref)
                        <tr>
                            <td>{{ $index+1 }}</td>
                             <td>{{$ref->name}}</td>
                             <td>{{$ref->email}}</td>
                             <td>{{$ref->created_at->toDateString()}}</td>
                        </tr>
                  @endforeach
                    </tbody>   
                </table>
                 </div>
            </div>
        {{$refs->links()}}
             <br>
        <br>
     <div class="card p-20">
      <div class="table-responsive">
                <table  class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Package Name</th>
                            <th>Package Comission</th>
                            <th>Task Comission</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                @php $packs  = App\Package::get();@endphp
                @if(count($refs) < 1 )
                <tr>
                            <td>No Affilates Found</td>
                            </tr>@endif
                @foreach($packs as $index => $pack)
                        <tr>
                            <td>{{ $index+1 }}</td>
                             <td>{{$pack->package_name}}</td>
                             <td>{{$pack->com}}%</td>
                             <td>{{$pack->tcom}}%</td>
                        </tr>
                  @endforeach
                    </tbody>   
                </table>
                </div>
            </div>
        
    </div> 
</div>
@endsection