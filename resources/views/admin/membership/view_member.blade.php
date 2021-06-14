@extends('layouts.app')

@section('title')
    Customer Information
@endsection

<style>
    .card {
      overflow: hidden;
    }
  
    .card-block .rotate {
      z-index: 8;
      float: right;
      height: 100%;
    }
  
    .card-block .rotate i {
      color: rgba(20, 20, 20, 0.15);
      position: absolute;
      left: 0;
      left: auto;
      right: -10px;
      bottom: 0;
      display: block;
      -webkit-transform: rotate(-44deg);
      -moz-transform: rotate(-44deg);
      -o-transform: rotate(-44deg);
      -ms-transform: rotate(-44deg);
      transform: rotate(-44deg);
    }
</style>
  
@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')

<div class="row py-4">
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">   
        
        <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
            <a href="{{ url('membership/level') }}/{{ $membership->membership_id }}"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <a href="/membership">Membership</a>
            / <a href="{{ url('membership/level') }}/{{ $membership->membership_id }}">{{ $membership->name }}</a> / <b>{{ $membership_level->name }}</b>
        </div>
                
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Customer Information</h1>
        </div> 

        <div class="row">      

            <div class="col-md-12">

                <form class="row g-3 px-5" action="{{ url('update/members') }}/{{ $membership->membership_id }}/{{ $membership_level->level_id }}/{{ $student->stud_id }}" method="post">
                    @csrf
                
                    <div class="col-md-6">
                        <label class="form-label">IC No.</label>
                        <input type="text" name="ic" value="{{ $student->ic }}" class="form-control" required>
                    </div>

                    <div class="row-fluid">
                            
                        <div class="col-md-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" value="{{ $student->first_name }}" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" value="{{ $student->last_name }}" class="form-control" required>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" value="{{ $student->email }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone No.</label>
                        <input type="text" name="phoneno" value="{{ $student->phoneno }}" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                    </div>

                </form>
                
            </div>

        </div>
    </main>
</div>

@endsection