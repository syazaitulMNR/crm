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
    /* margin: 4px 5px; */
    transition-duration: 0.4s;
    cursor: pointer;
    }
    .button4 {
    background-color: #f3f3f3;
    color: #202020;
    border: 1px #e7e7e7 solid;
    width: 180px;
    }

    .button4:hover {background-color: #e7e7e7;}
</style>

@section('content')
<div class="row">
    <div class="col-md-12 px-2 py-5 text-center">
        <img src="/assets/images/logo.png" style="max-width:150px">
        <h1 class="display-5 text-dark px-3 pt-4">{{ $product->name }}</h1>
    </div>

    <div class="col-md-6 offset-md-3 pb-5">
        <form action="{{ url('store4') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="POST">
            @csrf
            <div class="card px-4 py-4 shadow">
                <div class="bg-dark text-white px-2 py-2">Langkah 4/5: Pilih Jenis Pembayaran</div>

                <div class="card-body">

                    
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block text-center">	
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="px-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="alert alert-warning text-center" role="alert">
                        <small >* Pastikan pembayaran secara <b>Billplz</b> anda telah berjaya dengan menekan butang '<b>Merchant Page</b>' dan memasuki ke <b>Group Telegram</b> kami.<center>Terima Kasih</center></small>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12 text-center">

                            {{-- <button type="submit" class="button button4 mb-3" name="pay_method" value="{{ $card ?? '' }}">
                                <i class="far fa-credit-card fa-3x"></i>
                                <br><br>Kad Debit/Kredit
                            </button> --}}
                        
                            <button type="submit" class="button button4 mb-3" name="pay_method" value="{{ $fpx ?? '' }}">
                                <i class="fas fa-university fa-3x"></i>
                                <br><br>Billplz
                            </button>

                            <button type="button" class="button button4" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <!-- <button type="submit" class="button button4" name="pay_method" value="{{ $manual ?? '' }}"> -->
                            <!-- <img src="{{ asset('assets/images/invoice.jpg') }}"> -->
                            <i class="fas fa-file-invoice-dollar fa-3x"></i>
                                <br><br>Resit Manual
                            </button>

                        </div>
                    </div>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">PERINGATAN</h5>
                                </div>
                                <div class="modal-body">
                                    <ul class="px-4">
                                        <li class="text-justify py-2">Untuk pembayaran secara <b>Online</b> atau di <b>Mesin CDM/ATM</b> boleh transfer ke bank akaun:</li>

                                        <div class="card border-danger bg-light">
                                            <div class="card-body mx-auto">
                                                <table class="col-12" style="font-size: 0.8rem; font-weight: bold;">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-end align-text-top">Bank </td>
                                                            <td class="align-text-top"> : </td>
                                                            <td class="align-text-top"> MAYBANK</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-end align-text-top">No. Akaun </td>
                                                            <td class="align-text-top"> : </td>
                                                            <td class="align-text-top"> 5510 6130 6335</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-end align-text-top">Akaun </td>
                                                            <td class="align-text-top"> : </td>
                                                            <td class="align-text-top"> MOMENTUM INTERNET SDN BHD</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                        <small style="color: red"> *Pastikan anda tulis <b>No IC</b> pada <b>reference</b> atau <b>rujukan</b> di dalam resit anda</small>

                                        <li class="text-justify py-2">Pastikan anda telah selesai melakukan pembayaran dan mendapatkan bukti resit sebelum meneruskan proses pendaftaran pakej.</li>

                                        <li class="text-justify py-2">Contoh bukti resit pembayaran:</li>
                                        
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/eg_resit_ic.jpg') }}" style="max-width:250px">
                                        </div>

                                        <li class="text-justify py-2">Pastikan anda muat naik resit pembayaran yang sah. Kegagalan memuat naik resit pembayaran yang sah akan dikira sebagai batal.</li>

                                        <p class="text-center">Terima kasih</p>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-dark" name="pay_method" value="{{ $manual ?? '' }}">Setuju</button>
                                </div>
                            </div>
                        </div>
                    </div>    

                </div>
                <div class="col-md-12">
                    <div class="pull-left">
                        <a href="{{ url('pengesahan-pembelian') }}/{{ $product->product_id }}/{{ $package->package_id }}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection