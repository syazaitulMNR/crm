@extends('layouts.app')

@section('title')
    Dashboard
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
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        {{-- <p class="lead">{{ $greetings }}, {{ Auth::user()->name }}.</p> --}}
      </div>

      @if ($message = Session::get('updateprofile'))
      <div class="alert alert-info alert-block">
          <button type="button" class="close" data-bs-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
      </div>
      @endif

      <!-- Show data in cards --------------------------------------------------->
      <div class="row mb-3">
        <div class="col-xl-3 col-lg-6">
          <div class="card bg-light card-inverse shadow">
            <div class="card-block">
              <div class="rotate">
                <i class="fa fa-users fa-6x"></i>
              </div>
              <h6 class="text-white pt-3 pl-3">Total Customers</h6>
              <h3 class="pb-1 pl-3 text-white">{{$student}}</h3>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card bg-light card-inverse shadow">
            <div class="card-block">
              <div class="rotate">
                <i class="fa fa-chart-bar fa-6x"></i>
              </div>
              <h6 class="text-white pt-3 pl-3">Today (RM)</h6>
              <h3 class="pb-1 pl-3 text-white">{{$today}}</h3>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card bg-light card-inverse shadow">
            <div class="card-block">
              <div class="rotate">
                <i class="fa fa-chart-area fa-7x"></i>
              </div>
              <h6 class="text-white pt-3 pl-3">Monthly (RM)</h6>
              <h3 class="pb-1 pl-3 text-white">{{$monthly}}</h3>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card bg-light card-inverse shadow">
            <div class="card-block">
              <div class="rotate">
                <i class="fa fa-chart-line fa-6x"></i>
              </div>
              <h6 class="text-white pt-3 pl-3">Yearly (RM)</h6>
              <h3 class="pb-1 pl-3 text-white">{{$yearly}}</h3>
            </div>
          </div>
        </div>
      </div>
        
      <hr class="mb-2">

      <!-- Show data in chart --------------------------------------------------->
      <div id="chartdata" ></div>
    
    </main>
  </div>
</div>

<!-- Function to show chart ----------------------------------------------------->
<script>
  Highcharts.chart('chartdata', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Magic Number'
    },
    subtitle: {
        text: 'Profit of Momentum Internet'
    },
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Profit (RM)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="padding:3">RM </td>' +
            '<td style="padding:3"><b> {point.y:.2f} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Month',
        data: [
            {{$jan}},
            {{$feb}},
            {{$mar}},
            {{$apr}},
            {{$may}},
            {{$jun}},
            {{$jul}},
            {{$aug}},
            {{$sep}},
            {{$oct}},
            {{$nov}},
            {{$dec}}
          ]

    }]
  });
</script>

@endsection
