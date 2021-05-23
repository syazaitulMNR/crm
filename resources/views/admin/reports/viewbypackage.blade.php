@extends('layouts.app')

@section('title')
    Sales Tracking
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

  
</style>

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')
<div class="row py-4">     
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
          <a href="{{ url('trackpackage') }}/{{ $product->product_id }}"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> 
          / <a href="/trackprogram">Customer</a> / <a href="{{ url('trackpackage') }}/{{ $product->product_id }}"> {{ $product->name }} </a> 
          / <b>{{ $package->name }}</b>
        </div>
  
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">{{ $package->name }}</h1>

          {{-- <a href="{{ url('new-customer') }}/{{ $product->product_id }}/{{ $package->package_id }}" class="btn btn-dark"><i class="fas fa-plus pr-1"></i> New Customer</a> --}}
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#newcustomer">
            <i class="fas fa-plus pr-1"></i> New Customer
          </button>
          <!-- Modal -->
          <div class="modal fade" id="newcustomer" tabindex="-1" role="dialog" aria-labelledby="newcustomerLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header border-bottom-0">
                  <h5 class="modal-title" id="exampleModalLabel">Add New Customer</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{ url('new-customer/save') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="POST"> 
                @csrf
                  <div class="form-group row px-4">
                      <label for="ic" class="col-sm-4 col-form-label">IC No.</label>
                      <div class="col-sm-8">
                      <input type="text" class="form-control" name="ic" placeholder="950101012036" maxlength="12" required>
                      </div>
                  </div>
                  <div class="form-group row px-4">
                      <label for="name" class="col-sm-4 col-form-label">First Name</label>
                      <div class="col-sm-8">
                      <input type="text" class="form-control" name="first_name" placeholder="John" required>
                      </div>
                  </div>
                  <div class="form-group row px-4">
                      <label for="name" class="col-sm-4 col-form-label">Last Name</label>
                      <div class="col-sm-8">
                      <input type="text" class="form-control" name="last_name" placeholder="Doe" required>
                      </div>
                  </div>
                  <div class="form-group row px-4">
                      <label for="name" class="col-sm-4 col-form-label">Tel No.</label>
                      <div class="col-sm-8">
                      <input type="text" class="form-control" name="phoneno" placeholder="+60123456789" value="+60" required>
                      </div>
                  </div>
                  <div class="form-group row px-4">
                      <label for="name" class="col-sm-4 col-form-label">Email</label>
                      <div class="col-sm-8">
                      <input type="email" class="form-control" name="email" placeholder="example@gmail.com" required>
                      </div>
                  </div>

                  <hr>

                  <div class="form-group row px-4">
                    <label for="ic" class="col-sm-4 col-form-label">Price (RM)</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" name="pay_price" id="price" value="{{ $package->price }}" readonly>   
                    </div>
                  </div>
                  <div class="form-group row px-4">
                      <label for="name" class="col-sm-4 col-form-label">Quantity</label>
                      <div class="col-sm-8">
                        <input type="hidden" class="form-control" name="quantity" value="1" readonly>
                        <label class="col-form-label">1</label>
                        {{-- <select id="quantity" name="quantity" onchange="calculateAmount(this.value)" class="form-select" required>
                          <option value="" disabled selected>-- Tiket --</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                        </select> --}}
                      </div>
                  </div>
                  <div class="form-group row px-4">
                      <label for="name" class="col-sm-4 col-form-label">Total Payment (RM)</label>
                      <div class="col-sm-8">
                        <input type="hidden" class="form-control" name="totalprice" value="{{ $package->price }}" readonly> 
                        <label class="col-form-label">{{$package->price}}</label>
                      {{-- <input type="text" id="totalprice" class="form-control" name="totalprice" style="border: none; outline-width: 0; background-color: none;" readonly> --}}
                      </div>
                  </div>
                                    
                  <div class='col-md-12 text-right px-4'>
                      <button type='submit' class='btn btn-success'> <i class="fas fa-save pr-1"></i> Save </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
            
        </div>

        <div class="row">
          <div class="col-md-9 "> 

            <!-- Search box ---------------------------------------------------------->
            <input type="text" id="successInput" class="form-control" onkeyup="successFunction()" placeholder="Enter IC no." title="Type in a name">
            
            <br>
            
            @if ($message = Session::get('addsuccess'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
            </div>
            @endif

            @if ($message = Session::get('updatepayment'))
            <div class="alert alert-info alert-block">
                <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
            </div>
            @endif

            <!-- Show success payment in table ----------------------------------------------->
            @if(count($payment) > 0)
            <table class="table table-hover" id="successTable">
                <thead>
                <tr class="header">
                  <th>#</th>
                  <th>IC No.</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th><i class="fas fa-cogs"></i></th>
                    {{-- <th>#</th>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Payment (RM)</th>
                    <th>Status</th>
                    <th>Purchase Date</th>
                    <th><i class="fas fa-cogs"></i></th> --}}
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
                        <a class="btn btn-dark" href="{{ url('viewpayment') }}/{{ $product->product_id }}/{{ $payments->package_id }}/{{ $payments->payment_id }}/{{ $payments->stud_id }}"><i class="fas fa-chevron-right"></i></a>
                      </td>
                  </tr>
                  @endif
                  @endif
                  @endforeach
                  @endforeach
                {{-- @foreach ($payment as $key => $payments)    
                @if ($product->product_id == $payments->product_id)  
                <tr>
                    <td>{{ $payment->firstItem() + $key }}</td>
                    <td>{{ $payments->payment_id }}</td>
                    <td>{{ $payments->stud_id }}</td>
                    <td>RM {{ $payments->totalprice }}</td>
                    <td>
                      @if ($payments->status == 'paid')
                        <span class="badge rounded-pill bg-success"> &nbsp;{{ $payments->status }}&nbsp; </span>
                      @elseif ($payments->status == 'due')
                        <span class="badge rounded-pill bg-danger"> &nbsp;{{ $payments->status }}&nbsp; </span>
                      @else
                        <p>NULL</p>
                      @endif
                    </td>
                    <td>{{ date('d/m/Y', strtotime($payments->created_at)) }}</td>
                    <td>
                      <a class="btn btn-primary" href="{{ url('viewpayment') }}/{{ $product->product_id }}/{{ $payments->package_id }}/{{ $payments->payment_id }}/{{ $payments->stud_id }}"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @endif
                @endforeach --}}
                </tbody>
            </table>  
            @else
            <p>There are no any payment yet.</p>
            @endif
            <div class="float-right pt-3">{{$payment->links()}}</div>   
            
          </div>
          
          <div class="col-md-3">

            <div class="card bg-light py-4 mb-4 text-center shadow">
              <div class="card-block text-dark">
                <div class="rotate">
                <i class="fas fa-file-invoice-dollar fa-6x"></i>
                </div>
                <h3 class="pt-3 pl-3">{{$total}}</h3>
                <h6 class="display-1 pb-1 pl-3">Total Purchased</h6>
              </div>
            </div>

            <div class="card bg-light py-4 mb-4 text-center shadow">
              <div class="card-block text-dark">
                
                <i class="far fa-check fa-6x" style="color:rgba(0, 255, 94, 0.3)"></i>
                
                <h3 class="pt-3 pl-3">{{$totalsuccess}}</h3>
                <h6 class="display-1 pb-1 pl-3">Paid</h6>
              </div>
            </div>

            <div class="card bg-light py-4 mb-4 text-center shadow">
              <div class="card-block text-dark">

                <i class="far fa-times fa-6x" style="color:rgba(255, 0, 0, 0.3)"></i>
                
                <h3 class="pt-3 pl-3">{{$totalcancel}}</h3>
                <h6 class="display-1 pb-1 pl-3">Due</h6>
              </div>
            </div>
          
          </div>
          
        </div>
        
    </main>
  </div>
</div>


<!-- Enable function for search payment ------------------------------------->
<script>
  function successFunction() 
  {
    var input, filter, table, tr, td, i, txtValue;

    input = document.getElementById("successInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("successTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) 
    {
      td = tr[i].getElementsByTagName("td")[1];
      
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }       
    }
  }
</script>

<!--
|--------------------------------------------------------------------------
| This function is to calculate Total Price
|--------------------------------------------------------------------------
-->
<script>
  function calculateAmount(val) {
      
    var prices = document.getElementById("price").value;
    var total_price = val * prices;

    /*display the result*/
    var divobj = document.getElementById('totalprice');
    divobj.value = total_price;

  }
  </script>
  

@endsection
