@extends('layouts.temp')

@section('title')
Upgrade Pakej
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 pt-5 pb-3 text-center border-bottom">
            <img src="/assets/images/logo.png" style="max-width:150px">
            <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
        </div>

        <div class="col-md-12 py-3">
            <form action="" method="POST">
                @csrf
  
                {{-- <div class="w-50 px-3 py-3 pt-md-4 pb-md-4 mx-auto text-center">
                    <h1 class="font-weight-bold">{{ $product->name }}</h1>
                    <p class="lead">Hai! Sila buat pilihan di bawah untuk upgrade pakej.</p>
                </div> --}}
                <div class="container text-center">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-10 pb-4 d-block mx-auto">
                            <div class="pricing-item bg-white py-4" style=" box-shadow: 0px 0px 30px -7px rgba(0,0,0,0.29); border-radius: 5px;">
                                <div class="pb-2" style="letter-spacing: 2px">
                                    <h4>{{ $current_package->name }}</h4>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12 px-5">
                                        <button type="submit" class="button button4" name="pay_method" value="{{ $stripe ?? '' }}">
                                            <i class="far fa-credit-card fa-3x"></i>
                                            <br>Kad Debit/Kredit
                                        </button>
                                    
                                        <button type="submit" class="button button4" name="pay_method" value="{{ $billplz ?? '' }}">
                                            <i class="fas fa-university fa-3x"></i>
                                            <br>FPX
                                        </button>
                                    </div>
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
</div>
@endsection