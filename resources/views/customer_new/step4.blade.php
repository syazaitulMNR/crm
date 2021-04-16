@extends('layouts.temp')

@section('title')
Pendaftaran Pembeli
@endsection

{{-- Custom button css ----------------------------}}
<style>
    .button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 32px 16px;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 5px;
    transition-duration: 0.4s;
    cursor: pointer;
    }
    .button4 {
    background-color: #f3f3f3;
    color: #202020;
    border: 1px #e7e7e7 solid;
    width: 250px;
    }

    .button4:hover {background-color: #e7e7e7;}
</style>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 py-5 text-center">
            <img src="/assets/images/logo.png" style="max-width:200px">
            <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
        </div>

        <div class="col-md-12 d-flex justify-content-center pb-5">
            <form action="{{ url('store4') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="POST">
                @csrf
                <div class="card w-100">
                    <div class="card-header bg-dark text-white">Langkah 4: Pilih Jenis Pembayaran</div>
  
                    <div class="card-body">
  
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="px-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
  
                            <div class="form-group row">
                                <div class="col-md-12 px-5">
                                    <button type="submit" class="button button4" name="pay_method" value="{{ $card ?? '' }}">
                                        <i class="far fa-credit-card fa-3x"></i>
                                        <br>Kad Debit/Kredit
                                    </button>
                                
                                    <button type="submit" class="button button4" name="pay_method" value="{{ $fpx ?? '' }}">
                                        <i class="fas fa-university fa-3x"></i>
                                        <br>FPX
                                    </button>
                                </div>
                            </div>
{{-- 
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="pay_method" value="card" id="btnradio1" autocomplete="off" checked>
                                <label class="btn btn-outline-primary" for="btnradio1">Card</label>
                              
                                <input type="radio" class="btn-check" name="pay_method" value="fpx" id="btnradio2" autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnradio2">fpx</label>
                            </div> --}}
  
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a href="{{ url('pengesahan-pembelian') }}/{{ $product->product_id }}/{{ $package->package_id }}" class="btn btn-danger pull-right">Kembali</a>
                            </div>
                            {{-- <div class="pull-right">
                                <button type="submit" class="btn btn-primary">Next</button>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection