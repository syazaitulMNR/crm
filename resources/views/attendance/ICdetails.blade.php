@extends('layouts.temp')

@section('title')
{{ $package->name }}
@endsection

@section('content')
<div class="row pt-4">
    <div class="col-md-12 px-2 py-5 text-center">
        <img src="/assets/images/logo.png" style="max-width:150px">
        <h1 class="display-5 text-dark px-3 pt-4">Pengesahan Pendaftaran <br>{{ $product->name }}</h1>
    </div>
    
    <div class="col-md-6 offset-md-3">
        <div class="card px-4 py-4 shadow">
            <p>No. Kad Pengenalan / Passport</p>
            <form action="{{ url('validation') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="get">
                @csrf
                <div class="col-md-12 pb-3">
                    <input type="text" class="form-control" name="ic" placeholder="tanpa '-' .Cth: 91042409**** / A********" maxlength="12" required="" >
                </div>
                <p style=" color:red;">
                    * Jika anda bukan warganegara Malaysia sila masukkan passport anda.
                </p>
                <div class="col-md-12 pb-3">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-circle btn-lg btn-dark"><i class="fas fa-arrow-right py-1"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-12 text-center pt-3">
        <a href="https://momentuminternet.com/privacy-policy/">Privacy & Policy</a>
    </div>
</div>

<footer class="text-center px-4 py-5">
    <b>Momentum Internet (1079998-A) © {{ date('Y') }} All Rights Reserved​</b>
</footer>

@endsection