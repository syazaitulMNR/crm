@extends('layouts.temp')

@section('title')
  Terima Kasih
@endsection
<head>
  <meta http-equiv="refresh" content="3;url=https://www.momentumbisnes.com/buku-8video/"> 
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
  <div class="col-md-12 px-3 pt-5 pb-3 text-center">
      <h1 class="display-3 px-4 pt-3">Harap Maaf!</h1>
      <h4 class="pb-5">Penebusan baucer telah tamat.</h4>

      <hr style="padding: 2pt; margin: 0 20pt;">

      <h3 class="display-4 fw-bolder pt-5 pb-2" style="color: rgb(254, 147, 7);">Sila Tunggu Sebentar!!</h3>
      <h5 class="pb-5">Kami akan berikan anda tawaran yang menarik untuk anda</h5>
      
      <hr style="padding: 2pt; margin: 0 20pt;">

      <p class="lead pt-5">Jika terdapat sebarang pertanyaan, sila <a href="http://bit.ly/journeymomentuminternet">hubungi kami.</a></p>
  </div>
</div>

<script>
setRedirectTime(function () 
{
   window.location.href= 'www.google.com'; // the redirect URL will be here

},3000); 
</script>  

@endsection