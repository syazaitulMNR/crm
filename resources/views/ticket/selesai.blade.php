@extends('layouts.temp')

@section('title')
  Terima Kasih
@endsection
<head>
  @if ($package->package_id == "PKD0082" || $package->package_id == "PKD0083")
  <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbjohor/"> 
  @elseif ($package->package_id == "PKD0084" || $package->package_id == "PKD0085")
  <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbkl/"> 
  @elseif ($package->package_id == "PKD0086" || $package->package_id == "PKD0088")
  <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbsp/">
  @elseif ($package->package_id == "PKD0091" || $package->package_id == "PKD0092")
  <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbsa/">
  @elseif ($package->package_id == "PKD0093" || $package->package_id == "PKD0094")
  <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbkb/">
  @elseif ($package->package_id == "PKD0095" || $package->package_id == "PKD0096")
  <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbktn/">
  @elseif ($package->package_id == "PKD0097" || $package->package_id == "PKD0098")
  <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbsbh/">
  @elseif ($package->package_id == "PKD0099" || $package->package_id == "PKD00100")
  <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbmlk/">
  @elseif ($package->package_id == "PKD00101" || $package->package_id == "PKD00102")
  <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbjb/">
  @else 
  <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mb/"> 
  @endif  
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
      <h3 class="display-4">Anda Sudah Mendaftar ke Pakej {{ $package->name }} sebelum ini</h3>
      <h5>Kami akan berikan anda tawaran yang menarik untuk anda</h5>
        {{-- <p class="lead pt-3">Anda <b>PERLU</b> mengemaskini nama peserta pada pautan yang diberikan di dalam emel yang telah didaftarkan.</p> --}}
        {{-- <p class="lead">2) Sila tonton video ini sampai habis untuk dapatkan info penting untuk tindakan selanjutnya.</p> --}}
        <div class="py-3" style="font-size: 24px; color: green;">
          <i class="far fa-check-circle fa-8x text-center"></i>
        </div>
        {{-- <a class="btn btn-primary" href="{{ $product_link }}" role="button">Zoom Link</a> --}}
        
        {{-- <div class="mx-auto py-4"> --}}
          {{-- <div class="text-center mx-auto py-1">
            <iframe class="video-size" src="https://player.vimeo.com/video/556461041" height="315" width="560" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
          </div> --}}
        {{-- </div> --}}
 
        <hr>
        
        {{-- <p class="lead"> Emel akan diberikan dalam tempoh 48 Jam. Terima kasih kerana menunggu.</p> --}}
        <p class="lead">
          Jika terdapat sebarang pertanyaan, sila <a href="http://bit.ly/journeymomentuminternet" class="link-primary">hubungi kami.</a>
        </p>

    </div>
  </div>
</div>

<script>
setRedirectTime(function () 
{
   window.location.href= 'www.google.com'; // the redirect URL will be here

},3000); 
</script>  

@endsection