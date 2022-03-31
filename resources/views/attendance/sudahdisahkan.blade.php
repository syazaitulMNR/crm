@extends('layouts.temp')

@section('title')
  Terima Kasih
@endsection

<head>
    <link rel='stylesheet' href='https://cdnjs.cloudfarecom/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
</head>

<style>
  body {
    background-color:rgb(233, 233, 233)!important ; 
  }

  /* .center-video {
    margin: auto;
    width: 50%;
    padding: 10px;
    text-align: center;
    } */

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
  <div class="col-md-12 px-3 py-4">
    <div class="text-center">
        <h3 class="display-4">Kehadiran anda pernah disahkan!</h3>
            <p class="lead pt-3">Pastikan anda menggunakan nombor pengenalan milik anda sendiri </p>
                <div class="py-3" style="font-size: 24px; color: red;">
                    <i class="fa fa-warning red-color fa-8x text-center"></i>
                </div>
                <hr>
            <p class="lead">
                Jika terdapat sebarang pertanyaan, sila <a href="http://bit.ly/journeymomentuminternet" class="link-primary">hubungi kami.</a>
            </p>
    </div>
  </div>
</div>
@endsection