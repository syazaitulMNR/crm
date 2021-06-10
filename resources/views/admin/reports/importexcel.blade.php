@extends('layouts.app')

@section('title')
    Import Customer
@endsection

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')

<div class="row py-4">
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        
        <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
            <a href="{{ url('viewbypackage') }}/{{ $product->product_id }}/{{ $package->package_id }}"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> 
            / <a href="/trackprogram">Customer</a> / <a href="{{ url('trackpackage') }}/{{ $product->product_id }}"> {{ $product->name }} </a> 
            / <a href="{{ url('viewbypackage') }}/{{ $product->product_id }}/{{ $package->package_id }}">{{ $package->name }}</a> / <b>Import Customer</b>
        </div>

        {{-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Import Customer</h1>
        </div> --}}

        @if ($message = Session::get('failed'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-bs-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
        @endif

        <form action="{{ url('importExcel') }}/{{ $product->product_id }}/{{ $package->package_id }}" class="row" method="POST" enctype="multipart/form-data">
            @csrf

            <h5 class="pt-3">Import Customer</h5>

            <div class="input-group p-3">
                <input type="file" name="file" class="form-control" required>
                <button class="btn btn-dark"><i class="fas fa-upload pt-1"></i></button>
            </div>
            <em>Maximum upload file size: 8MB</em>

        </form>
           
        <br>
        <div class="panel panel-default">

            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                <!-- create campaign -->
                <div class="btn-group" role="group" aria-label="First group">
                    <h5>How To Import ?</h5>
                </div>
                
            </div>
            
            <br>  

            <p>1) Please download this format before import to database.</p>
            <div class="row">
                <div class="col-md-12">
                    {{-- <div class="card bg-light"> --}}
                        <div class="table-responsive px-3 py-3">
                            <!-- Show details in table ----------------------------------------------->
                            <table class="table table-bordered table-sm" id="myTable">
                                <tr class="table-active">
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>IC No.</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Price (RM)</th>
                                    <th>Quantity</th>
                                    <th>Total Payment</th>
                                    <th>Pay Method</th>
                                    {{-- <th>Ticket Type</th> --}}
                                    <th>Offer ID</th>
                                    <th>User ID</th>
                                </tr>
                                <tr>
                                    <td>John</td>
                                    <td>Doe</td>
                                    <td>900101014321</td>
                                    <td>example@gmail.com</td>
                                    <td>+60123456789</td>
                                    <td>199</td>
                                    <td>1</td>
                                    <td>199</td>
                                    <td>FPX</td>
                                    {{-- <td>free</td> --}}
                                    <td>OFF001</td>
                                    <td>UID001</td>
                                </tr>
                            </table>
                        </div>
                    {{-- </div> --}}
    
                    <div class="row-fluid float-right pt-3">
                        <div class="col-auto pt-1">
                            <a class="btn btn-warning" href="{{ url('exportExcel') }}/{{ $product->product_id }}/{{ $package->package_id }}"><i class="fas fa-download pr-2"></i>Download</a>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <p>2) Just refer to this table for Offer ID column.</p>
            <div class="row">
                <div class="col-md-12">
                    {{-- <div class="card bg-light"> --}}
                        <div class="table-responsive px-3 py-3">
                            <!-- Show details in table ----------------------------------------------->
                            <table class="table table-bordered table-sm">
                                <tr class="table-active">
                                    <th>#</th>
                                    <th>Offer ID</th>
                                    <th>Description</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>OFF001</td>
                                    <td>No Offer</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>OFF002</td>
                                    <td>Buy 1 Free 1 (Same Ticket)</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>OFF003</td>
                                    <td>Bulk Ticket</td>
                                </tr>
                            </table>
                        </div>
                    {{-- </div> --}}
                </div>
                
            </div>
        </div>
    </main>
</div>

<!-- Enable function for search data ------------------------------------->
{{-- <script>
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
  
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
  
      for (i = 0; i < tr.length; i++) 
      {
        td = tr[i].getElementsByTagName("td")[4];
  
        if (td) 
        {
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