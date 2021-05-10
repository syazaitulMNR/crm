@extends('layouts.temp')

@section('title')
{{ $package->name }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 px-2 py-5 text-center">
        <img src="/assets/images/logo.png" style="max-width:200px">
        <h1 class="display-4 text-dark px-4 pt-3">{{ $product->name }}</h1>
    </div>
    
    <div class="col-md-12 d-flex justify-content-center">
        <div class="card w-75">
            <div class="px-3 py-3">No. Kad Pengenalan / Passport</div>
            <form action="{{ url('verification') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="get">
                @csrf
                <div class="col-md-12 pb-3">
                    <input type="text" class="form-control" name="ic" placeholder="tanpa '-' .Cth: 91042409**** / A********" maxlength="12" required="" >
                </div>
                {{-- <div class="col-md-12 pb-3">
                    <button type="submit" class="text-white btn btn-block" style="background-color: #202020">Seterusnya</button>
                </div> --}}
                <div class="col-md-12">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-circle btn-lg btn-dark"><i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
                <div class="pb-5"></div>
            </form>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-md-12 px-2 py-5 text-center">
        <img src="/assets/images/logo.png" style="max-width:150px">
        <h1 class="display-4 text-dark px-4 pt-3">{{ $product->name }}</h1>
    </div>

    <div class="col-md-12 py-3">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-6 pb-4 d-block mx-auto">
                    <div class="pricing-item bg-white py-4 px-4" style=" box-shadow: 0px 0px 30px -7px rgba(0,0,0,0.29); border-radius: 5px;">
                        
                        <div class="lead px-3 py-3">No. Kad Pengenalan / Passport</div>
                        <form action="{{ url('verification') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="get">
                            @csrf
                            <div class="col-md-12 pb-4">
                                <input type="text" class="form-control" name="ic" placeholder="tanpa '-' .Cth: 91042409**** / A********" maxlength="12" required="" >
                            </div>
                            <div class="col-md-12 pb-5">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-circle btn-lg btn-dark"><i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<footer class="text-center px-4 py-5">
    <b>Momentum Internet (1079998-A) © 2020 All Rights Reserved​</b>
</footer>

@endsection