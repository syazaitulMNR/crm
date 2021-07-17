@extends('layouts.app')

@section('title')
Customer Profiles
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

@section('content')
    <div class="col-md-12 pt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('customer_profiles') }}">Customer Profiles</a></li>
              <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Customer Information</h1>
        </div> 


        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 pt-3">
                    <div class="card">
                        <div class="card-header">
                            <strong>Personal Details</strong>
                        </div>
            
                        <div class="card-body">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="First Name">First Name</label>
                                        <input type="text" class="form-control" value="{{ $customer->first_name }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="First Name">Last Name</label>
                                        <input type="text" class="form-control" value="{{ $customer->last_name }}" disabled>
                                    </div>
                                </div>
            
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="IC Number">IC Number</label>
                                        <input type="text" class="form-control" value="{{ $customer->ic }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="First Name">Email Address</label>
                                        <input type="text" class="form-control" value="{{ $customer->email }}" disabled>
                                    </div>
                                </div>
            
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="Phone Number">Phone Number</label>
                                        <input type="text" class="form-control" value="{{ $customer->phoneno }}" disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-6 pt-3">
                    <div class="card">
                        <div class="card-header">
                            <strong>Payment Details</strong>
                        </div>
            
                        <div class="card-body">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="First Name">Package Name</label>
                                        <input type="text" class="form-control" value="{{ $customer->first_name }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="First Name">Quantity</label>
                                        <input type="text" class="form-control" value="{{ $customer->last_name }}" disabled>
                                    </div>
                                </div>
            
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="IC Number">Offer ID</label>
                                        <input type="text" class="form-control" value="{{ $customer->ic }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="First Name">Date Purchase</label>
                                        <input type="text" class="form-control" value="{{ $customer->email }}" disabled>
                                    </div>
                                </div>
            
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="Phone Number">Payment</label>
                                        <input type="text" class="form-control" value="{{ $customer->phoneno }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Phone Number">Payment Status</label>
                                        <input type="text" class="form-control" value="{{ $customer->phoneno }}" disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection