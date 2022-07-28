@extends('layouts.app')

@section('title')
Sales Report
@endsection

@section('content')
<div class="col-md-12 pt-3"> 
        
    <div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">                                                   
        <a href="/viewvoucher"><i class="bi bi-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <a href="/viewvoucher">Voucher List</a> / <a href="{{ url('viewvoucher') }}/{{ $claimed->voucher->voucher_id }}">{{ $claimed->voucher->name }}</a> / <b>{{ $claimed->studClaim->first_name }}&nbsp;{{ $claimed->studClaim->last_name }}</b>
    </div>
            
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Customer Information</h1>
    </div>  

    <div class="row">
        <div class="col-md-12">
        
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
            </div>
            @endif

            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
            </div>
            @endif

            <form action="{{ url('updatestudent') }}/{{ $claimed->studClaim->stud_id }}" method="post">
                @csrf

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <b>Personal Details</b>
                            </div>

                            <div class="card-body pt-5 px-3">

                                <div class="mb-2 row">
                                    <label class="col-sm-3">IC No.</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="ic" value="{{ $claimed->studClaim->ic }}" required>
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-sm-3">Phone No.</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="phoneno" value="{{ $claimed->studClaim->phoneno }}" required>
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-sm-3">Name</label>
                                    <div class="col-sm-9 mb-2">
                                        <input type="text" class="form-control" name="first_name" value="{{ ucwords(strtolower($claimed->studClaim->first_name)) }}" placeholder="First Name" required>
                                        <input type="text" class="form-control" name="last_name" value="{{ ucwords(strtolower($claimed->studClaim->last_name)) }}" placeholder="Last Name">
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-sm-3">Email Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="email" value="{{ $claimed->studClaim->email }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header"><b>Voucher Details</b></div>
                                
                            <div class="card-body pt-5 px-3">
                                <div class="mb-2 row">
                                    <label class="col-sm-3">Series Number</label>
                                    <div class="col-sm-9"><p>: {{ $claimed->series_no}}</p></div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-3">Facebook Page</label>
                                    <div class="col-sm-9">
                                        <p>: {{ $claimed->fb_page}}</p>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-3">Date Claimed</label>
                                    <div class="col-sm-9"><p>: {{ date('d/m/Y g:i A', strtotime($claimed->created_at. '+8hours')) }}</p></div>
                                    {{-- {{ date("Y-m-d H:i:s", strtotime($claim->created_at." +3 hours")) }} --}}
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-3">Status</label>
                                    <div class="col-sm-9">
                                        @if ($claimed->status == 'Complete')
                                        : <i class="badge rounded-pill bg-success"> &nbsp; {{ $claimed->status }} &nbsp; </i>
                                        @elseif ($claimed->status == 'In Progress' && $claimed->created_at < $today )
                                        : <i class="badge rounded-pill bg-danger"> &nbsp; Pending &nbsp; </i>
                                        @elseif ($claimed->status == 'In Progress')
                                        : <i class="badge rounded-pill bg-warning"> &nbsp; {{ $claimed->status }} &nbsp; </i>
                                        @else
                                        <p>: </p>
                                        @endif
                                    </div>
                                </div>
        
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn-group row-fluid" style="float:right;" role="group" aria-label="example">
                    @if(Auth::user()->user_id == 'UID008' || Auth::user()->role_id == 'ROD001' && $claimed->status != 'Complete' )
                        <div>
                            <button type="button" class="btn btn-outline-dark bg-success text-white" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="bi bi-check-circle-fill pr-2"></i>Complete by Account</button>&nbsp;
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Complete Confirmation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <p>This action will confirm that the customer has successfully received the reward. Are you sure?</p>
                                        <ul>
                                            <li>Voucher Claimed</li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a class="btn btn-success" href="{{ url('completevoucher') }}/{{ $voucher_id }}/{{ $series_no }}">Confirm</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    @else
                    @endif

                    
                    @if(Auth::user()->role_id == 'ROD003' || Auth::user()->role_id == 'ROD004')
                    @else
                        <div>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal3"><i class="bi bi-trash pr-2"></i>Delete</button>&nbsp;
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <p>This action will remove the details from the table :</p>
                                        <ul>
                                            <li>Voucher Claimed</li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a class="btn btn-danger" href="{{ url('delete/claimed') }}/{{ $voucher_id }}/{{ $series_no }}">Delete</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save pr-2"></i>Save Changes</button>

                </div>
            </form>
            
        </div>

    </div>
</div>

@endsection