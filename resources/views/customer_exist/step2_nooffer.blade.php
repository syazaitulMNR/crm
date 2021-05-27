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

        <div class="col-xs-12 d-flex justify-content-center pb-5">
            <form action="{{ url('save2') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $student->stud_id }}" method="POST">
                @csrf
                <div class="card w-100 shadow">
                    <div class="card-header bg-dark text-white">Langkah 2/5: Maklumat Tiket</div>
  
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
                            <input type="hidden" value="{{ $payment_id ?? ''}}" class="form-control" name="payment_id" readonly/>
                            <input type="hidden" value="{{ $product->product_id }}" class="form-control" name="product_id" readonly/>
                            <input type="hidden" value="{{ $package->package_id }}" class="form-control" name="package_id" readonly/>
                            <input type="hidden" value="{{ $student->stud_id }}" class="form-control" name="stud_id" readonly/>
                            <input type="hidden" value="{{ $product->offer_id }}" class="form-control" name="offer_id" readonly/>

                            <div class="col-md-6 pb-2">
                                <label for="package">Pakej:</label>
                                <input type="text"  value="{{ $package->name }}" class="form-control" readonly/>
                            </div>
                            <div class="col-md-6 pb-2">
                                <label for="price">Harga:</label>
                                <input type="text" value="{{ $package->price }}" class="form-control" readonly/>
                                <input type="hidden" id="price" name="price" value="{{ $package->price }}" readonly>
                                <input type="hidden" name="pay_price" value="{{ $package->price }}" readonly>
                            </div>
                            <div class="col-md-6 pb-2">
                                <label for="quantity">Kuantiti:</label>
                                <select id="quantity" name="quantity" onchange="calculateAmount(this.value)" value="{{ $payment->quantity ?? '' }}" class="form-control" required>
                                    <option value="" disabled selected>-- Tiket --</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                            <div class="col-md-6 pb-2">
                                <label for="totalprice">Jumlah Harga (RM)</label><br>
                                <h3><input type="text" id="totalprice" name="totalprice" value="{{ $payment->totalprice ?? '' }}" style="border: none; outline-width: 0;" readonly></h3>
                            </div>
                        </div>
  
                    </div>
                    
                    <div class="card-footer">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a href="{{ url('langkah-pertama') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $student->stud_id }}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
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