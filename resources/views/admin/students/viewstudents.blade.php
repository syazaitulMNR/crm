@extends('layouts.app')

@section('title')
    Customer
@endsection

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')
<div class="row py-4">     
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

      <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
        <a href="/dashboard"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <b>Customer</b>
      </div>
  
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Customer</h1>
        @if(Auth::user()->role_id == '5f97695f34dad' )
        @else
        <!--<div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <a href="addstudent" type="button" class="btn btn-sm btn-outline-secondary"><i class="fas fa-plus"></i> Add New Customer</a>
          </div>
        </div>-->
        @endif
      </div>

      <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Please Enter IC Number" title="Type in a name">

      <div class="float-right pt-3">{{$student->links()}}</div>

      <br> 

      <div class="panel-body">
        <div class="table-responsive">
            <!-- Show details in table ----------------------------------------------->
            @if(count($student) > 0)
            <table class="table table-hover" id="myTable">
                <tr>
                    <th>#</th>
                    {{-- <th>ID</th> --}}
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>IC No.</th>
                    <th>Email</th>
                    <th>Phone No</th>
                </tr>
                @foreach($student as $key => $row)
                <tr>
                    <td>{{ $student->firstItem() + $key  }}</td>
                    {{-- <td>{{ $row->stud_id }}</td> --}}
                    <td>{{ $row->first_name }}</td>
                    <td>{{ $row->last_name }}</td>
                    <td>{{ $row->ic }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->phoneno }}</td>
                </tr>
                @endforeach
            </table>
            {{-- <div class="float-right pt-3">{{$data->links()}}</div> --}}
            @else
            <p>There are no customer to display.</p>
            @endif
        </div>
      </div>

      {{-- @if(count($student) > 0)
        <table class="table table-hover" id="myTable">
          <thead>
            <tr>
              <th scope="col" >#</th>
              <th scope="col" >IC Number</th>
              <th scope="col" >Customer Name</th>            
              <th scope="col" >Email</th>
              <th scope="col" >Date Joined</th>
              <th scope="col" ><i class="fas fa-cogs"></i></th>
            </tr>
          </thead>
          <tbody>
              @foreach ($student as $key => $students)  
                @foreach ($product as $products)
                  {{-- @if ($students->product_id == $products->product_id)                                     
                    <tr>
                      <td>{{ $student->firstItem() + $key  }}</td>
                      <td>{{ $students->ic }}</td>
                      <td>{{ $students->first_name }}&nbsp;{{ $students->last_name }}</td>
                      <td>{{ $students->email }}</td>
                      <td>{{ date('d/m/Y', strtotime($students->created_at)) }}</td>
                      <td>
                        <a class="btn btn-light" href="{{ url('viewdetails') }}/{{ $students->stud_id }}"><i class="fas fa-eye"></i></a>
                        {{-- @if(Auth::user()->role_id == '5f97695f34dad' )
                        @else
                        <a class="btn btn-danger" href="{{ url('deletestudent') }}/{{ $students->stud_id }}"><i class="fas fa-trash-alt"></i></a>
                        @endif 
                      </td>
                    </tr>    
                  {{-- @endif               
                @endforeach 
              @endforeach
          </tbody>
        </table>
      @else
        <p>There are no record to display.</p>
      @endif --}}
    </main>
  </div>
</div>

<!-- Enable function for search data ------------------------------------->
<script>
  function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[3];
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