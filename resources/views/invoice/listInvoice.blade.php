@extends('studentportal.app')

@section('title')
  Sales Report
@endsection


@section('content')

<div class="col-md-12 px-4 py-4">   

  <div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
    <a href="/dashboard"><i class="bi bi-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <b>List Invoices</b>
  </div> 
     
  <div class="flex-md-nowrap pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">List Invoices</h1>
  </div> 
  
  <div class="row">
    <div class="col-md-12 "> 
        
      <!-- Search box ---------------------------------------------------------->
      <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Please Enter Event Name" title="Type in a name">
      
      <div class="float-right pt-3"></div>
      <br>
      
        <!-- View event details in table ----------------------------------------->
        <div class="table-responsive">
          <table class="table table-hover" id="myTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Membership</th>
                <th>Date</th>
                <th>Price</th>
                <th class="text-center"><i class="fas fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($months as $month)
              <tr>
                <td>
                  {{$no++}}
                </td>
                <td>
                  {{$membership_level->name}}
                </td>
                <td>
                  {{$month}}
                </td>
                <td>
                {{$membership_level->price}}
                </td>
                <td class="text-center">
                  <a href="/student/list-bill/{{$membership_level->level_id}}" class="btn btn-success">Pay Now</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>   
        </div>  
      

    </div>
  </div>
</div>
@endsection