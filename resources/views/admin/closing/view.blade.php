@extends('layouts.app')

@section('title')
    Closing
@endsection

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')
<div class="row py-4">     
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      
      <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
        <a href="/dashboard"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="dashboard">Dashboard</a> / <b>Closing</b>
      </div>

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Closing</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <a href="addproduct" type="button" class="btn btn-sm btn-outline-secondary"><i class="fas fa-plus"></i> Add New Event</a>
          </div>
        </div>
      </div>
      
      @if ($message = Session::get('success'))
      <div class="alert alert-success alert-block">
          <button type="button" class="close" data-bs-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
      </div>
      @endif
      
      @if ($message = Session::get('updatesuccess'))
      <div class="alert alert-info alert-block">
          <button type="button" class="close" data-bs-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
      </div>
      @endif

      @if ($message = Session::get('delete'))
      <div class="alert alert-danger alert-block">
          <button type="button" class="close" data-bs-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
      </div>
      @endif

      <div class="float-right pt-3">{{$payment->links()}}</div>
      @if(count($payment) > 0)
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">IC No.</th>
            <th scope="col">Email</th>
            <th scope="col">Phone No.</th>
            <th scope="col">Date Register</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($payment as $key => $payments)  
            @foreach ($student as $students)     
            @if ($payments->user_id == Auth::user()->user_id)                 
            <tr>
                <td>{{ $payment->firstItem() + $key  }}</td>
                <td>{{ $students->first_name  }}</td>
                <td>{{ $students->last_name }}</td>
                <td>{{ $students->ic }}</td>
                <td>{{ $students->email }}</td>
                <td>{{ $students->phoneno }}</td>
                <td>{{ date('d/m/Y', strtotime($payments->date_from)) }} - {{ date('d/m/Y', strtotime($payments->date_to)) }}</td>
            </tr>  
            @endif
            @endforeach  
            @endforeach
        </tbody>
      </table>
      @else
        <p>There are no customer to display.</p>
      @endif
    </main>
  </div>
</div>
@endsection
