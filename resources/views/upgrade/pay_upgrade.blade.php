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
        <div class="col-md-12 px-3 pt-5 pb-3 text-center border-bottom">
            <img src="/assets/images/logo.png" style="max-width:150px">
            <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
        </div>
        <form action="" method="POST">
            @csrf

            <div class="container text-center">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-10 pb-4 d-block mx-auto">
                        <div class="pricing-item bg-white py-4" style=" box-shadow: 0px 0px 30px -7px rgba(0,0,0,0.29); border-radius: 5px;">
                            <div class="pb-2" style="letter-spacing: 2px">
                                <h4>{{ $current_package->name }}</h4>
                            </div>
                            <div class="text-success" style="font-size: 75px">
                                <i class="fa fa-check-circle"></i>
                            </div>
                            <div class="pricing-description">
                                <ul class="list-unstyled mt-3 mb-1 py-2 px-1">
                                    @foreach($feature as $features)
                                    @if($current_package->package_id == $features->package_id)
                                        <li class="text-break">{{ $features->name }}</li>
                                        <hr class="my-1 mx-3">
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="pricing-price pb-1 text-dark color-dark-text mb-3">
                                <h1 style="font-weight: 1000; font-size: 3.5em;">
                                    <span style="font-size: 20px;">RM</span>{{ $current_package->price }}
                                </h1>
                            </div>
                            <div class="pricing-button pt-1 pb-1">
                                <button type="button" class="btn btn-lg btn-outline-dark w-75" disabled>Pakej Semasa</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
                
        </form>
    </div>
</div>
@endsection