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

                <form class="px-5" action="{{ url('update/members') }}/{{ $membership->membership_id }}/{{ $membership_level->level_id }}/{{ $student->stud_id }}" method="post">
                    @csrf
                
                    <div class="row py-2">
                            
                        <div class="col-md-6">
                            <label class="form-label">IC No.</label>
                            <input type="text" name="ic" value="{{ $student->ic }}" class="form-control" required>
                        </div>

                    </div>

                    <div class="row py-2">
                            
                        <div class="col-md-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" value="{{ $student->first_name }}" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" value="{{ $student->last_name }}" class="form-control" required>
                        </div>

                    </div>

                    <div class="row py-2">
                            
                        <div class="col-md-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" value="{{ $student->email }}" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Phone No.</label>
                            <input type="text" name="phoneno" value="{{ $student->phoneno }}" class="form-control" required>
                        </div>

                    </div>

                    <div class="col-md-6 py-3">
                        @if(Auth::user()->role_id == 'ROD003' || Auth::user()->role_id == 'ROD004')
                        @else
                          <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $student->stud_id }}"><i class="fas fa-trash-alt"></i> Delete</button>
                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal{{ $student->stud_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <p>This action will remove the details from the table :</p>
                                  <ul>
                                    <li>Student</li>
                                    <li>Payment</li>
                                    <li>Ticket</li>
                                  </ul>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <a class="btn btn-danger" href="{{ url('delete-member') }}/{{ $membership->membership_id }}/{{ $membership_level->level_id }}/{{ $student->stud_id }}">Delete</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endif
                        <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save pr-1"></i> Save  Changes</button>
                    </div>

                </form>
                
            </div>

        </div>
    </main>
</div>

@endsection