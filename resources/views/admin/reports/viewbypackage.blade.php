@extends('layouts.app')

@section('title')
    Sales Tracking
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
          <a href="{{ url('trackpackage') }}/{{ $product->product_id }}"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> 
          / <a href="/trackprogram">Order History</a> / <a href="{{ url('trackpackage') }}/{{ $product->product_id }}"> {{ $product->name }} </a> 
          / <b>{{ $package->name }}</b>
        </div>
  
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">{{ $package->name }}</h1>

          {{-- <a href="{{ url('new-customer') }}/{{ $product->product_id }}/{{ $package->package_id }}" class="btn btn-dark"><i class="fas fa-plus pr-1"></i> New Customer</a> --}}
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#newcustomer">
            <i class="fas fa-plus pr-1"></i> New Customer
          </button>
          <!-- Modal -->
          <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header border-bottom-0">
                  <h5 class="modal-title" id="exampleModalLabel">Add New Customer</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{ url('new-customer/details') }}" name="form1" id="form1" method="POST"> 
                @csrf
                  <div class="form-group row">
                      <label for="ic" class="col-sm-2 col-form-label text-right">IC No. :</label>
                      <div class="col-sm-10">
                      <input type="text" class="col-sm-8 form-control" name="ic"  >
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="name" class="col-sm-2 col-form-label text-right">Name :</label>
                      <div class="col-sm-10">
                      <input type="text" class="col-sm-8 form-control" name="name" >
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="name" class="col-sm-2 col-form-label text-right">Tel No. :</label>
                      <div class="col-sm-10">
                      <input type="text" class="col-sm-8 form-control" name="phoneno"  >
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="name" class="col-sm-2 col-form-label text-right">Email :</label>
                      <div class="col-sm-10">
                      <input type="email" class="col-sm-8 form-control" name="email"  >
                      </div>
                  </div>
                                    
                  <div class='col-md-8'>
                      <button type='submit' class='btn btn-primary float-right'> Submit </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
            
        </div>

        <div class="row">
          <div class="col-md-9 "> 

            <!-- Search box ---------------------------------------------------------->
            <input type="text" id="successInput" class="form-control" onkeyup="successFunction()" placeholder="Please Enter Order ID" title="Type in a name">
            
            <br>
            <!-- Show success payment in table ----------------------------------------------->
            @if(count($payment) > 0)
            <table class="table table-hover" id="successTable">
                <thead>
                <tr class="header">
                    <th>#</th>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Payment (RM)</th>
                    <th>Status</th>
                    <th>Purchase Date</th>
                    <th><i class="fas fa-cogs"></i></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($payment as $key => $payments)    
                @if ($product->product_id == $payments->product_id)  
                <tr>
                    <td>{{ $payment->firstItem() + $key }}</td>
                    <td>{{ $payments->payment_id }}</td>
                    <td>{{ $payments->stud_id }}</td>
                    <td>RM {{ $payments->totalprice }}</td>
                    <td>
                      @if ($payments->status == 'paid')
                        <span class="badge rounded-pill bg-success"> &nbsp;{{ $payments->status }}&nbsp; </span>
                      @elseif ($payments->status == 'due')
                        <span class="badge rounded-pill bg-danger"> &nbsp;{{ $payments->status }}&nbsp; </span>
                      @else
                        <p>NULL</p>
                      @endif
                    </td>
                    <td>{{ date('d/m/Y', strtotime($payments->created_at)) }}</td>
                    <td>
                      <a class="btn btn-primary" href="{{ url('viewpayment') }}/{{ $product->product_id }}/{{ $payments->package_id }}/{{ $payments->payment_id }}/{{ $payments->stud_id }}"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @endif
                @endforeach
                </tbody>
            </table>  
            @else
            <p>There are no any payment yet.</p>
            @endif
            <div class="float-right pt-3">{{$payment->links()}}</div>   
            
          </div>
          
          <div class="col-md-3">

            <div class="card mb-4 text-center">
                <div class="card-block bg-light text-dark">
                    <div class="rotate">
                    <i class="fas fa-file-invoice-dollar fa-6x"></i>
                    </div>
                    <h3 class="pt-3 pl-3">{{$total}}</h3>
                    <h6 class="pb-1 pl-3">Total Purchased</h6>
                </div>
            </div>

            <div class="card mb-4 text-center">
              <div class="card-body pt-4">
                <i class="far fa-check-circle fa-3x" style="color:rgb(69, 139, 95)"></i>
                <h3 class="pt-4">{{$totalsuccess}}</h3>
              </div>
              <div class="card-footer">
                <h6>Total Paid</h6>
              </div>
            </div>
    
            <div class="card mb-4 text-center">
              <div class="card-body pt-4">
                <i class="far fa-times-circle fa-3x" style="color:rgb(240, 0, 0)"></i>
                <h3 class="pt-4">{{$totalcancel}}</h3>
              </div>
              <div class="card-footer">
                <h6>Total Due</h6>
              </div>
            </div>
          
          </div>
          
        </div>
        
    </main>
  </div>
</div>


<!-- Enable function for search payment ------------------------------------->
<script>
  function successFunction() 
  {
    var input, filter, table, tr, td, i, txtValue;

    input = document.getElementById("successInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("successTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) 
    {
      td = tr[i].getElementsByTagName("td")[1];
      
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }       
    }
  }
</script>

@endsection
