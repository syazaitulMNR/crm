@extends('layouts.temp')

@section('title')
Upgrade Pakej
@endsection

<style>
    .myButton{
        cursor:pointer;
        border:none;
        width:100px;
        height:100px;
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
  
                {{-- <div class="row justify-content-center">
                    <div class="col-md-6 text-right">
                        <img src="{{ asset('assets/images')}}/{{ $current_package->package_image }}" style="width:48%">
                        <h6 class="text-center">Pakej Semasa</h6>
                    </div>

                    <div class="col-md-6">
                        @foreach($package as $packages)
                        @if($current_package->price >= $packages->price)
                        @else
                            <div class="col-md-6">
                                <img src="{{ asset('assets/images')}}/{{ $packages->package_image }}" style="width:48%">
                                <button class="btn btn-dark">Pilih</button>
                            </div>
                            
                        @endif
                        @endforeach
                    </div>

                </div> --}}

                {{-- <div class="w-50 px-3 py-3 pt-md-4 pb-md-4 mx-auto text-center">
                    <h1 class="font-weight-bold">{{ $product->name }}</h1>
                    <p class="lead">Hai! Sila buat pilihan di bawah untuk upgrade pakej.</p>
                </div> --}}
                <div class="container text-center">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-10 pb-4 d-block m-auto">
                            <div class="pricing-item" style=" box-shadow: 0px 0px 30px -7px rgba(0,0,0,0.29);">
                                <img src="{{ asset('assets/images')}}/{{ $current_package->package_image }}" style="width:48%">
                                <div class="pricing-price pb-1 text-primary color-primary-text mb-3">
                                    <h1 style="font-weight: 1000; font-size: 3.5em;">
                                        <span style="font-size: 20px;">€</span>50
                                    </h1>
                                </div>
                                <div class="pricing-button pb-4">
                                    <button type="button" class="btn btn-lg btn-outline-primary w-75" disabled>Pakej Semasa</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 d-none d-lg-block">
                            <div class="vl"></div>
                        </div>
                        @foreach($package as $packages)
                        @if($current_package->price >= $packages->price)
                        @else
                        <div class="col-lg-4 col-md-6 col-sm-10 pb-4 d-block m-auto">
                            <div class="pricing-item">
                                <img src="{{ asset('assets/images')}}/{{ $packages->package_image }}" style="width:48%">
                                <div class="pricing-price pb-1 text-primary color-primary-text mb-3">
                                    <h1 style="font-weight: 1000; font-size: 3.5em;">
                                        <span style="font-size: 20px;">€</span>25
                                    </h1>
                                </div>
                                <div class="pricing-button pb-4">
                                    <button type="button" class="btn btn-lg btn-primary w-75">Get started</button>
                                </div>
                            </div>
                        </div>
                        
                        @endif
                        @endforeach
                        {{-- <div class="col-lg-4 col-md-6 col-sm-10 pb-4 d-block m-auto">
                            <div class="pricing-item">
                                <div class="pt-4 pb-2" style="letter-spacing: 2px">
                                    <h4>Professional</h4>
                                </div>
                                <div class="text-primary" style="font-size: 75px">
                                    <i class="fa fa-check-circle"></i>
                                </div>
                                <div class="pricing-description">
                                    <ul class="list-unstyled mt-3 mb-1">
                                        <li>30 users included</li>
                                        <li>15 GB of storage</li>
                                        <li>Phone and email support</li>
                                        <li>Help center access</li>
                                    </ul>
                                </div>
                                <div class="pricing-price pb-1 text-primary color-primary-text mb-3">
                                    <h1 style="font-weight: 1000; font-size: 3.5em;">
                                        <span style="font-size: 20px;">€</span>125
                                    </h1>
                                </div>
                                <div class="pricing-button pb-4">
                                    <button type="button" class="btn btn-lg btn-primary w-75">Get started</button>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                
                    
            </form>
        </div>
    </div>
</div>
@endsection