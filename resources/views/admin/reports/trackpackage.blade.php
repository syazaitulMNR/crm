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
          <a href="/trackprogram"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <a href="/trackprogram">Order History</a> / <b>{{ $product->name }}</b>
        </div>
  
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">{{ $product->name }}</h1>

            <a class="btn btn-warning" href="{{ url('exportProgram') }}"><i class="fas fa-download pt-1"></i></a>
        </div>

        <div class="row">
          <div class="col-md-9 "> 
            
            <div class="row">
              @foreach ($package as $packages)
              <div class="col-md-4">
                <a class="btn bg-dark btn-lg text-white text-center" href="{{ url('viewbypackage') }}/{{ $product->product_id }}/{{ $packages->package_id }}">
                  <h6 class="pt-3 pb-2">{{$packages->name}}</h6>
                </a>
              </div>
              @endforeach
            </div>
            <br>

            <!-- Search box ---------------------------------------------------------->
            <input type="text" id="successInput" class="form-control" onkeyup="successFunction()" placeholder="Please Enter IC Number" title="Type in a name">
            
            <br>
            <!-- Show success payment in table ----------------------------------------------->
            @if(count($student) > 0)
            <table class="table table-hover" id="successTable">
                <thead>
                <tr class="header">
                    <th>#</th>
                    <th>IC No.</th>
                    <th>Name</th>
                    {{-- <th>Payment (RM)</th> --}}
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
                    {{-- <td>RM {{ $payments->totalprice }}</td> --}}
                    <td>
                      @if ($payments->status == 'succeeded')
                        <span class="badge rounded-pill bg-success">{{ $payments->status }}</span>
                      @elseif ($payments->status == 'cancelled')
                        <span class="badge rounded-pill bg-danger">{{ $payments->status }}</span>
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
            <div class="float-right pt-3">{{$student->links()}}</div>   
            
          </div>
          
          <div class="col-md-3">

            <div class="card mb-4 text-center">
              <div class="card-body pt-4">
                <i class="far fa-check-circle fa-3x" style="color:rgb(69, 139, 95)"></i>
                <h3 class="pt-4">{{$totalsuccess}}</h3>
              </div>
              <div class="card-footer">
                <h6>Total Succeeded</h6>
              </div>
            </div>
    
            <div class="card mb-4 text-center">
              <div class="card-body pt-4">
                <i class="far fa-times-circle fa-3x" style="color:rgb(240, 0, 0)"></i>
                <h3 class="pt-4">{{$totalcancel}}</h3>
              </div>
              <div class="card-footer">
                <h6>Total Cancelled</h6>
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
