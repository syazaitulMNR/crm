@extends('layouts.temp')

@section('title')
Pendaftaran Pembeli
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 px-2 py-5 text-center">
        <img src="/assets/images/logo.png" style="max-width:150px">
        <h1 class="display-5 text-dark px-3 pt-4">{{ $product->name }}</h1>
    </div>

    <div class="col-md-8 offset-md-2 pb-5">
        <div class="card px-4 py-4 shadow">
            <div class="bg-dark text-white px-2 py-2">Bukti Pembayaran Upgrade Tiket</div>
            @if ($message = Session::get('error'))
                <div class="alert alert-danger mt-2">
                    <small><strong>{{ $message }}</strong></small>
                </div>
            @endif

            <div class="card-body px-2">
                <div class="row">

                    <div class="col-md-6" style="border-right: 1px solid #C0C0C0;">
                        <h5 class="mb-3">Maklumat Pelanggan</h5>
                        <dl class="row" style="font-size: 9pt">

                            <dd class="col-4">No. Kad Pengenalan / Passport</dd>
                            <dd class="col-1">:</dd>
                            <dt class="col-7">{{$student->ic}}</dt>

                            <dd class="col-4">Nama Pembeli</dd>
                            <dd class="col-1">:</dd>
                            <dt class="col-7">{{$student->first_name}}&nbsp;{{$student->last_name}}</dt>

                            <dd class="col-4">Emel</dd>
                            <dd class="col-1">:</dd>
                            <dt class="col-7">{{$student->email }}</dt>

                            <dd class="col-4">No. Telefon</dd>
                            <dd class="col-1">:</dd>
                            <dt class="col-7">{{$student->phoneno}}</dt>

                        </dl>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3">Maklumat Tiket<button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#infoModal"><i class="bi bi-info-circle" style="color: red" ></i></button></h5>
                        <form action="{{ url('store-manual') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $ticket->ticket_id}}" method="post" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                            @foreach ($packagename as $packages)
                                @if ($new_package->package_id == $packages->package_id)
                                    <dl class="row" style="font-size: 9pt">
                                        <dd class="col-4">Pakej</dd>
                                        <dd class="col-1">:</dd>
                                        <dt class="col-7">{{$packages->name}}</dt>

                                        <dd class="col-4">Jumlah Bayaran Tambahan</dd>
                                        <dd class="col-1">:</dd>
                                        <dt class="col-7">RM {{$new_package->pay_price}}</dt>

                                        <dd class="col-4">Nama Team Momentum</dd>
                                        <dd class="col-1">:</dd>
                                        <dt class="col-7"><input type="text" name="pic" id="pic" class="form-control form-control-sm" placeholder="Nama team yang berurusan" style="font-size: 9pt" required></dt>

                                        <dd class="col-4">Tarikh / Masa Pembayaran</dd>
                                        <dd class="col-1">:</dd>
                                        <dt class="col-7"><input type="datetime-local" name="pay_datetime" id="pay_datetime" max="{{ $tomorrow }}" class="form-control form-control-sm" style="font-size: 9pt" required></dt>

                                        <dd class="col-4">Bukti Pembayaran</dd>
                                        <dd class="col-1">:</dd>
                                        <dt class="col-7"><input type="file" class="form-control form-control-sm" name="receipt_path" id="receipt_path" style="font-size: 9pt" required></dt>
                                    </dl>
                                @endif  
                            @endforeach

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-sm float-end" >Simpan</button>
                            </div>
                        </form>
                    </div>
                    
                </div>

                <hr>
                <div class="col-md-12">
                    <p class="fs-6 text-center">Sila pastikan maklumat telah diisi dengan betul</p>
                </div>
                <hr>
            </div>

            <div class="col-md-12">
                <div class="pull-left">
                    <a href="{{ url('upgrade-payment') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $ticket->ticket_id}}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                </div>
            </div>

            <!-- Participant Modal Triggered -->
            <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="participantModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Contoh Bukti Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <img src="{{ asset('assets/images/eg_resit_ic.jpg') }}" style="max-width:270px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection