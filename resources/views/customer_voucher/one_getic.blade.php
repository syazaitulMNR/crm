@extends('layouts.temp')

@section('title')
E-Voucher
@endsection

@section('content')
{{-- <div class="bg mx-0 px-0" style="background-image: url(../assets/images/tg_image_3019999803.jpeg); width: 100%; background-position: center;
background-repeat: no-repeat;" > --}}
        <div class="row">
            <div class="col-md-12 px-3 pt-5 pb-3 text-center">
                <img src="{{ asset('assets/images/logo.png') }}" style="max-width:150px">
                <h1 class="text-dark px-4 pt-3">{{ $voucher->name }}</h1>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="container">
                <div class="card-group shadow-lg">
                    <div class="card bg-dark text-white text-center">
                        <div class="card-body py-5">
                            <h5 class="px-3 py-3">Sila masukkan no. IC/passport</h5>
                            <form action="{{ url('voucher/check') }}/{{ $voucher->voucher_id }}" method="get">
                                @csrf
                                <div class="col-md-12 pb-4">
                                    <input type="text" class="form-control" name="ic" placeholder="tanpa '-' .Cth: 91042409**** / A********" maxlength="12" required>
                                </div>
                                <div class="col-md-12 pb-0">
                                    <button type="submit" class="btn btn-light btn-hover btn-lg">Tebus Sekarang</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body border-dark">
                            <h5 class="card-title text-center bg-dark text-white px-2 py-2">Terma & Syarat</h5>
                            <p style="text-align: justify;">{!! $voucher->tnc !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="lead text-center px-4 py-2">
            <b>Momentum Internet (1079998-A) © 2020 All Rights Reserved​</b>
        </footer>
    
    @endsection