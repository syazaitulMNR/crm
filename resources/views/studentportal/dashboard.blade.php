

@extends('studentportal.app')

@section('title')
Customer Profiles
@endsection

@section('content')
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

    body{margin-top:20px;}
    .timeline {
        border-left: 3px solid #727cf5;
        border-bottom-right-radius: 4px;
        border-top-right-radius: 4px;
        background: rgba(114, 124, 245, 0.09);
        left: 40px;
        margin: 0 auto;
        letter-spacing: 0.2px;
        position: relative;
        line-height: 1.4em;
        font-size: 1.03em;
        padding: 20px;
        list-style: none;
        text-align: left;
        max-width: 55%;
    }

    @media (max-width: 767px) {
        .timeline {
            max-width: 98%;
            padding: 25px;
        }
    }

    .timeline h1 {
        font-weight: 300;
        font-size: 1.4em;
    }

    .timeline h2,
    .timeline h3 {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 10px;
    }

    .timeline .event {
        border-bottom: 1px dashed #e8ebf1;
        padding-bottom: 25px;
        margin-bottom: 25px;
        position: relative;
    }

    @media (max-width: 767px) {
        .timeline .event {
            padding-top: 30px;
        }
    }

    .timeline .event:last-of-type {
        padding-bottom: 0;
        margin-bottom: 0;
        border: none;
    }

    .timeline .event:before,
    .timeline .event:after {
        position: absolute;
        display: block;
        top: 0;
    }

    .timeline .event:before {
        left: -177px;
        content: attr(data-date);
        text-align: right;
        font-weight: 100;
        font-size: 0.9em;
        min-width: 120px;
    }

    @media (max-width: 767px) {
        .timeline .event:before {
            left: 0px;
            text-align: left;
        }
    }

    .timeline .event:after {
        -webkit-box-shadow: 0 0 0 3px #727cf5;
        box-shadow: 0 0 0 3px #727cf5;
        left: -26px;
        background: #fff;
        border-radius: 50%;
        height: 9px;
        width: 9px;
        content: "";
        top: 5px;
    }

    @media (max-width: 767px) {
        .timeline .event:after {
            left: -31.8px;
        }
    }

    .rtl .timeline {
        border-left: 0;
        text-align: right;
        border-bottom-right-radius: 0;
        border-top-right-radius: 0;
        border-bottom-left-radius: 4px;
        border-top-left-radius: 4px;
        border-right: 3px solid #727cf5;
    }

    .rtl .timeline .event::before {
        left: 0;
        right: -170px;
    }

    .rtl .timeline .event::after {
        left: 0;
        right: -55.8px;
    }

    .pre-scrollable {
        max-height: 100px;
        overflow-y: scroll;
    }
    .bs-example{
    	margin: 20px;
    }
</style>

@section('content')
    <div class="col-md-12 pt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ url('customer_profiles') }}">Customer Profiles</a></li>
              <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
        @if ($message = Session::get('subsSuccess'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-bs-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if ($message = Session::get('subsError'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-bs-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if ($message = Session::get('commentSuccess'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-bs-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if ($message = Session::get('commentError'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-bs-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
        @endif
        
        <div class="flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom bs-example">
            <h1 class="h2">Customer Information</h1>
            <div class="">
            <div class="align-right">
            <a href="statement-format" class="btn btn-primary "><i class="fas fa-download pr-2"></i>Download Statement</a>
            <a href="list-invoice" class="btn btn-danger "><i class="fa fa-money pr-2"></i>Payment Due</a>
            </div>
            </div>
        </div>

        <div class="col-md-12">

            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Paid (Monthly)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">RM {{ number_format($total_paid_month) }}.00</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Total Paid (Overall)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">RM {{ number_format($total_paid) }}.00</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Events</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_event }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Membership Level</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $member_lvl }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <h5 class="m-3 fw-bolder">Affiliate Details</h5>
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Closing (Overall)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">130</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-thumbs-up fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Commission (Overall)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">RM 28 360.56</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Paid Commission</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">RM 15 000.00</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa fa-check-circle-o fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Balance</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">RM 13 360.56</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-6 pt-3">
                    <div class="card">
                        <div class="card-header">
                            <strong>Affiliate Overview</strong>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3 mb-3">
                                    <div class="fw-bolder">Daily Closing</div>
                                    <div class="text-success lh-1 fs-3 fw-bolder">8</div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="fw-bolder">Weekly Closing</div>
                                    <div class="text-success lh-1 fs-3 fw-bolder">21</div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="fw-bolder">Monthly Closing</div>
                                    <div class="text-success lh-1 fs-3 fw-bolder">52</div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="fw-bolder">Yearly Closing</div>
                                    <div class="text-success lh-1 fs-3 fw-bolder">136</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-select float-end" style="width: 100px">
                                        <option value="2020"> 2020 </option>
                                        <option value="2021"> 2021 </option>
                                        <option selected value="2022"> 2022 </option>
                                    </select>
                                    <select class="form-select float-end" style="width: 100px" id="selectid" onchange="generate_chart()">
                                        <option value="day"> Day </option>
                                        <option value="week"> Week </option>
                                        <option selected value="month"> Month </option>
                                        <option value="year"> Year </option>
                                    </select>
                                    
                                    <canvas id="chart"></canvas>
                                    
                                </div>
                            </div>
                        </div>
                    </div>                        
                </div>
 
                <div class="col-md-6 pt-3">                            
                    <div class="card">
                        <div class="card-header">
                            <strong><i class="fa fa-fire text-danger" aria-hidden="true"></i> Top 10 Affiliate</strong>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 pt-3 table-responsive" id="content" >
                                <table class="table table-hover table-sm">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Closing</th>
                                            <th scope="col">Commission</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <th class="text-center">1</th>
                                            <td>demo user</td>
                                            <td class="text-center">145</td>
                                            <td class="text-center">RM 35 000.56</td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">2</th>
                                            <td>Nurzarinah Zakaria</td>
                                            <td class="text-center">130</td>
                                            <td class="text-center">RM 28 360.56</td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">3</th>
                                            <td>demo user</td>
                                            <td class="text-center">145</td>
                                            <td class="text-center">RM 35 000.56</td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">4</th>
                                            <td>demo user</td>
                                            <td class="text-center">145</td>
                                            <td class="text-center">RM 35 000.56</td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">5</th>
                                            <td>demo user</td>
                                            <td class="text-center">145</td>
                                            <td class="text-center">RM 35 000.56</td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">6</th>
                                            <td>demo user</td>
                                            <td class="text-center">145</td>
                                            <td class="text-center">RM 35 000.56</td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">7</th>
                                            <td>demo user</td>
                                            <td class="text-center">145</td>
                                            <td class="text-center">RM 35 000.56</td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">8</th>
                                            <td>demo user</td>
                                            <td class="text-center">145</td>
                                            <td class="text-center">RM 35 000.56</td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">9</th>
                                            <td>demo user</td>
                                            <td class="text-center">145</td>
                                            <td class="text-center">RM 35 000.56</td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">10</th>
                                            <td>demo user</td>
                                            <td class="text-center">145</td>
                                            <td class="text-center">RM 35 000.56</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 pt-3">
                    <div class="card">
                        <div class="card-header">
                            <strong>
                                Personal Details 
                                @if ($student_detail->status == 'Terminate')
                                    <span class="badge bg-dark">{{ $student_detail->status }}</span>
                                @endif
                                @if ($student_detail->status == 'Active')
                                    <span class="badge bg-success">{{ $student_detail->status }}</span>
                                @endif
                                @if ($student_detail->status == 'Pending')
                                    <span class="badge bg-warning">{{ $student_detail->status }}</span>
                                @endif
                                @if ($student_detail->status == 'Stop' || $student_detail->status == 'Break')
                                    <span class="badge bg-danger">{{ $student_detail->status }}</span>
                                @endif
                            </strong>
                        </div>
            
                        <div class="card-body" style="height: 380px;">
                            <form  action="{{ url('update_cust', $student_detail) }}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="First Name">First Name</label>
                                        <input type="text" name="first" class="form-control" value="{{ $student_detail->first_name }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="First Name">Last Name</label>
                                        <input type="text" name="last" class="form-control" value="{{ $student_detail->last_name }}" disabled>
                                    </div>
                                </div>
            
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="IC Number">IC Number</label>
                                        <input type="text" name="ic" class="form-control" value="{{ $student_detail->ic }}" disabled>
                                    </div>
                                
                                    <div class="form-group col-md-6">
                                        <label for="First Name">Email Address</label>
                                        <input type="text" name="email" class="form-control" value="{{ $student_detail->email }}" disabled>
                                    </div>
                                </div>
            
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="Phone Number">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" value="{{ $student_detail->phoneno }}" disabled>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 pt-3">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <div class="card"> -->
                                <div class="card-header">
                                    <strong>Timeline</strong>
                                </div>
                                <div class="card-body">
                                    <div id="content" class="overflow-auto" style="height: 350;">
                                        <ul class="timeline">
                                            @foreach ($data as $key => $d)
                                                <li class="event" data-date="{{ $d->date_from }}">
                                                    <h3>{{ $d->name }}</h3>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>

            <hr>
            
            <div class="row">
                <div class="col-md-6 pt-3">
                    <div class="card">
                        <div class="card-header">
                            <strong>Payment Details</strong>
                        </div>
            
                        <div class="card-body">
                            <div class="col-md-12 pt-3 table-responsive" id="content" class="overflow-auto" style="height: 350px;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Paid Date</th>
                                            <th scope="col">Paid Price</th>
                                            <th scope="col">Download</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($payment as $key => $p)
                                            <tr>
                                                <th scope="row">{{ $key+1 }}</th>
                                                <td>
                                                    {{ $membership_level->name }}
                                                </td>
                                                <td>
                                                    {{ date('d/m/Y', strtotime($p->created_at)) }}
                                                </td>
                                                <td>
                                                    RM {{ $p->pay_price }}.00
                                                </td>
                                                <td>
                                                    {{-- <a href="{{ url('download-receipt') }}/{{ $membership_level->level_id }}/{{ $p->payment_id }}/{{ $student->id }}" class="btn-sm btn-secondary mr-8 float-left text-decoration-none"><i class="fas fa-download pr-2"></i>Receipt</a> --}}
                                                    <a href="{{ url('/student/receipt') }}/{{ $membership_level->level_id }}/{{ $p->payment_id }}/{{ $stud_id }}" class="btn-sm btn-danger mr-8 float-left"><i class="fas fa-download pr-2"></i>Receipt</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No result founds</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div><hr>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 pt-3">
                    <div class="card">
                        <div class="card-header">
                            <strong>Comment</strong>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 pt-3 table-responsive" id="content" class="overflow-auto" style="height: 350px;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Comments</th>
                                            <th scope="col">Author</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($ncomment as $key => $c)
                                            <tr>
                                                <th scope="row">{{ $key+1 }}</th>
                                                <td>{{ $c->comment }}</td>
                                                <td>{{ $c->author }}</td>
                                                <td>{{ date('d/m/Y', strtotime($c->created_at)) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No result founds</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- <div class="col-md-12 overflow-auto" style="height: 230px;">
                                @forelse ($ncomment as $key => $c)
                                    <div class="form-group">
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="1" disabled>{{ $c->comment }}</textarea>
                                    </div>
                                @empty
                                <div class="form-group">
                                    <p class="text-center mx-auto">No Comments Found</p>
                                </div>
                                @endforelse
                            </div> --}}
                            <hr>
                            

                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Comment</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ url('add_comment', $student_detail) }}" method="post">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="message-text" class="col-form-label">Comment:</label>
                                                    <textarea class="form-control" onfocus="this.value=''" name="comment" placeholder="Add comment here.." required></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Add Comment</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
        
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>   
    
<script>
    var xValues = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var yValues = [ 14,20,42,52,0, 0,0,0,0,0, 0,0 ];
    
    chart = new Chart(document.getElementById("chart"), {
        type: 'line',
        data: {
            labels: xValues,
            datasets: [{
            label: 'Closing Number',
            data: yValues,
            fill: false,
            borderColor: '#0E9036',
            tension: 0.1

            }]
        },
    });

    function generate_chart() {
        var conceptName = $('#selectid').find(':selected').text();
        console.log(conceptName);
        var xValues = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var yValues = [ 14,20,42,52,0, 0,0,0,0,0, 0,0 ];

        if(document.getElementById('selectid').value == "day") {
        var xValues = [ '1/4', '2/4', '3/4', '4/4', '5/4', '6/4', '7/4', '8/4', '9/4', '10/4',
                '11/4', '12/4', '13/4', '14/4', '15/4', '16/4', '17/4', '18/4', '19/4', '20/4',
                '21/4', '22/4', '23/4', '24/4', '25/4', '26/4', '27/4', '28/4', '29/4', '30/4' ];
        var yValues = [ 2,0, 0,5,21,0,0,0,0, 0,11,23,21,3,4,1, 9,2,8,2,0,0,0, 0,0,0,0,0,0,0];

    } else if(document.getElementById('selectid').value == "week") {
        var xValues = [ 'week 1', 'week 2', 'week 3', 'week 4', 'week 5', 'week 6', 'week 7', 'week 8', 'week 9', 'week 10',
                'week 11', 'week 12', 'week 13', 'week 14', 'week 15', 'week 16', 'week 17', 'week 18', 'week 19', 'week 20',
                'week 21', 'week 22', 'week 23', 'week 24', 'week 25', 'week 26', 'week 27', 'week 28', 'week 29', 'week 30',
                'week 31', 'week 32', 'week 33', 'week 34', 'week 35', 'week 36', 'week 37', 'week 38', 'week 39', 'week 40',
                'week 41', 'week 42', 'week 43', 'week 44', 'week 45', 'week 45', 'week 47', 'week 48', 'week 49', 'week 50',
                'week 51', 'week 52', 'week 53' ];
        var yValues = [ 0,0,0,12,2,4,5,1,0,10, 2,26,63,21,0,0,0,0,0, 0,0,0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,0,0, 0,0,0];
        
    } else if(document.getElementById('selectid').value == "month") {
        var xValues = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var yValues = [ 14,20,42,52,0, 0,0,0,0,0, 0,0 ];

    } else if(document.getElementById('selectid').value == "year") {
        var xValues = [ '2020', '2021', '2022'];
        var yValues = [ 51,87,136 ];
    }
    
        //generate chart
        chart = new Chart(document.getElementById("chart"), {
        type: 'line',
        data: {
            labels: xValues,
            datasets: [{
            label: 'Closing Number',
            data: yValues,
            fill: false,
            borderColor: '#0E9036',
            tension: 0.1

            }]
        },
        });

    }

</script>
@endsection 