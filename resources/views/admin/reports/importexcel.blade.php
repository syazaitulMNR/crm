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

            <h5>Import Customer</h5>

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
                
                {{-- <div class="input-group">
                    <a class="btn btn-warning" href="{{ url('exportExcel') }}"><i class="fas fa-download pt-1"></i></a>
                </div> --}}
            </div>
            {{-- <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Please Enter IC Number" title="Type in a name"> --}}
         
            {{-- <div class="row float-right pt-3">
                {{-- <div class="col-auto">
                    <div>{{$data->links()}}</div>
                </div>
                <div class="col-auto pt-1">
                    <a class="btn btn-warning" href="{{ url('exportExcel') }}"><i class="fas fa-download pr-1"></i>Download the format</a>
                </div>
            </div> --}}
            
            <br>  

            <p class="py-1">1) Please download this format before import to database.</p>
            <div class="row pb-3">
                <div class="col-md-11">
                    <div class="card bg-light shadow">
                        <div class="table-responsive px-3 py-3">
                            <!-- Show details in table ----------------------------------------------->
                            <table class="table">
                                <tr>
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
                    </div>
                </div>
                
                <div class="col-md-1">
                    <a class="btn btn-warning" href="{{ url('exportExcel') }}/{{ $product->product_id }}/{{ $package->package_id }}"><i class="fas fa-download py-1"></i></a>
                </div>
                
            </div>

            <p class="py-1">2) Refer this ID for Offer ID column.</p>
            <div class="row">
                <div class="col-md-11">
                    <div class="card bg-light shadow">
                        <div class="table-responsive px-3 py-3">
                            <!-- Show details in table ----------------------------------------------->
                            <table class="table">
                                <tr>
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
                                    <td>Buy 1 Free 1</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>OFF003</td>
                                    <td>Bulk Offer</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>

            {{-- <div class="panel-body">
                <div class="table-responsive">
                    <!-- Show details in table ----------------------------------------------->
                    @if(count($data) > 0)
                    <table class="table table-hover" id="myTable">
                        <tr>
                            <th>#</th>
                            {{-- <th>ID</th> 
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>IC No.</th>
                            <th>Email</th>
                            <th>Phone No</th>
                        </tr>
                        @foreach($data as $key => $row)
                        <tr>
                            <td>{{ $data->firstItem() + $key  }}</td>
                            {{-- <td>{{ $row->stud_id }}</td> 
                            <td>{{ $row->first_name }}</td>
                            <td>{{ $row->last_name }}</td>
                            <td>{{ $row->ic }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->phoneno }}</td>
                        </tr>
                        @endforeach
                    </table>
                    {{-- <div class="float-right pt-3">{{$data->links()}}</div> 
                    @else
                    <p>There are no customer to display.</p>
                    @endif
                </div>
            </div> --}}
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