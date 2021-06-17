@extends('layouts.app')

@section('title')
    Sales Tracking
@endsection

<style>
  .gradient-1
  {
    background-image: linear-gradient(to bottom right, #9c46cb, #77c6ff);
  }
  .gradient-2
  {
    background-image: linear-gradient(to bottom right, #82e4ff, #77ffbd);
  }
  .gradient-3
  {
    background-image: linear-gradient(to bottom right, #6ef5ab, #c6f054);
  }
  .gradient-4
  {
    background-image: linear-gradient(to bottom right, #ffcda5, #ee4d5f);
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

            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group">
                {{-- <a href="managerole" type="button" class="btn btn-sm btn-outline-primary"><i class="fas fa-users pr-3"></i> Manage Role</a>
                <a href="create" type="button" class="btn btn-sm btn-outline-secondary"><i class="fas fa-plus pr-1"></i> Add New User</a> --}}
                <a class="btn btn-sm btn-outline-warning" href="{{ url('exportProgram') }}/{{ $product->product_id }}"><i class="fas fa-download pt-1 pr-1"></i> Export Buyer</a>
                <a class="btn btn-sm btn-outline-warning" href="{{ url('export-participant') }}/{{ $product->product_id }}"><i class="fas fa-download pt-1 pr-1"></i> Export Participant</a>
              </div>
            </div>
        </div>        

        @if ($message = Session::get('export-buyer'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-bs-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if ($message = Session::get('export-participant'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-bs-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
        @endif

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
            
            <br>

            <!-- Show data in cards --------------------------------------------------->
            <div class="row mb-3">
              <div class="col-xl-3 col-lg-6">
                <div class="card border-0 gradient-1 shadow text-center">
                  <h6 class="pt-3">Paid Ticket</h6>
                  <h3 class="lead pb-1">{{ number_format($totalsuccess) }}</h3>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card border-0 gradient-2 shadow text-center">
                  <h6 class="pt-3">Free Ticket</h6>
                  <h3 class="lead pb-1">{{ number_format($freeticket) }}</h3>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card border-0 gradient-3 shadow text-center">
                  <h6 class="pt-3">Updated Participant</h6>
                  <h3 class="lead pb-1">{{ number_format($paidticket) }}</h3>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card border-0 gradient-4 shadow text-center">
                  <h6 class="pt-3">Pending Payment</h6>
                  <h3 class="lead pb-1">{{ number_format($totalcancel) }}</h3>
                </div>
              </div>
            </div>

            <br>

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
