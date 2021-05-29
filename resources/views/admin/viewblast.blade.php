@extends('layouts.app')

@section('title')
  Email Blasting
@endsection

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')
<div class="row py-4">   
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
      <a href="/dashboard">Dashboard</a> / <a href="/emailblast">Email Blasting</a> / Individually Blast
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">{{ $package->name }}</h1>
    </div>

    <br>
    
    <div class="row">
      <div class="col-md-9 "> 
        @if ($message = Session::get('sent-success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-bs-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if(count($payment) > 0)
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>IC No.</th>
              <th>Name</th>
              <th>Status</th>
              <th><i class="fas fa-cogs"></i></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($payment as $key => $payments)
            @foreach ($student as $students)   
            @if ($payments->stud_id == $students->stud_id)
            @if ($product->product_id == $payments->product_id)  
            <tr>
                <td>{{ $payment->firstItem() + $key }}</td>
                <td>{{ $students->ic }}</td>
                <td>{{ $students->first_name }} {{ $students->last_name }}</td>
                <td>
                  @if ($payments->status == 'paid')
                    <span class="badge rounded-pill bg-success"> &nbsp;{{ $payments->status }}&nbsp; </span>
                  @elseif ($payments->status == 'due')
                    <span class="badge rounded-pill bg-danger"> &nbsp;{{ $payments->status }}&nbsp; </span>
                  @else
                    <p>NULL</p>
                  @endif
                </td>
                <td>
                  <a class="btn btn-primary" href="{{ url('view-student') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $payments->payment_id }}/{{ $students->stud_id }}">Confirm</a>
                  {{-- <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#emailModal"><i class="fas fa-paper-plane"></i></button>
                  <!-- Modal -->
                  <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Blast Confirmation</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              Are you sure you want to blast the email to this participant in this event ?
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <a class="btn btn-primary" href="{{ url('send-mail') }}/{{ $product->product_id }}/{{ $package->package_id }}">Confirm</a>
                          </div>
                          </div>
                      </div>
                  </div> --}}
                </td>
            </tr>
            @endif
            @endif
            @endforeach
            @endforeach
          </tbody>
        </table>

        @else
          <p>Purchased confirmation email has been sent to all imported customer</p>
        @endif
        <div class="float-right pt-3">{{$payment->links()}}</div>

      </div>

      <div class="col-md-3">

        <div class="card bg-light py-4 mb-4 text-center shadow">
          <div class="card-block text-dark">
            <div class="rotate">
            <i class="fas fa-file-invoice-dollar fa-6x" style="color:rgba(0, 229, 255, 0.3)"></i>
            </div>
            <h3 class="pt-3 pl-3">{{$total}}</h3>
            <h6 class="lead pb-2 pl-3">Imported Customer</h6>
          </div>
        </div>

        {{-- <div class="card bg-light py-4 mb-4 text-center shadow">
          <div class="card-block text-dark">
            <div class="rotate">
              <i class="fa fas fa-dollar-sign fa-6x" style="color:rgba(0, 255, 94, 0.3)"></i>
            </div>
            <h3 class="pt-3 pl-3">{{$totalsuccess}}</h3>
            <h6 class="lead pb-2 pl-3">Paid</h6>
          </div>
        </div>

        <div class="card bg-light py-4 mb-4 text-center shadow">
          <div class="card-block text-dark">
            <div class="rotate">
              <i class="fa fas fa-dollar-sign fa-6x" style="color:rgba(255, 0, 0, 0.3)"></i>
            </div>
            <h3 class="pt-3 pl-3">{{$totalcancel}}</h3>
            <h6 class="lead pb-2 pl-3">Due</h6>
          </div>
        </div> --}}
      
      </div>
    </div>
  </main>
</div>
@endsection


