@extends('layouts.temp')

@section('title')
Upgrade Pakej
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 py-5 text-center">
            <img src="/assets/images/logo.png" style="max-width:200px">
            <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
            <h6>Hai! Sila buat pilihan di bawah untuk upgrade pakej.</h6>
        </div>

        <div class="col-md-12 d-flex justify-content-center pb-5">
            <form action="" method="POST">
                @csrf
  
                @foreach($package as $packages)
                <img src="{{ asset('assets/images')}}/{{ $packages->package_image }}" style="width: 30%">
                    
                @endforeach
            </form>
        </div>
    </div>
</div>
@endsection