@extends('layouts.temp')

@section('title')
Upgrade Pakej
@endsection

<style>
    /* Pricing Card */
    .pricing .mySubmit {
        border: none;   
        color: dark; 
        transition: all 0.2s;
        box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.5);
        border-radius: 1rem;
    }
    .pricing .btn {
        border-radius: 5rem;
        letter-spacing: .1rem;
        font-weight: bold;
        padding: 1rem;
        transition: all 0.2s;
    }
  
  </style>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 pt-5 pb-3 text-center">
            <img src="/assets/images/logo.png" style="max-width:200px">
            <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
            <h6>Hai! Sila buat pilihan di bawah untuk upgrade pakej.</h6>
        </div>

        <div class="col-md-12 pb-5">
            <form action="" method="POST">
                @csrf
  
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <img src="{{ asset('assets/images')}}/{{ $current_package->package_image }}" style="width:48%">
                        <h6 class="text-center">Pakej Semasa</h6>
                    </div>

                    <div class="col-md-6">
                        @foreach($package as $packages)
                        @if($current_package->price >= $packages->price)
                        @else
                            <div class="pricing">
                                <div class="mySubmit" style="width:48%">
                                    <input type="image" src="{{ asset('assets/images')}}/{{ $packages->package_image }}" name="submit" style="width:48%" alt="submit"/>
                                </div>
                            </div>
                            {{-- <img src="{{ asset('assets/images')}}/{{ $packages->package_image }}" style="width:48%"> --}}
                            {{-- <button type="submit" class="btn btn-dark">Pilih</button> --}}
                        @endif
                        @endforeach

                    </div>

                </div>
                    
            </form>
        </div>
    </div>
</div>
@endsection