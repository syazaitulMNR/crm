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
      <h1 class="h2">Individually Blast</h1>
    </div>

    {{--r {{$totalcust}} --}}

    <div class="float-right pt-3">{{$payment->links()}}</div>
    @if(count($payment) > 0)

    <table class="table table-hover">
      <thead>
        <tr>
        <th scope="col">ID</th>
        <th scope="col">Student Name</th>
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
              x
            </td>
        </tr>
        @endif
        @endif
        @endforeach
        @endforeach
      </tbody>
    </table>


    {{-- <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col" style="width: 10%">#</th>
          <th scope="col">ID</th>
          <th scope="col">Student Name</th>
          <th scope="col">Package</th>
          <th scope="col">Payment Status</th>
          <th scope="col">Blast Email</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($student as $key => $students)
        @foreach ($package as $value)  
        @foreach ($payment as $payments)  
        @if ($product->product_id == $students->product_id) 
        @if ($students->package_id == $value->package_id)  
        @if ($students->stud_id == $payments->stud_id)                 
          <tr>
            <td>{{ $student->firstItem() + $key }}</td>
            <td>{{ $students->stud_id  }}</td>
            <td>{{ $students->first_name  }}&nbsp;{{ $students->last_name  }}</td>
            <td>{{ $value->name  }}</td>
            <td>{{ $payments->status  }}</td>
            <td>
              <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-paper-plane"></i></button>
              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Blast Confirmation</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to blast the email to this participant ?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <a class="btn btn-primary" href="">Confirm</a>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>  
        @endif
        @endif
        @endif 
        @endforeach
        @endforeach 
        @endforeach
      </tbody>
    </table> --}}
    @else
      <p>There are no customer to display.</p>
    @endif

  </main>
</div>
@endsection


