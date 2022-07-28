@extends('layouts.temp')

@section('title')
Harap Maaf!
@endsection

<style>
  body {
    background-color:rgb(233, 233, 233)!important ; 
  }

</style>

@section('content')
<div class="row">
  <div class="col-md-12 px-3 pt-5 pb-3 text-center">
      <h1 class="display-1 fw-bolder px-4 py-3">Harap Maaf!</h1>
      <h2>Rekod anda tiada dalam sistem kami.</h2>
      <i class="far fa-times-circle fa-9x pt-5 pb-5" style="color: red;"></i>

      <hr>
            
      <p class="lead">Jika terdapat sebarang pertanyaan, sila <a href="http://bit.ly/journeymomentuminternet">hubungi kami.</a></p>
  </div>
</div>
@endsection