@extends('layouts.temp')

@section('title')
  Tahniah
@endsection
<head>
  
</head>

<style>
  body {
    background-color:rgb(255, 255, 255)!important ; 
  }
    .video-size{
      width: 600px;
    }

    @media screen and (max-width: 600px) {
  /* For mobile phones: */
    .center {
      margin: auto;
      width: 100%;
      padding: 10px;
      text-align: center;
    }

    .video-size{
      width: 100%;
    }
}

</style>

@section('content')
<div class="row">
  <div class="col-md-12 px-3 pt-5 pb-3 text-center">
      <h1 class="display-1 fw-bolder px-4 pt-3">TAHNIAH!</h1>
      <h5 class="pb-3">Anda sudah berjaya menebus <b>{{ $voucher->name }}</b></h5>
      <i class="fa fa-check fa-5x text-success text-center"></i>
  </div>
</div>

<div class="row py-5" style="background-color: #F5C7A9">
  <div class="col-md-6 mx-auto mt-2">
    <table class="table table-borderless table-responsive table-sm">
      <div>
        <tr>
          <td class="text-end col-md-6">No. Siri  :</td>
          <td class="fw-bold col-md-6"> {{ $claimed->series_no }}</td>
        </tr>
  
        <tr>
          <td class="text-end">No. IC/Passport  :</td>
          <td class="fw-bold">  {{ $student->ic }}</td>
        </tr>

        <tr>
          <td class="text-end">Nama Penuh   :</td>
          <td class="fw-bold">  {{ $student->first_name }}&nbsp;{{ $student->last_name }}</td>
        </tr>
  
        <tr>
          <td class="text-end">Facebook Page  :</td>
          <td class="fw-bold">  {{ $claimed->fb_page }}</td>
        </tr>

        <tr>
          <td class="text-end">Tarikh Masa Tebus  :</td>
          <td class="fw-bold">  {{ date('d/m/Y g:i A', strtotime($claimed->created_at. '+8hours')) }}</td>
        </tr>
      </div>
    </table>

    <div class="text-center pb-4 pt-2">
      <a class="text-end btn btn-dark" href="{{ url('download-voucher') }}/{{ $voucher_id }}/{{ $stud_id }}/{{ $series_no }}" target="blank">Download Voucher</a>
    </div>
  </div>

  <div class="col-md-6 px-5 text-center">
    <img src="{{ $voucher->img_path }}" style="max-width:100%">
    {{-- <img src="{{ asset('assets/images/voucher/img_62d8fc112b286.jpg') }}" style="max-width:100%"> --}}
  </div>
</div>

<div class="text-center pt-3 pb-5">
  <p class="lead">
    Jika terdapat sebarang pertanyaan, sila <a href="http://bit.ly/journeymomentuminternet" class="link-primary">hubungi kami.</a>
  </p>
</div>

@endsection