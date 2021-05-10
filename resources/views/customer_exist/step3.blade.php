@extends('layouts.temp')

@section('title')
Pendaftaran Pembeli
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 py-5 text-center">
            <img src="/assets/images/logo.png" style="max-width:200px">
            <h1 class="display-4 text-dark px-4 pt-3">{{ $product->name }}</h1>
        </div>

        <div class="col-md-12 d-flex justify-content-center pb-5">
            <form action="{{ url('langkah-keempat') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $student->stud_id }}" method="get" >
                {{ csrf_field() }}
                <div class="card w-100 shadow">
                    <div class="card-header bg-dark text-white">Langkah 3: Pengesahan Pembelian</div>
   
                    <div class="card-body px-2">
  
                        <table class="table table-borderless">
                            <tr>
                                <td class="w-50">No. Kad Pengenalan / Passport</td>
                                <td>:</td>
                                <td><strong>{{$student->ic}}</strong></td>
                            </tr>
                            <tr>
                                <td class="w-50">Nama Pembeli</td>
                                <td>:</td>
                                <td class="text-break"><strong>{{$stud->first_name }}</strong> <strong>{{$stud->last_name}}</strong></td>
                            </tr>
                            <tr>
                                <td class="w-50">Emel</td>
                                <td>:</td>
                                <td class="text-break"><strong>{{$stud->email }}</strong></td>
                            </tr>
                            <tr>
                                <td class="w-50">No. Telefon</td>
                                <td>:</td>
                                <td><strong>{{$stud->phoneno}}</strong></td>
                            </tr>
                            <tr>
                                <td class="w-50">Pakej</td>
                                <td>:</td>
                                <td class="text-break"><strong>{{$package->name}}</strong></td>
                            </tr>
                            <tr>
                                <td class="w-50">Kuantiti Tiket</td>
                                <td>:</td>
                                {{-- If get 1 free 1 ticket --}}
                                {{-- <td><strong>{{$payment->quantity}} (Free 1 General)</strong></td> --}}
                                {{-- If bulk ticket --}}
                                <td><strong>{{$payment->quantity}}</strong></td>
                            </tr>
                            <tr>
                                <td class="w-50">Jumlah Bayaran</td>
                                <td>:</td>
                                <td><strong>RM {{$payment->totalprice}}</strong></td>
                            </tr>
                        </table>

                        <hr>
                        <div class="col-md-12">
                            <p class="fs-6 text-center">Sila pastikan maklumat telah diisi dengan betul</p>
                        </div>
                        <hr>
                    </div>

                    <div class="card-footer">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a href="{{ url('langkah-kedua') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $student->stud_id }}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                            </div>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-circle btn-lg btn-dark"><i class="fas fa-arrow-right py-1"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection