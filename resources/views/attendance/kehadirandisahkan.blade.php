@extends('layouts.temp')

@section('title')
  Terima Kasih
@endsection

<head>

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
        <h3 class="display-4">Kehadiran anda telah disahkan!</h3>
            <p class="lead pt-3">Selamat datang ke program anjuran <strong>Momentum Internet Sdn Bhd</strong></p>
                <div class="py-3" style="font-size: 24px; color: green;">
                    <i class="far fa-check-circle fa-8x text-center"></i>
                </div>
                <hr>
        
                <p class="lead"> Emel akan diberikan dalam tempoh 48 Jam. Terima kasih kerana menunggu.
                </p>
            <p class="lead">
                Jika terdapat sebarang pertanyaan, sila <a href="http://bit.ly/journeymomentuminternet" class="link-primary">hubungi kami.</a>
            </p>
    </div>
  </div>
</div>
@endsection