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
            <a href="dashboard">Dashboard</a> / <a href="/viewstudents">Customer</a> / Customer Information
        </div>
                
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Customer Information</h1>
        </div> 

        <div class="row">
            <div class="col-md-8 "> 
                
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                    <strong>{{ $message }}</strong>
                </div>
                @endif

                <div class="py-2 px-4">
                    @if(count($payment) > 0)
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Payment Date</th>
                            <th scope="col">Event Name</th>            
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Total Price (RM)</th>
                            <th scope="col" class="text-center"><i class="fas fa-cogs"></i></th>
                        </tr>
                        </thead>
                        <tbody>                                     
                            <tr>
                            @foreach ($payment as $payments)  
                            @if ($student->stud_id == $payments->stud_id)
                                <td class="text-center">{{ date('d/m/Y', strtotime($payments->created_at)) }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $payments->status }}</td>
                                <td class="text-center">{{ $payments->quantity }}</td>
                                <td class="text-center">{{ $payments->totalprice }}.00</td>
                                <td>
                                    <a class="btn btn-dark" href="{{ url('sendmail') }}/{{ $student->stud_id }}/{{ $payments->payment_id }}">
                                        <i class="far fa-envelope"></i>
                                    </a>
                                </td>
                            </tr>  
                                
                            @endif              
                            @endforeach
                        </tbody>                       
                    @else
                    <p>There is no record of payment has been done by this customer.</p>
                    @endif
                    </table>
                </div>                
            </div>
                    
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                    <b>Personal Details</b>
                    </div>
                    <ul class="pt-4 px-4">
                        <!-- Update student form --------------------------------------------------->
                        <form action="{{ url('editdetails') }}/{{ $student->stud_id }}" method="POST"> 
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label>IC No. </label>
                                </div>
                                :
                                <div class="col-sm-8">
                                    <p> {{ $student->ic }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label>Name </label>
                                </div>
                                :
                                <div class="col-sm-8">
                                    <p> {{ $student->first_name }}&nbsp;{{ $student->last_name }}</p>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label>Tel No. </label>
                                </div>
                                :
                                <div class="col-sm-8">
                                    <p> {{ $student->phoneno }}</p>
                                </div>                        
                            </div>

                            <div class="form-group row">  
                                <div class="col-sm-3">                             
                                    <label>Email </label>
                                </div>
                                :
                                <div class="col-sm-8">
                                    <p> {{ $student->email }}</p> 
                                </div>                       
                            </div>
                        </form>
                    </ul>
                </div>

                {{-- <div class="card mb-4">
                    <div class="card-header">
                        <b>Billing Address</b>
                    </div>
                    <ul class="py-4 px-4">
                        {{ $student->address }} 
                    </ul>
                </div> --}}
            </div>
        </div>
    </main>
</div>

@endsection