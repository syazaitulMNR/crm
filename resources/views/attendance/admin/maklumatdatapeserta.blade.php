@extends('layouts.temp')

@section('title')
Pendaftaran Pembeli
@endsection

<style>

.center {
  font-family: arial;
  font-size: 24px;
  width: 350px;
  height: 200px;
  display: flex;
  justify-content: center;
}

</style>

@section('content')
<div class="row">
    <div class="col-md-12 px-2 py-5 text-center">
        <img src="/assets/images/logo.png" style="max-width:150px">
        <h1 class="display-5 text-dark px-3 pt-4">{{ $product->name }}</h1>
    </div>

    <div class="col-md-6 offset-md-3 pb-5">
        <form action="{{ url('store-free') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="get" >
            {{ csrf_field() }}
            <div class="card px-4 py-4 shadow">
                <div class="bg-dark text-white px-2 py-2">Maklumat Pembelian</div>
                    <div class="center mt-4 mb-4">
                        {!! QrCode::size(200)->generate('http://mims.momentuminternet.my/kehadiran-peserta/'. $product->product_id .'/'. $package->package_id .'/'. $ticket->ticket_id .'/'. $payment->payment_id .'/'. $student->ic) !!}
                    </div>    
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
                            <td class="text-break"><strong>{{$student->first_name}}</strong> <strong>{{$student->last_name}}</strong></td>
                        </tr>
                        <tr>
                            <td class="w-50">Emel</td>
                            <td>:</td>
                            <td class="text-break"><strong>{{$student->email }}</strong></td>
                        </tr>
                        <tr>
                            <td class="w-50">No. Telefon</td>
                            <td>:</td>
                            <td><strong>{{$student->phoneno}}</strong></td>
                        </tr>
                        <tr>
                            <td class="w-50">Pakej</td>
                            <td>:</td>
                            <td class="text-break"><strong>{{$package->name}}</strong></td>
                        </tr>
                        <tr>
                            <td class="w-50">Kuantiti Tiket</td>
                            <td>:</td>
                            <td><strong>{{$payment->quantity}}</strong></td>
                        </tr>
                        <tr>
                            <td class="w-50">Jumlah Bayaran</td>
                            <td>:</td>
                            <td><strong>{{ $payment->totalprice }}</strong></td>
                        </tr>
                    </table>
                    <hr>
                    <div class="container">
                        <div class='float-end'>
                            <button type='submit' class='btn btn-primary'> <i class="fas fa-save pr-1"></i> Sahkan Kehadiran</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection