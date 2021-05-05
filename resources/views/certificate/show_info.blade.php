@extends('layouts.temp')

@section('title')
Upgrade Pakej
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
    font-size: 14px;
    margin: 4px 5px;
    transition-duration: 0.4s;
    cursor: pointer;
    }
    .button4 {
    background-color: #f3f3f3;
    color: #202020;
    border: 1px #e7e7e7 solid;
    width: 150px;
    }

    .button4:hover {background-color: #e7e7e7;}
</style>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 pt-5 pb-3 text-center">
            <img src="/assets/images/logo.png" style="max-width:150px">
            <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
        </div>

        <div class="col-md-12 py-3">
            <div class="container text-center">
                <div class="row">
                    <div class="col-auto pb-4 d-block mx-auto">
                        <div class="pricing-item bg-white py-4 px-4" style=" box-shadow: 0px 0px 30px -7px rgba(0,0,0,0.29); border-radius: 5px;">
                            <div class="border-bottom pb-1" style="letter-spacing: 2px">
                                <h4>Butiran Sijil</h4>
                            </div>
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
                            </table>

                            
                            <div class="col-md-12 pb-5">
                                <div class="pull-left">
                                    <a href="{{ url('e-cert') }}/{{ $product->product_id }}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('get-cert') }}/{{ $product->product_id }}/{{ $student->stud_id }}" class="btn btn-circle btn-lg btn-success"><i class="fas fa-check py-1" style="padding-top:15%"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var a = document.getElementById("qty").value;
    var b = document.getElementById("cert_price").value;
    var c = b * a;

    /*display the result*/
    var jumlah = document.getElementById('totalpayment');
    jumlah.value = c;

    console.log(c);
</script>

@endsection