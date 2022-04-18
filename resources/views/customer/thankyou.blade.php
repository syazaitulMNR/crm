@extends('layouts.temp')

@section('title')
  Terima Kasih
@endsection

<head>
  @foreach ($package as $key => $value)
    @if ($value->package_id == "PKD0082" || $value->package_id == "PKD0083" )
    <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbjohor/"> 
    @elseif ($value->package_id == "PKD0084" || $value->package_id == "PKD0085")
    <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbkl/"> 
    @elseif ($value->package_id == "PKD0086" || $value->package_id == "PKD0088")
    <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbsp/">
    @elseif ($value->package_id == "PKD0091" || $value->package_id == "PKD0092")
    <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbsa/">
    @elseif ($value->package_id == "PKD0093" || $value->package_id == "PKD0094")
    <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbkb/">
    @elseif ($value->package_id == "PKD0095" || $value->package_id == "PKD0096")
    <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbktn/">
    @elseif ($value->package_id == "PKD0097" || $value->package_id == "PKD0098")
    <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbsbh/">
    @elseif ($value->package_id == "PKD0099" || $value->package_id == "PKD00100")
    <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbmlk/">
    @elseif ($value->package_id == "PKD00101" || $value->package_id == "PKD00102")
    <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mbjb/">  
    @else 
    <meta http-equiv="refresh" content="2;url=http://www.momentumbisnes.com/oto-mb/">
    @endif  
  @endforeach
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
        <h3 class="display-4">Pendaftaran anda telah berjaya!</h3>
        <p class="lead pt-3">Anda <b>PERLU</b> mengemaskini nama peserta pada pautan yang diberikan di dalam emel yang telah didaftarkan.</p>
        {{-- <p class="lead">2) Sila tonton video ini sampai habis untuk dapatkan info penting untuk tindakan selanjutnya.</p> --}}
        <div class="py-3" style="font-size: 24px; color: green;">
          <i class="far fa-check-circle fa-8x text-center"></i>
        </div>
        
        {{-- <div class="mx-auto py-4"> --}}
          {{-- <div class="text-center mx-auto py-1">
            <iframe class="video-size" src="https://player.vimeo.com/video/556461041" height="315" width="560" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
          </div> --}}
        {{-- </div> --}}

        {{-- <a class="btn btn-primary" href="{{ $product_link }}" role="button">Go to zoom</a> --}}
 
        <hr>
        
        <p class="lead"> Emel akan diberikan dalam tempoh 48 Jam. Terima kasih kerana menunggu.
          {{-- <br><br><a class="btn btn-dark py-3 px-4" href="{{ url('updateform')}}/{{$product->product_id}}/{{$package->package_id}}/{{$student->stud_id}}/{{$payment->payment_id}}" role="button">Kemaskini</a> --}}
        </p>
        <p class="lead">
          Jika terdapat sebarang pertanyaan, sila <a href="http://bit.ly/journeymomentuminternet" class="link-primary">hubungi kami.</a>
        </p>

    </div>
  </div>
</div>
@endsection