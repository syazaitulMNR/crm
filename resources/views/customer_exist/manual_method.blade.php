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
        <form action="{{ url('save-manual') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $student->stud_id }}" method="post" enctype="multipart/form-data" >
            {{ csrf_field() }}
            <div class="card px-4 py-4 shadow">
                <div class="bg-dark text-white px-2 py-2">Langkah 5/5: Pembayaran Tiket</div>
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger mt-2">
                        <small><strong>{{ $message }}</strong></small>
                    </div>
                @endif

                <div class="card-body px-2">
                    <div class="row">
                        <div class="col-md-6" style="border-right: 1px solid #C0C0C0;">
                            <h5 class="mb-3">Maklumat Pelanggan</h5>
                            <table class="table table-borderless" style="font-size: 9pt;">
                                <tr>
                                    <td class="w-20">No. Kad Pengenalan / Passport</td>
                                    <td>:</td>
                                    <td><strong>{{$student->ic}}</strong></td>
                                </tr>
                                <tr>
                                    <td class="w-20">Nama Pembeli</td>
                                    <td>:</td>
                                    <td class="text-break"><strong>{{$student->first_name}}</strong> <strong>{{$student->last_name}}</strong></td>
                                </tr>
                                <tr>
                                    <td class="w-20">Emel</td>
                                    <td>:</td>
                                    <td class="text-break"><strong>{{$student->email }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="w-20">No. Telefon</td>
                                    <td>:</td>
                                    <td><strong>{{$student->phoneno}}</strong></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5 class="mb-3">Maklumat Tiket</h5>
                            <table class="table table-borderless" style="font-size: 9pt;">
                                <tr>
                                    <td class="w-20">Pakej (Kuantiti)</td>
                                    <td>:</td>
                                    <td><strong>{{$package->name}} ( 
                                        {{-- If get 1 free 1 ticket --}}
                                        {{-- {{$payment->quantity}} (Free 1 General) --}}
                                        {{-- If bulk ticket --}}
                                        {{$payment->quantity}}
                                    )
                                    </strong></td>
                                </tr>
                                <tr>
                                    <td class="w-20">Jumlah Bayaran</td>
                                    <td>:</td>
                                    <td><strong>RM {{$payment->totalprice}}</strong></td>
                                </tr>
                                <tr>
                                    <td class="w-20">Nama Team Momentum</td>
                                    <td>:</td>
                                    <td><input type="text" name="pic" id="pic" class="form-control form-control-sm" placeholder="Nama team yang berurusan" required> </td>
                                </tr>
                                <tr>
                                    <td class="w-20">Tarikh/Masa Pembayaran</td>
                                    <td>:</td>
                                    <td><input type="datetime-local" name="pay_datetime" id="pay_datetime" class="form-control form-control-sm" required></td>
                                </tr>
                                <tr>
                                    <td class="w-20">Bukti Pembayaran</td>
                                    <td>:</td>
                                    <td><input type="file" class="form-control form-control-sm" name="receipt_path" id="receipt_path"></td>
                                </tr>
                            </table>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-sm float-end" >Simpan</button>
                            </div>
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
                        <a href="{{ url('langkah-keempat') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $student->stud_id }}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                    </div>
                </div>
                
            </div>
        </form>
    </div>
</div>
@endsection