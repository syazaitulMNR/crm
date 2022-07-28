{{-- {{dd('john')}} --}}
@extends('layouts.app')

@section('title')
  Voucher List
@endsection

@section('content')
<div class="col-md-12 pt-3">     
    <div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
      <a href="/viewvoucher"><i class="bi bi-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <a href="/viewvoucher">Voucher List</a> / <b>{{ $voucher->name }}</b>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ $voucher->name }}</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
          <a class="btn btn-sm btn-warning" href="{{ url('export-claimedlist') }}/{{ $voucher->voucher_id }}"><i class="bi bi-download pr-2"></i>Export Voucher List</a>
        </div>
    </div>

    @if ($message = Session::get('export-participant'))
      <div class="alert alert-success alert-block">
          <button type="button" class="close" data-bs-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
      </div>
    @endif

    <div class="row">
      <div class="col-md-12 "> 
        
        <!-- Show data in cards --------------------------------------------------->
        <div class="row mb-2">
          <div class="col-md-3 py-2">
            <div class="card border-0 gradient-1 shadow text-center">
              <h6 class="pt-3">Total Claimed</h6>
              <b class="display-6 pb-3">{{ $totalall }}</b>
            </div>
          </div>
          <div class="col-md-3 py-2">
            <div class="card border-0 gradient-3 shadow text-center">
              <h6 class="pt-3">In Progress Voucher</h6>
              <b class="display-6 pb-3">{{ $inprogress }}</b>
            </div>
          </div>
          <div class="col-md-3 py-2">
            <div class="card border-0 gradient-2 shadow text-center">
              <h6 class="pt-3">Complete Voucher</h6>
              <b class="display-6 pb-3">{{ $complete }}</b>
            </div>
          </div>
          <div class="col-md-3 py-2">
            <div class="card border-0 gradient-4 shadow text-center">
              <h6 class="pt-3">Pending Voucher</h6>
              <b class="display-6 pb-3">{{ $pending }}</b>
            </div>
          </div>
        </div>
        <hr>

        <!-- Show package in table ----------------------------------------------->
        @if(count($claimed) > 0)
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
              <tr class="header">
                <th>#</th>
                <th>IC No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th><i class="fas fa-cogs"></i></th>
              </tr>
              </thead>
              <tbody> 
                @foreach ($claimed as $key => $c)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $c->studClaim->ic }}</td>
                    <td>{{ ucwords(strtolower($c->studClaim->first_name)) }} {{ ucwords(strtolower($c->studClaim->last_name)) }}</td>
                    <td>{{ $c->studClaim->email }}</td>
                    <td>
                      @if ($c->status == 'Complete')
                        <i class="badge rounded-pill bg-success"> &nbsp; {{ $c->status }} &nbsp; </i>
                      @elseif ($c->status == 'In Progress' && $c->created_at < $today )
                        <i class="badge rounded-pill bg-danger"> &nbsp; Pending &nbsp; </i>
                      @elseif ($c->status == 'In Progress')
                        <i class="badge rounded-pill bg-warning"> &nbsp; {{ $c->status }} &nbsp; </i>
                      @else
                        <p></p>
                      @endif
                    </td>
                    <td>
                      <a class="btn btn-dark" href="{{ url('viewvoucher/detail') }}/{{ $voucher_id }}/{{ $c->series_no }} "><i class="bi bi-chevron-right"></i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>  
            <div class="float-right">
              {{ $claimed->links() }}
            </div>
          </div>
        @else
          <p>There are no claimed yet.</p>
        @endif
        <div class="float-right pt-3">{{$claimed->links()}}</div>
          <br>
        </div>
        
      </div>
    </div>
  </div>
</div>
@endsection
