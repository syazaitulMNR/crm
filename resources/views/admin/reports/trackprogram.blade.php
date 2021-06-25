@extends('layouts.app')

@section('title')
    Sales Tracking
@endsection

@include('layouts.navbar')
@section('content')

<div class="col-md-12 px-5 py-4">    
     
  <div class="flex-md-nowrap pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Customer</h1>
  </div> 

  <div class="card-header pt-3" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
    <a href="/dashboard"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <b>Customer</b>
  </div>
  
  <div class="row">
    <div class="col-md-12 "> 
        
      <!-- Search box ---------------------------------------------------------->
      <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Please Enter Event Name" title="Type in a name">
      
      <div class="float-right pt-3">{{$product->links()}}</div>
      <br>
      
      <!-- View event details in table ----------------------------------------->
      <table class="table table-hover" id="myTable">
        <thead>
          <tr class="header">
            <th>#</th>
            <th>Event Date</th>
            <th>Event Name</th>
            <th class="text-center"><i class="fas fa-cogs"></i></th>
          </tr>
        </thead>
        <tbody> 
          @foreach ($product as $key => $products)
          <tr>
            <td>{{ $product->firstItem() + $key }}</td>
            <td>{{ date('d/m/Y', strtotime($products->date_from)) }}</td>
            <td>
              {{ $products->name }}
              @if ($products->status == 'active')
                  <span class="badge rounded-pill bg-success"> &nbsp;On Going&nbsp; </span>
              @else
              @endif
            </td>
            <td class="text-center">
              <a class="btn btn-dark" href="{{ url('trackpackage') }}/{{ $products->product_id }}"><i class="fas fa-chevron-right"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>     

    </div>
  </div>
</div>