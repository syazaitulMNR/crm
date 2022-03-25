@extends('layouts.temp')

@section('title')
Pengesahan Maklumat
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 pt-5 pb-3 text-center">
        <img src="/assets/images/logo.png" style="max-width:150px">
        <h1 class="display-5 text-dark px-3 pt-4">{{ $product->name }}</h1>
    </div>

    <div class="col-md-6 offset-md-3 pb-5">
        <form action="{{ url('simpan-maklumat') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $student->stud_id }}" method="GET" onsubmit="return checkForm(this);" >
            {{ csrf_field() }}
            <div class="card px-4 py-4 shadow">
                <div class="bg-dark text-white px-2 py-2">Pengesahan Maklumat</div>

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
                            <td class="text-break"><strong>{{$student->first_name }}</strong> <strong>{{$student->last_name}}</strong></td>
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

                <div class="btn-group btn-group-toggle align-center mb-3" data-toggle="buttons" >
                    <label class="btn btn-danger col-6">
                        <input type="radio" name="kehadiran" value="tidak hadir" autocomplete="off" checked> TIDAK HADIR
                    </label>
                    <label class="btn btn-success col-6">
                        <input type="radio" name="kehadiran" value="hadir" autocomplete="off"> HADIR
                    </label>
                </div>

                <div class="col-md-12">
                    <div class="pull-left">
                        <a href="{{ url('pengesahan-pendaftaran') }}/{{ $product->product_id }}/{{ $package->package_id }}"  class="btn btn-dark" ><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                    </div>
                    <div class="col-md-12">
                        <div class="pull-right">
                            {{-- <input type="submit" name="myButton" class="btn btn-dark" value="Simpan"/> --}}
                            <input type="submit" name="myButton" class="btn btn-dark" value="Hantar"/>
                        </div>
                    </div>
                    {{-- <div class="pull-right">
                        <a href="{{ url('simpan-maklumat') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $student->stud_id }}" method="POST" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-right" style="padding-top:35%"></i></a>
                    </div> --}}

                </div>
            </div>

        </form>
    </div>
</div>

<script>
    function checkForm(form) // Submit button clicked
    {
        form.myButton.disabled = true;
        form.myButton.value = "Wait...";
        return true;
    }
</script>   

@endsection