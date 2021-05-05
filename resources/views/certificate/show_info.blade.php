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
                                <h4>Butiran Peserta</h4>
                            </div>
                            <div class="form-group row text-left px-4 pt-3">
                                <div class="col-md-6 pb-3">
                                  No. Kad Pengenalan/Passport:<br>
                                  <strong>{{$student->ic}}</strong>
                                  <input type="hidden" id="ic1" name="ic" class="form-control pb-2" value="{{ $student->ic }}" disabled>
                                </div>
                    
                                <div class="col-md-4 pb-3">
                                  Nama Pembeli:<br>
                                  <strong>{{$student->first_name }}</strong> <strong>{{$student->last_name}}</strong>
                                  <input type="hidden" id="first_Name1" name="first_name" class="form-control pb-2" value="{{ $student->first_name }}" disabled>
                                  <input type="hidden" id="last_Name1" name="last_name" class="form-control pb-2" value="{{ $student->last_name }}" disabled>
                                </div>
                    
                                <div class="col-md-6 pb-3">
                                  Emel:<br>
                                  <strong>{{$student->email }}</strong>
                                  <input type="hidden" id="email1" name="email" class="form-control pb-2" value="{{ $student->email }}" disabled>
                                </div>
                    
                                <div class="col-md-4 pb-3">
                                  No. Tel:<br>
                                  <strong>{{$student->phoneno}}</strong>
                                      <input type="hidden" id="phoneno1" name="phoneno" class="form-control pb-2" value="{{ $student->phoneno }}" disabled>
                                </div>
                                
                            </div>

                            <div class="table-responsive pb-4">
                                <table class="table table-borderless">
                                    <thead class="border-top border-bottom">
                                        <tr>
                                            <th>Sijil Program</th>
                                            <th>Harga</th>
                                            <th>Kuantiti</th>
                                            <th class="text-center">Jumlah Bayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>
                                                RM <input type="text" id="cert_price" name="price" value="999" style="border: none; width: 40px; outline: none;" readonly>
                                                
                                            </td>
                                            <td>
                                                <input type="text" id="qty" name="quantity" value="1" style="border: none; width: 40px; outline: none;" readonly>
                                            </td>
                                            <td class="text-center">
                                                RM <input type="text" class="text-center" id="totalpayment" name="totalpayment" value="" style="border: none; width: 40px; outline: none;" readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>  
                            
                            <div class="col-md-12 pb-5">
                                <div class="pull-left">
                                    <a href="{{ url('e-cert') }}/{{ $product->product_id }}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('payment') }}/{{ $product->product_id }}/{{ $student->stud_id }}" class="btn btn-circle btn-lg btn-dark"><i class="fas fa-arrow-right" style="padding-top:35%"></i></a>
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