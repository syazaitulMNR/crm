@extends('layouts.app')

@section('title')
    Customer Business Details
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

/* Bootstrap 4 text input with search icon */

</style>

@section('content')
    <div class="col-md-12 pt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Customer Business Details</li>
            </ol>
        </nav>

        <div class="col-md-12 table-responsive">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h1 class="h2">Business Details</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <form action="{{ url('export-surveyform') }}" method="GET">
                  <button class="btn btn-outline-secondary" type="submit">Download</button>
                </form>
              </div>  
            </div>
          </div>
          @if(count($prod) > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Event</th>
                  <th scope="col">Offer</th>
                  <th scope="col"><i class="fas fa-cogs"></i></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($product as $key => $products)    
                @foreach ($offers as $offer)     
                @if ($products->offer_id == $offer->offer_id)               
                  <tr>
                      <td>{{ $product->firstItem() + $key  }}</td>
                      <td>
                        {{ $products->name  }} 
                      </td>
                      <td>{{ $offer->name }}</td>
                    <td>
                      <a class="btn btn-dark" href="{{ url('business_surveyform') }}/{{ $products->product_id }}"><i class="bi bi-chevron-right"></i></a>
                      <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $products->product_id }}"><i class="bi bi-trash"></i></button>
                      <!-- Modal -->
                      <div class="modal fade" id="exampleModal{{ $products->product_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Are you sure you want to delete this event ?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>   
                @endif
                @endforeach 
                @endforeach
              </tbody>
            </table>
          </div>
          @else
            <p>There are no event to display.</p>
          @endif
          <div class="float-left pt-3">{{$product->links()}}</div>
    </div>
@endsection