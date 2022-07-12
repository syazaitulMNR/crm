@extends('layouts.temp')

@section('title')
{{ $package->name }}
@endsection

@section('content')
<div class="row pt-4">
    <div class="col-md-12 px-2 py-5 text-center">
        <img src="/assets/images/logo.png" style="max-width:150px">
        <h1 class="display-5 text-dark px-3 pt-4">{{ $product->name }}</h1>
    </div>
    
    @if($package->package_id == 'PKD00137') {{-- Package code for ARB Alumni MMB OGOS 2022 --}}
        <div class="col-md-6 offset-md-3">
            <div class="card px-4 py-4 shadow">
                <h3 class="text-dark px-3 pb-3 text-center">{{ $package->name }}</h3>
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>{{ session('error') }}</strong></div>	
                @endif
                <p>No. Kad Pengenalan / Passport</p>
                <form action="{{ url('verification/ARBAlumni') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="get">
                    @csrf
                    <div class="col-md-12 pb-3">
                        <input type="text" class="form-control" name="ic" placeholder="tanpa '-' .Cth: 91042409**** / A********" maxlength="12" required="" >
                    </div>
                    <div class="col-md-12 pb-3">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-circle btn-lg btn-dark"><i class="fas fa-arrow-right py-1"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="col-md-6 offset-md-3">
            <div class="card px-4 py-4 shadow">
                <p>No. Kad Pengenalan / Passport</p>
                <form action="{{ url('verification') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="get">
                    @csrf
                    <div class="col-md-12 pb-3">
                        <input type="text" class="form-control" name="ic" placeholder="tanpa '-' .Cth: 91042409**** / A********" maxlength="12" required="" >
                    </div>
                    <div class="col-md-12 pb-3">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-circle btn-lg btn-dark"><i class="fas fa-arrow-right py-1"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="col-md-12 text-center pt-3">
        <a href="https://momentuminternet.com/privacy-policy/">Privacy & Policy</a>
    </div>
</div>

<footer class="text-center px-4 py-5">
    <b>Momentum Internet (1079998-A) © {{ date('Y') }} All Rights Reserved​</b>
</footer>

@endsection