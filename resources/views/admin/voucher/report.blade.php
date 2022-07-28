@extends('layouts.app')

@section('title')
  Voucher List  
@endsection


@section('content')

<div class="col-md-12 px-4 py-4">   

  <div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
    <a href="/dashboard"><i class="bi bi-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <b>Voucher List</b>
  </div> 
  
  @if(session('error'))
    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
      <strong>Sorry!</strong> {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="flex-md-nowrap pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Voucher List</h1>
  </div> 
  
  <div class="row">
    <div class="col-md-12 "> 
       
      <div class="float-right pt-3">{{$vouchers->links()}}</div>
      <br>
      
        <!-- View event details in table ----------------------------------------->
        <div class="table-responsive">
          <table class="table table-hover" id="myTable">
            <thead>
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Voucher</th>
                <th>Description</th>
                <th class="text-center"><i class="fas fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody> 
              @foreach ($vouchers as $key => $v)
              <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ date('d/m/Y', strtotime($v->start_date)) }} - {{ date('d/m/Y', strtotime($v->end_date)) }}</td>
                <td>
                  {{ $v->name }}
                  @if ($v->status == 'Active')
                      <span class="badge rounded-pill bg-success"> &nbsp;On Going&nbsp; </span>
                  @else
                  @endif
                </td>
                <td>{{ $v->desc }}</td>
                <td class="text-center">
                  <a class="btn btn-dark" href="{{ url('viewvoucher') }}/{{ $v->voucher_id }}"><i class="bi bi-chevron-right"></i></a>
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