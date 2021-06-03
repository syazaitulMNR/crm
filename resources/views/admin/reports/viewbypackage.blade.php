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

          <div class="btn-group">
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
                      <input type="text" class="form-control" name="pay_price" id="price" value="{{ $package->price }}" required>   
                      </div>
                    </div>
                    <div class="form-group row px-4">
                        <label for="name" class="col-sm-4 col-form-label">Quantity</label>
                        <div class="col-sm-8">
                          {{-- <input type="hidden" class="form-control" name="quantity" value="1" readonly> --}}
                          {{-- <label class="col-form-label">1</label> --}}
                          <select id="quantity" name="quantity" onchange="calculateAmount(this.value)" class="form-select" required>
                            <option value="" disabled selected>-- Tiket --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                          </select>
                        </div>
                    </div>
                    <div class="form-group row px-4">
                        <label for="name" class="col-sm-4 col-form-label">Total Payment (RM)</label>
                        <div class="col-sm-8">
                          {{-- <input type="hidden" class="form-control" name="totalprice" value="{{ $package->price }}" readonly> 
                          <label class="col-form-label">{{$package->price}}</label> --}}
                          <input type="text" id="totalprice" class="form-control" name="totalprice" style="border: none; outline-width: 0; background-color: #fff;" readonly>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row px-4">
                      <label for="name" class="col-sm-4 col-form-label">Offer Type</label>
                      <div class="col-sm-8">
                        <select name="offer_id" class="form-select" required>
                          <option value="" disabled selected>-- Please Choose --</option>
                          <option value="OFF001">No Offer</option>
                          <option value="OFF002">Buy 1 Free 1 (Same Ticket)</option>
                          <option value="OFF003">Bulk Offer</option>
                        </select>
                      </div>
                    </div>

                    <div class='col-md-12 text-right px-4'>
                        <button type='submit' class='btn btn-success'> <i class="fas fa-save pr-1"></i> Save </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <a href="{{ url('import-customer') }}/{{ $product->product_id }}/{{ $package->package_id }}" type="button" class="btn btn-outline-primary"><i class="fas fa-upload pr-1"></i> Import Customer</a>
          </div>
          {{-- <a href="{{ url('new-customer') }}/{{ $product->product_id }}/{{ $package->package_id }}" class="btn btn-dark"><i class="fas fa-plus pr-1"></i> New Customer</a> --}}
          
            
        </div>

        {{-- <div class="row">
          <div class="col-md-9 ">  --}}
            <!-- Show data in cards --------------------------------------------------->
            <div class="row mb-3">
              <div class="col-xl-3 col-lg-6">
                <div class="card bg-light card-inverse shadow">
                  <div class="card-block">
                    <div class="rotate">
                      <i class="fas fa-dollar-sign fa-6x" style="color:rgba(0, 255, 94, 0.3)"></i>
                    </div>
                    <h6 class="lead pt-3 pl-3">Success Payment</h6>
                    <h3 class="pb-1 pl-3">{{ number_format($totalsuccess) }}</h3>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card bg-light card-inverse shadow">
                  <div class="card-block">
                    <div class="rotate">
                      <i class="fa fas fa-dollar-sign fa-6x" style="color: rgba(255, 0, 0, 0.3)"></i>
                    </div>
                    <h6 class="lead pt-3 pl-3">Due Payment</h6>
                    <h3 class="pb-1 pl-3">{{ number_format($totalcancel) }}</h3>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <a href="{{ url('paid-ticket') }}/{{ $product->product_id }}/{{ $package->package_id }}" class="card bg-light card-inverse shadow" style="text-decoration: none">
                  <div class="card-block">
                    <div class="rotate">
                      <i class="fas fa-ticket-alt fa-6x" style="color: rgba(17, 0, 255, 0.3)"></i>
                    </div>
                    <h6 class="lead pt-3 pl-3">Paid Ticket</h6>
                    <h3 class="pb-1 pl-3">{{ number_format($paidticket) }}</h3>
                  </div>
                </a>
              </div>
              <div class="col-xl-3 col-lg-6">
                <a href="{{ url('free-ticket') }}/{{ $product->product_id }}/{{ $package->package_id }}" class="card bg-light card-inverse shadow" style="text-decoration: none">
                  <div class="card-block">
                    <div class="rotate">
                      <i class="fas fa-ticket-alt fa-6x" style="color: rgba(0, 221, 255, 0.3)"></i>
                    </div>
                    <h6 class="lead pt-3 pl-3">Free Ticket</h6>
                    <h3 class="pb-1 pl-3">{{ number_format($freeticket) }}</h3>
                  </div>
                </a>
              </div>
            </div>

            <br>       
            
            @if ($message = Session::get('addsuccess'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
            </div>
            @endif

            @if ($message = Session::get('importsuccess'))
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

            @if ($message = Session::get('deletepayment'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
            </div>
            @endif

            @if ($message = Session::get('search-error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
            </div>
            @endif

            <!-- Search box ---------------------------------------------------------->
            <form action="{{ url('customer/search') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="GET" class="needs-validation" novalidate>
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Enter IC Number" name="search" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </form>

            <!-- Show success payment in table ----------------------------------------------->
            {{-- <div class="float-right">{{$payment->links()}}</div>    --}}
            @if(isset($details))
              <table class="table table-hover" id="successTable">
                  <thead>
                  <tr class="header">
                    <th>#</th>
                    <th>IC No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    {{-- <th>Status</th> --}}
                    <th class="text-center">Update Participant</th> 
                    <th><i class="fas fa-cogs"></i></th>
                  </tr>
                  </thead>
                  <tbody> 
                    @foreach ($payment as $key => $payments)
                    @foreach ($student as $students)   
                    @if ($payments->stud_id == $students->stud_id)
                    @if ($product->product_id == $payments->product_id)  
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $students->ic }}</td>
                        <td>{{ $students->first_name }} {{ $students->last_name }}</td>
                        <td>{{ $students->email }}</td>
                        {{-- <td>
                          @if ($payments->status == 'paid')
                            <span class="badge rounded-pill bg-success"> &nbsp;{{ $payments->status }}&nbsp; </span>
                          @elseif ($payments->status == 'due')
                            <span class="badge rounded-pill bg-danger"> &nbsp;{{ $payments->status }}&nbsp; </span>
                          @else
                            <p>NULL</p>
                          @endif
                        </td> --}}
                        <td class="text-center">
                          @if ($payments->update_count == 1)
                            <i class="fas fa-check" style="color:green"></i>
                          @elseif ($payments->update_count == Null)
                            <i class="fas fa-times" style="color:red"></i>
                          @else
                            <p>NULL</p>
                          @endif
                        </td>
                        <td>
                          <a class="btn btn-dark" href="{{ url('viewpayment') }}/{{ $product->product_id }}/{{ $payments->package_id }}/{{ $payments->payment_id }}/{{ $payments->stud_id }}"><i class="fas fa-chevron-right"></i></a>

                          @if(Auth::user()->role_id == 'ROD003' || Auth::user()->role_id == 'ROD004')
                          @else
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $payments->payment_id }}"><i class="fas fa-trash-alt"></i></button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $payments->payment_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Are you sure you want to delete this payment ?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a class="btn btn-danger" href="{{ url('delete') }}/{{ $payments->payment_id }}/{{ $product->product_id }}/{{ $payments->package_id }}">Delete</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          @endif
                        </td>
                    </tr>
                    @endif
                    @endif
                    @endforeach
                    @endforeach
                  
                  </tbody>
              </table>  
            @endif

            <table class="table table-hover" id="successTable">
              <thead>
              <tr class="header">
                <th>#</th>
                <th>IC No.</th>
                <th>Name</th>
                <th>Email</th>
                <th class="text-center">Update Participant</th> 
                <th><i class="fas fa-cogs"></i></th>
              </tr>
              </thead>
              <tbody> 
                @foreach ($payment as $key => $payments)
                @foreach ($student as $students)   
                @if ($payments->stud_id == $students->stud_id)
                @if ($product->product_id == $payments->product_id)  
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $students->ic }}</td>
                    <td>{{ $students->first_name }} {{ $students->last_name }}</td>
                    <td>{{ $students->email }}</td>
                    <td class="text-center">
                      @if ($payments->update_count == 1)
                        <i class="fas fa-check" style="color:green"></i>
                      @elseif ($payments->update_count == Null)
                        <i class="fas fa-times" style="color:red"></i>
                      @else
                        <p>NULL</p>
                      @endif
                    </td>
                    <td>
                      <a class="btn btn-dark" href="{{ url('viewpayment') }}/{{ $product->product_id }}/{{ $payments->package_id }}/{{ $payments->payment_id }}/{{ $payments->stud_id }}"><i class="fas fa-chevron-right"></i></a>

                      @if(Auth::user()->role_id == 'ROD003' || Auth::user()->role_id == 'ROD004')
                      @else
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $payments->payment_id }}"><i class="fas fa-trash-alt"></i></button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $payments->payment_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                Are you sure you want to delete this payment ?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a class="btn btn-danger" href="{{ url('delete') }}/{{ $payments->payment_id }}/{{ $product->product_id }}/{{ $payments->package_id }}">Delete</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endif
                    </td>
                </tr>
                @endif
                @endif
                @endforeach
                @endforeach
              </tbody>
            </table>  
          {{-- </div> --}}
                    
        {{-- </div> --}}
        
    </main>
  </div>
</div>

<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
</script>

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
