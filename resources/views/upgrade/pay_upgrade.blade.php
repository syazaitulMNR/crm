@extends('layouts.temp')

@section('title')
Pendaftaran Pembeli
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 py-5 text-center">
            <img src="/assets/images/logo.png" style="max-width:200px">
            <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
        </div>

        <div class="col-md-12 d-flex justify-content-center pb-5">
            <form action="" method="POST">
                @csrf
                <div class="pricing-item bg-white py-4" style=" box-shadow: 0px 0px 30px -7px rgba(0,0,0,0.29); border-radius: 5px;">  
                      
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
                            {{-- <input type="hidden" value="{{ $payment_id ?? ''}}" class="form-control" name="payment_id" readonly/> --}}
                            <input type="hidden" value="{{ $product->product_id }}" class="form-control" name="product_id" readonly/>
                            <input type="hidden" value="{{ $current_package->package_id }}" class="form-control" name="package_id" readonly/>
                            <input type="hidden" value="{{ $student->stud_id }}" class="form-control" name="stud_id" readonly/>

                            <div class="col-md-6 pb-2">
                                <label for="package">Pakej:</label>
                                <input type="text"  value="{{ $current_package->name }}" class="form-control" readonly/>
                            </div>
                            {{-- <div class="col-md-6 pb-2">
                                <label for="price">Harga:</label>
                                <input type="text" value="{{ $current_package->price }}" class="form-control" readonly/>
                                <input type="hidden" id="price" name="price" value="{{ $current_package->price }}" disabled>
                            </div> --}}
                            
                            <div class="col-md-12 pb-2">
                                <label for="totalprice">Jumlah Harga (RM)</label><br>
                                <h3><input type="text" id="totalprice" name="totalprice" value="" style="border: none; outline-width: 0;" readonly></h3>
                            </div>
                        </div>
  
                    
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a href="" class="btn btn-danger">Kembali</a>
                            </div>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-dark">Seterusnya</button>
                            </div>
                        </div>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection