@extends('layouts.app')

@section('title')
  Sales Report
@endsection


@section('content')

<div class="col-md-12 px-4 py-4">   

  <div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
    <a href="/dashboard"><i class="bi bi-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <b>Sales Report</b>
  </div> 
  
  @if(session('error'))
    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
      <strong>Sorry!</strong> {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="flex-md-nowrap pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Sales Report</h1>
  </div> 
  
  <div class="row">
    <div class="col-md-12 "> 
        
      <!-- Search box ---------------------------------------------------------->
      <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Please Enter Event Name" title="Type in a name">
      
      <div class="float-right pt-3">{{$product->links()}}</div>
      <br>
      
        <!-- View event details in table ----------------------------------------->
        <div class="table-responsive">
          <table class="table table-hover" id="myTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Event</th>
                <th>Offer</th>
                <th class="text-center"><i class="fas fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody> 
              @foreach ($product as $key => $products)
                @foreach ($offers as $offer)     
                  @if ($products->offer_id == $offer->offer_id)   
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
                      <td>{{ $offer->name }}</td>
                      <td class="text-center">
                        <a class="btn btn-dark" href="{{ url('trackpackage') }}/{{ $products->product_id }}"><i class="bi bi-chevron-right"></i></a>
                      </td>
                    </tr>
                  @endif
                @endforeach 
              @endforeach
            </tbody>
          </table>   
        </div>  
    </div>
  </div>
</div>

@endsection