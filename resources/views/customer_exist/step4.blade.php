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
    <div class="col-md-12 pt-5 pb-3 text-center">
        <img src="/assets/images/logo.png" style="max-width:150px">
        <h1 class="display-5 text-dark px-3 pt-4">{{ $product->name }}</h1>
    </div>

    <div class="col-md-6 offset-md-3 pb-5">
        <form action="{{ url('save4') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $student->stud_id }}" method="POST">
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

                    <div class="alert alert-warning" role="alert">
                        <small>* Pastikan pembayaran anda telah berjaya dengan menekan butang 'Merchant Page' dan memasuki ke Group Telegram kami. Terima Kasih</small>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12 text-center">
                            {{-- <button type="submit" class="button button4" name="pay_method" value="{{ $card ?? '' }}">
                                <i class="far fa-credit-card fa-3x"></i>
                                <br><br>Kad Debit/Kredit
                            </button> --}}
                        
                            <button type="submit" class="button button4" name="pay_method" value="{{ $billplz ?? '' }}">
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
                                <div class="modal-body float-right">
                                    <ul class="px-4">
                                        <li class="text-justify py-2">Pastikan anda telah selesai melakukan pembayaran secara <b>Online</b> atau di <b>Mesin CDM</b> sebelum meneruskan proses naik taraf pakej.</li>

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
                        <a href="{{ url('langkah-ketiga') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $student->stud_id }}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection