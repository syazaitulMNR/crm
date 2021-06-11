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
            <a href="{{ url('viewbypackage') }}/{{ $product->product_id }}/{{ $package->package_id }}"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> 
            / <a href="/trackprogram">Customer</a> / <a href="{{ url('trackpackage') }}/{{ $product->product_id }}">{{ $product->name }}</a> 
            / <a href="{{ url('viewbypackage') }}/{{ $product->product_id }}/{{ $package->package_id }}">{{ $package->name }}</a> / <b>{{ $student->first_name }}</b>
        </div>
                
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Customer Information</h1>
        </div> 

        <div class="row">      

            <div class="col-md-12">

                @if ($message = Session::get('purchased-sent'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                    <strong>{{ $message }}</strong>
                </div>
                @endif 
                
                @if ($message = Session::get('updated-sent'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                    <strong>{{ $message }}</strong>
                </div>
                @endif

                <form action="{{ url('updatepayment') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $payment->payment_id }}/{{ $payment->stud_id }}" method="post">
                    @csrf
                
                    <div class="card mb-4">
                        <div class="card-header">
                        <b>Personal Details</b>
                        </div>
                        <div class="pt-3 px-4">

                            <div class="mb-3 row">
                                <label class="col-sm-2">IC No.</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="ic" value="{{ $student->ic }}">
                                    {{-- <p>: &nbsp;&nbsp;&nbsp; {{ $student->ic }}</p> --}}
                                </div>

                                <label class="col-sm-2">Phone No.</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="phoneno" value="{{ $student->phoneno }}">
                                    {{-- <p>: &nbsp;&nbsp;&nbsp; {{ $student->phoneno }}</p> --}}
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2">Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="first_name" value="{{ $student->first_name }}" placeholder="First Name">
                                    <input type="text" class="form-control" name="last_name" value="{{ $student->last_name }}" placeholder="Last Name">
                                    {{-- <p>: &nbsp;&nbsp;&nbsp; {{ $student->first_name }}&nbsp;{{ $student->last_name }}</p> --}}
                                </div>

                                <label class="col-sm-2">Email Address</label>
                                <div class="col-sm-4">
                                    
                                    <input type="text" class="form-control" name="email" value="{{ $student->email }}">
                                    {{-- <p>: &nbsp;&nbsp;&nbsp; {{ $student->email }}</p> --}}
                                    
                                    <br>
                                                 
                                    <!-- Purchased Modal Button -->
                                    <button type="button" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#purchaseModal"><i class="fas fa-paper-plane pr-1"></i> Purchased Email </button>
                                    <!-- Purchased Modal Triggered -->
                                    <div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Sending Confirmation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to send '<b>Pengesahan Pembelian Tiket</b>' to this customer?</p>
                                                <p>Example: </p>
                                                <div class="text-center">
                                                    <img src="{{ asset('assets/images/pengesahan_tiket.jpg') }}" style="max-width:300px">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <a class="btn btn-sm btn-dark" href="{{ url('purchased-mail') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $payment->payment_id }}/{{ $student->stud_id }}">
                                                    <i class="fas fa-paper-plane pr-1"></i> Send
                                                </a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                        <b>Payment Details</b>
                        </div>
                        <div class="pt-3 px-4">

                            <div class="mb-3 row">
                                <label class="col-sm-2">Package Name</label>
                                <div class="col-sm-4">
                                    <p>: &nbsp;&nbsp;&nbsp; {{ $package->name }}</p>
                                </div>

                                <label class="col-sm-2">Date Purchase</label>
                                <div class="col-sm-4">
                                    <p>: &nbsp;&nbsp;&nbsp; {{ date('d/m/Y', strtotime($payment->created_at)) }}</p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2">Quantity</label>
                                <div class="col-sm-4">
                                    <p>: &nbsp;&nbsp;&nbsp; {{ $payment->quantity }}</p>
                                </div>

                                <label class="col-sm-2">Payment</label>
                                <div class="col-sm-4">
                                    <p>: &nbsp;&nbsp;&nbsp; 
                                        RM {{ $payment->totalprice }}.00 &nbsp;
                                        @if ($payment->status == 'paid')
                                            <span class="badge rounded-pill bg-success"> &nbsp;{{ $payment->status }}&nbsp; </span>
                                        @elseif ($payment->status == 'due')
                                            <span class="badge rounded-pill bg-danger"> &nbsp;{{ $payment->status }}&nbsp; </span>
                                        @else
                                            <p>NULL</p>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2">Offer ID</label>
                                <div class="col-sm-4">
                                    <select class="form-select form-control-sm" name="offer_id">
                                        <option value="{{ $payment->offer_id }}" readonly selected>-- {{ $payment->offer_id }} --</option>
                                        <option value="OFF001">OFF001</option>
                                        <option value="OFF002">OFF002</option>                                        
                                        <option value="OFF003">OFF003</option>
                                    </select>
                                </div>

                                <label class="col-sm-2">Payment Status</label>
                                <div class="col-sm-4">
                                    <select class="form-select form-control-sm" name="status">
                                        <option value="{{ $payment->status }}" readonly selected>-- {{ $payment->status }} --</option>
                                        <option value="paid">paid</option>
                                        <option value="due">due</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fas fa-save pr-1"></i> Save  Changes</button>
                        </div>
                    </div>

                </form>
                
            </div>

        </div>
    </main>
</div>

@endsection