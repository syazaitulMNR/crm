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
              <li class="breadcrumb-item"><a href="">{{ $product->name }}</a></li>
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

          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Business Role</th>
                <th scope="col">Business Type</th>
                <th scope="col">Business Amount (RM)</th>
                <th scope="col">Class</th>
              </tr>
            </thead>

            <tbody>

              {{-- @forelse ($data as $key => $k) --}}
              @foreach ($datas as $keydata => $vdata)
              @foreach ($vdata as $kdata => $valdata)
                  @foreach ($tickets as $keytic => $vtic)
                  @foreach ($vtic as $ktic  => $valtic)
                      @foreach ($students as $keystud => $vstud)
                      @foreach ($vstud as $kstud => $valstud)
                          @if($valstud->ic == $valtic->ic)
                              @if ($valdata->ticket_id == $valtic->ticket_id)
                                  <th scope="row">1</th>
                                  <td>{{ $valstud->first_name }} {{ $valstud->last_name }}</td>
                                  <td>{{ $valdata->business_role }}</td>
                                  <td>{{ $valdata->business_type }}</td>
                                  <td>{{ $valdata->business_amount }}</td>
                              @endif
                          @endif
                      @endforeach
                      @endforeach
                  @endforeach
                  @endforeach    
              @endforeach
              @endforeach

            </tbody>
          </table>
          {{ $data->links() }}
        </div>
    </div>
@endsection