{{-- {{dd('john')}} --}}
@extends('layouts.app')

@section('title')
Sales Report
@endsection

<style>
  label {
      font-family: sans-serif;
      font-size: 1rem;
      padding-right: 10px;
  }

  select {
      font-size: .9rem;
      padding: 2px 5px;
  }

  .list-group {
            list-style: none;
            margin: 0;
            padding: 0;
            border: 1px solid #ccc;
            border-radius: .5em;
        }

        .list-group li {
            border-top: 1px solid #ccc;
            padding: .5em;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .list-group li:first-child {
            border-top: 0;
        }

        .list-group .badge {
            background-color: rebeccapurple;
            color: #fff;
            font-weight: bold;
            font-size: 80%;
            border-radius: 10em;
            min-width: 1.5em;
            padding: .25em;
            text-align: center
        }


</style>  


@section('content')
<div class="col-md-12 pt-3">     
    <div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
      <a href="/trackprogram"><i class="bi bi-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <a href="/trackprogram">Sales Report</a> / <b>{{ $product->name }}</b>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ $product->name }}</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group">
            <!-- Button trigger modal exportProgram -->
            <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#exportProgram">
              <i class="bi bi-download pr-2"></i>Export Buyer
            </button>
            <!-- Modal -->
            <div class="modal fade" id="exportProgram" tabindex="-1" role="dialog" aria-labelledby="exportProgramLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="exampleModalLabel">Export Buyer</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="{{ url('exportProgram') }}/{{ $product->product_id }}" method="POST"> 
                  @csrf
                  
                    <div class='col-md-12 px-4'>
                      
                      <p>Please choose the data that you want to export :</p>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter_export" id="exampleRadios2" value="success_payment">
                        <label class="form-check-label" for="exampleRadios2">
                          Success Payment Only
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter_export" id="exampleRadios2" value="updated_participant">
                        <label class="form-check-label" for="exampleRadios2">
                          Updated Participant Form Only
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter_export" id="exampleRadios2" value="manual_register">
                        <label class="form-check-label" for="exampleRadios2">
                          Manual Registration Only
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter_export" id="exampleRadios2" value="all_buyer">
                        <label class="form-check-label" for="exampleRadios2">
                          All Buyer
                        </label>
                      </div>

                      <br>

                      <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Send to</label>
                        <div class="col-sm-10">
                          <input type="email" name="receipient_mail" placeholder="Receipient email address" value="{{ Auth::user()->email }}" class="form-control form-control-sm" required>
                        </div>
                      </div>
                    </div>

                    <div class='col-md-12 text-right px-4 pb-4'>
                      <button type='submit' class='btn btn-success'> <i class="bi bi-download pr-2"></i>Export</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Button trigger modal export participant -->
            <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#exportParticipant">
              <i class="bi bi-download pr-2"></i>Export Participant
            </button>
            <!-- Modal -->
            <div class="modal fade" id="exportParticipant" tabindex="-1" role="dialog" aria-labelledby="exportParticipantLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="exampleModalLabel">Export Participant</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="{{ url('export-participant') }}/{{ $product->product_id }}" method="get"> 
                  @csrf
                  
                    <div class='col-md-12 px-4'>
                      
                      <p>Please choose the data that you want to export :</p>
                      
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter_export" id="exampleRadios2" value="manual_participant">
                        <label class="form-check-label" for="exampleRadios2">
                          Manual Participant Only
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter_export" id="exampleRadios2" value="all_participant">
                        <label class="form-check-label" for="exampleRadios2">
                          All Participant
                        </label>
                      </div>

                      <br>

                      <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Send to</label>
                        <div class="col-sm-10">
                          <input type="email" name="receipient_mail" placeholder="Receipient email address" value="{{ Auth::user()->email }}" class="form-control form-control-sm" required>
                        </div>
                      </div>

                    </div>

                    <div class='col-md-12 text-right px-4 pb-4'>
                      <button type='submit' class='btn btn-success'> <i class="bi bi-download pr-2"></i>Export</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            {{-- <a class="btn btn-sm btn-outline-warning" href="{{ url('export-participant') }}/{{ $product->product_id }}"><i class="bi bi-download pr-2"></i>Export Participant</a> --}}
          </div>
        </div>
    </div>        

    @if ($message = Session::get('export-buyer'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">×</button>	
        <strong>{{ $message }}</strong>
    </div>
    @endif

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
          <div class="col-xl-2 col-lg-6 py-2">
            <div class="card border-0 gradient-1 shadow text-center">
              <h6 class="pt-3">Registration</h6>
              <b class="display-6 pb-3">{{ number_format($totalsuccess) }}</b>
            </div>
          </div>
          <div class="col-xl-2 col-lg-6 py-2">
            <div class="card border-0 gradient-3 shadow text-center">
              <h6 class="pt-3">Updated Paid Ticket</h6>
              <b class="display-6 pb-3">{{ number_format($paidticket) }}</b>
            </div>
          </div>
          <div class="col-xl-2 col-lg-6 py-2">
            <div class="card border-0 gradient-2 shadow text-center">
              <h6 class="pt-3">Updated Free Ticket</h6>
              <b class="display-6 pb-3">{{ number_format($freeticket) }}</b>
            </div>
          </div>
          <div class="col-xl-2 col-lg-6 py-2">
            <div class="card border-0 gradient-4 shadow text-center">
              <h6 class="pt-3">Pending Payment</h6>
              <b class="display-6 pb-3">{{ number_format($totalcancel) }}</b>
            </div>
          </div>

          <div class="col-xl-2 col-lg-6 py-2 " >
            <div class="card border-0 gradient-6 shadow text-center">
              <h6 class="pt-3">Kehadiran Disahkan</h6>
              <b class="display-6 pb-3"> {{ number_format($pdisahkan) }}</b>
            </div>
          </div>
          <div class="col-xl-2 col-lg-6 py-2" >
            <div class="card border-0 shadow text-center">
              <ul class="list-group" >
                <li >Hadir <span class="badge">{{ number_format($phadir) }}</span></li>
                <li >Tidak hadir <span class="badge">{{ number_format($pth) }}</span></li>
                <li >Lain-Lain <span class="badge">{{ number_format($plain) }}</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Show package in table ----------------------------------------------->
        @if(count($package) > 0)
        <div class="table-responsive">
          <table class="table table-hover">
              <thead>
              <tr class="header">
                  <th>#</th>
                  <th>Package</th>
                  <th class="col-md-4"><i class="fas fa-cogs"></i></th>
              </tr>
              </thead>
              <tbody>
              @foreach ($package as $key => $packages)    
              @if ($product->product_id == $packages->product_id)   
              <tr>
                <td>{{ $package->firstItem() + $key }}</td>
                <td>{{ $packages->name  }}</td>
                <td>
                  <a class="btn btn-sm btn-dark" href="{{ url('view/buyer') }}/{{ $product->product_id }}/{{ $packages->package_id }}"><i class="bi bi-person pr-2"></i>Buyer</a>                    
                  <a class="btn btn-sm btn-dark" href="{{ url('view/participant') }}/{{ $product->product_id }}/{{ $packages->package_id }}"><i class="bi bi-people pr-2"></i>Participant</a>
                  @if ($product->class == "MMB")
                    <a class="btn btn-sm btn-primary" href="{{ url('download/attendance') }}/{{ $product->product_id }}/{{ $packages->package_id }}"><i class="fa fa-download pr-2"></i>Attendance</a>
                  @else
                  @endif
                </td>
              </tr>
              @endif
              @endforeach
              </tbody>
          </table>  
        </div>
        @else
        <p>There are no package yet.</p>
        @endif
        <div class="float-right pt-3">{{$package->links()}}</div>
        
        <!--- Display upgrade link ---->
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="">Detail Link</th>
                <th scope="col">Link</th>          
                <th scope="col"></th>
                {{-- <th scope="col">Image</th> --}}
                <th scope="col" class="col-mb-2"><i class="fas fa-cogs"></i></th>
              </tr>
            </thead>
            <tbody>
            <div class="table-responsive">
              <tr>
                <td>Upgrade Link</td>
                <td><input type="text" class="form-control" value="{{ $link }}" id="myInput" readonly></td>
                {{-- <td>{{ $packages->package_image  }}</td> --}}
                <td>
                  <div class="row">
                    <script>
                      function myFunction() {
                        var copyText = document.getElementById("myInput");
                        copyText.select();
                        copyText.setSelectionRange(0, 99999)
                        document.execCommand("copy");
                      }
                    </script>
                    <td>                  
                      <a class="btn btn-sm btn-dark mt-1" onclick="myFunction()">Copy</a>
                    </td>
                  </div>  
                </td>
              </tr> 
              @if($product->cert_image != NULL)
                <tr>
                  <td>E-Certificate Link</td>
                  <td><input type="text" class="form-control" value="{{ $ecert }}" id="ecert" readonly></td>
                  <td>
                    <div class="row">
                      <script>
                        function certFunction() {
                          var copyText = document.getElementById("ecert");
                          copyText.select();
                          copyText.setSelectionRange(0, 99999)
                          document.execCommand("copy");
                        }
                      </script>
                      <td>                  
                        <a class="btn btn-sm btn-dark mt-1" onclick="certFunction()">Copy</a>
                        <a href="{{ $product->cert_image }}" class="btn btn-sm btn-dark mt-1" target="_blank">Template</a>
                      </td>
                    </div>
                  </td>
                </tr>
              @endif
            </div>
          </table>

          {{-- Untuk kegunaan offline event sahaja --}}
          @if ($product->class == "MMB")
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="">Package</th>
                    <th scope="col">Link Sah Kehadiran (Kegunaan Offline Event)</th>          
                    <th scope="col"></th>
                    <th scope="col" class="col-mb-2"><i class="fas fa-cogs"></i></th>
                  </tr>
                </thead>

                <tbody>
                  @foreach ($package as $key => $packages)    
                    @if ($product->product_id == $packages->product_id) 
                      <tr>
                        <td>{{ $packages->name }}</td>
                        <td><input type="text" class="form-control" value="{{ $sah }}{{ $packages->package_id }}" id="sah" readonly></td>
                        <td>
                          <div class="row">
                            <script>
                              function sahFunction() {
                                var copyText = document.getElementById("sah");
                                copyText.select();
                                copyText.setSelectionRange(0, 99999)
                                document.execCommand("copy");
                              }
                            </script>
                            <td>                  
                              <a class="btn btn-sm btn-dark mt-1" onclick="sahFunction()">Copy</a>
                            </td>
                          </div>
                        </td>
                      </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif

          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Export Details</th>
                  <th class="col-mb-4"><i class="fas fa-cogs"></i></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{ $product->name }} Export Survey</td>
                  <td><a class="btn btn-sm btn-success" href="{{ url('export-surveyform') }}/{{ $product->product_id }}"><i class="fa fa-download pr-2"></i>Download</a></td>
                </tr> 
              </tbody>
            </table> 
          </div>
          
           
          
          {{-- <select class="form-control" name="product_id">
          @foreach ($data as $key => $value)
            <option value="{{ $key }}" {{ ( $key == $selectedID) ? 'selected' : '' }}>{{ $key }} 
            </option>
            @if (($key == $key) == true)
              @foreach ($value as $keys => $values)
                <span>{{ $values->stud_id }}</span>
              @endforeach
            @else
            @endif
          @endforeach
          </select> --}}
        </div>

        <br>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
