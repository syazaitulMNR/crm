@extends('layouts.app')

@section('title')
    Import Customer
@endsection

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')

<div class="row py-4">
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        
        <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
            <a href="{{ url('membership/level') }}/{{ $membership->membership_id }}/{{ $membership_level->level_id }}"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> 
            / <a href="/membership">Membership</a> / <a href="{{ url('membership/level') }}/{{ $membership->membership_id }}"> {{ $membership->name }} </a> 
            / <a href="{{ url('membership/level') }}/{{ $membership->membership_id }}/{{ $membership_level->level_id }}">{{ $membership_level->name }}</a> / <b>Import Members</b>
        </div>

        {{-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Import Customer</h1>
        </div> --}}

        @if ($message = Session::get('failed'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-bs-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
        @endif

        <form action="{{ url('store-import') }}/{{ $membership->membership_id }}/{{ $membership_level->level_id }}" class="row" method="POST" enctype="multipart/form-data">
            @csrf

            <h5>Import {{ $membership_level->name }}</h5>

            <div class="input-group p-3">
                <input type="file" name="file" class="form-control" required>
                <button class="btn btn-dark"><i class="fas fa-upload pt-1"></i></button>
            </div>

        </form>
           
        <br>
        <div class="panel panel-default">

            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                <!-- create campaign -->
                <div class="btn-group" role="group" aria-label="First group">
                    <h5>How To Import ?</h5>
                </div>
                
                {{-- <div class="input-group">
                    <a class="btn btn-warning" href="{{ url('exportExcel') }}"><i class="fas fa-download pt-1"></i></a>
                </div> --}}
            </div>
            {{-- <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Please Enter IC Number" title="Type in a name"> --}}
         
            {{-- <div class="row float-right pt-3">
                {{-- <div class="col-auto">
                    <div>{{$data->links()}}</div>
                </div>
                <div class="col-auto pt-1">
                    <a class="btn btn-warning" href="{{ url('exportExcel') }}"><i class="fas fa-download pr-1"></i>Download the format</a>
                </div>
            </div> --}}
            
            <br>  

            <div class="panel-body">
                <p class="py-1">1) Please download this format before import to database.</p>
                <div class="table-responsive">
                    <!-- Show details in table ----------------------------------------------->
                    <table class="table table-hover" id="myTable">
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>IC No.</th>
                            <th>Email</th>
                            <th>Phone No</th>
                            <th>Price (RM)</th>
                            <th>Quantity</th>
                            <th>Total Payment</th>
                            <th>Pay Method</th>
                            <th>Offer ID</th>
                            <th>User ID</th>
                        </tr>
                        <tr>
                            <td>John</td>
                            <td>Doe</td>
                            <td>900101014321</td>
                            <td>example@gmail.com</td>
                            <td>+60123456789</td>
                            <td>199</td>
                            <td>1</td>
                            <td>199</td>
                            <td>FPX</td>
                            <td>OFF001</td>
                            <td>UID001</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row float-right pt-3">
                <div class="col-auto pt-1">
                    <a class="btn btn-warning" href="{{ url('export-format') }}/{{ $membership->membership_id }}/{{ $membership_level->level_id }}"><i class="fas fa-download pr-2"></i>Download</a>
                </div>
            </div>

        </div>
    </main>
</div>
@endsection