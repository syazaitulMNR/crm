@extends('layouts.app')

@section('title')
    Import Members
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

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Import {{ $membership_level->name }}</h1>
        </div>

        @if ($message = Session::get('failed'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-bs-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
        @endif

        <form action="{{ url('store-import') }}/{{ $membership->membership_id }}/{{ $membership_level->level_id }}" class="row" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="input-group p-3">
                <input type="file" name="file" class="form-control" required>
                <button class="btn btn-dark"><i class="fas fa-upload pt-1"></i></button>
            </div>

        </form>
           
        <div class="panel panel-default">

            <h5 class="pt-3 pb-2">How To Import ?</h5>

            <p>1) Please download this format before import to database.</p>
            <div class="row">
                <div class="col-md-12">
                    {{-- <div class="card bg-light"> --}}
                        <div class="table-responsive">
                            <!-- Show details in table ----------------------------------------------->
                            <table class="table table-bordered table-sm" id="myTable">
                                <tr class="table-active">
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>IC No.</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                </tr>
                                <tr>
                                    <td>John</td>
                                    <td>Doe</td>
                                    <td>900101014321</td>
                                    <td>example@gmail.com</td>
                                    <td>+60123456789</td>
                                </tr>
                            </table>
                        </div>
                    {{-- </div> --}}
    
                    <div class="row-fluid float-right pt-1">
                        <a class="btn btn-warning" href="{{ url('export-format') }}/{{ $membership->membership_id }}/{{ $membership_level->level_id }}"><i class="fas fa-download pr-2"></i>Download</a>
                    </div>
                </div>
                
            </div>
            
        </div>
    </main>
</div>
@endsection