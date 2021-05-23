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
          <a href="/trackprogram"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <a href="/trackprogram">Customer</a> / <b>{{ $product->name }}</b>
        </div>
  
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">{{ $product->name }}</h1>

            <a class="btn btn-outline-warning" href="{{ url('exportProgram') }}/{{ $product->product_id }}"><i class="fas fa-download pt-1 pr-1"></i> Export Customer</a>
        </div>

        <div class="row">
          <div class="col-md-12 "> 
            
            {{-- <div class="row">
              @foreach ($package as $packages)
              <div class="col-md-4">
                <a class="btn bg-dark btn-lg text-white text-center" style="width: 100%" href="{{ url('viewbypackage') }}/{{ $product->product_id }}/{{ $packages->package_id }}">
                  <h6 class="pt-3 pb-2">{{$packages->name}}</h6>
                </a>
              </div>
              @endforeach
            </div> --}}
            <!-- Show data in cards --------------------------------------------------->
            <div class="row mb-3">
              <div class="col-xl-3 col-lg-6">
                <div class="card card-inverse">
                  <div class="card-block">
                    <div class="rotate" color="green">
                      <i class="fa fa-users fa-6x"></i>
                    </div>
                    <h6 class="pt-3 pl-3">Success Payment</h6>
                    <h3 class="pb-1 pl-3">{{$totalsuccess}}</h3>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-inverse card-danger">
                  <div class="card-block">
                    <div class="rotate">
                      <i class="fa fa-chart-bar fa-6x"></i>
                    </div>
                    <h6 class="pt-3 pl-3">Due Payment</h6>
                    <h3 class="pb-1 pl-3">{{$totalcancel}}</h3>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-inverse card-info">
                  <div class="card-block bg-info">
                    <div class="rotate">
                      <i class="fa fa-chart-area fa-7x"></i>
                    </div>
                    <h6 class="pt-3 pl-3">Paid Ticket</h6>
                    <h3 class="pb-1 pl-3">{{$paidticket}}</h3>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-inverse card-warning">
                  <div class="card-block bg-warning">
                    <div class="rotate">
                      <i class="fa fa-chart-line fa-6x"></i>
                    </div>
                    <h6 class="pt-3 pl-3">Free Ticket</h6>
                    <h3 class="pb-1 pl-3">{{$freeticket}}</h3>
                  </div>
                </div>
              </div>
            </div>

            <!-- Show package in table ----------------------------------------------->
            @if(count($package) > 0)
            <table class="table table-hover" id="successTable">
                <thead>
                <tr class="header">
                    <th>#</th>
                    <th>Package Name</th>
                    <th class="text-center"><i class="fas fa-cogs"></i></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($package as $key => $packages)    
                @if ($product->product_id == $packages->product_id)   
                <tr>
                  <td>{{ $package->firstItem() + $key }}</td>
                  <td>{{ $packages->name  }}</td>
                  <td class="text-center">
                    <a class="btn btn-dark" href="{{ url('viewbypackage') }}/{{ $product->product_id }}/{{ $packages->package_id }}"><i class="fas fa-chevron-right"></i></a>
                  </td>
                </tr>
                @endif
                @endforeach
                </tbody>
            </table>  
            @else
            <p>There are no package yet.</p>
            @endif
            <div class="float-right pt-3">{{$package->links()}}</div>

            {{-- @if(count($student) > 0)
            <table class="table table-hover" id="successTable">
                <thead>
                <tr class="header">
                    <th>#</th>
                    <th>IC No.</th>
                    <th>Name</th>
                    {{-- <th>Payment (RM)</th> 
                    <th>Status</th>
                    <th>Purchase Date</th>
                    <th><i class="fas fa-cogs"></i></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($student as $students)    
                @foreach ($payment as $payments)
                @if ($payments->stud_id == $students->stud_id)
                @if ($product->product_id == $payments->product_id)  
                <tr>
                    <td>{{ $students->stud_id }}</td>
                    <td>{{ $students->ic }}</td>
                    <td>{{ $students->first_name }}</td>
                    {{-- <td>RM {{ $payments->totalprice }}</td> 
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
                @endif
                @endforeach
                @endforeach
                </tbody>
            </table>  
            @else
            <p>There are no any success payment yet.</p>
            @endif
            <div class="float-right pt-3">{{$student->links()}}</div>    --}}
            
          </div>
          
          {{-- <div class="col-md-3">

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
          
          </div> --}}
          
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
<!-- Enable function for search cancel payment ------------------------------------->
{{-- <script>
  function cancelFunction() 
  {
    var input, filter, table, tr, td, i, txtValue;

    input = document.getElementById("cancelInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("cancelTable");
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
</script> --}}

@endsection
