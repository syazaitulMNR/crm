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

    <div class="col-md-6 offset-md-3 pb-5">
        <form action="{{ url('store2') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="POST">
            @csrf
            <div class="card px-4 py-4 shadow">
                <div class="bg-dark text-white px-2 py-2">Langkah 2/5: Maklumat Tiket</div>

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

                        <input type="hidden" value="{{ $ticket_id ?? ''}}" class="form-control" name="ticket_id" readonly/>
                        <input type="hidden" value="{{ $ticket_type ?? ''}}" class="form-control" name="ticket_type" readonly/>
                        <input type="hidden" value="{{ $student->ic }}" class="form-control" name="ic" readonly/>

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
                            <select id="quantity" name="quantity" onchange="calculateAmount(this.value)" value="{{ $payment->quantity ?? '' }}" class="form-select">
                                <option value="" disabled selected>-- Tiket --</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                        <div class="col-md-6 pb-2">
                            <label for="totalprice">Jumlah Harga (RM)</label><br>
                            <h3><input type="text" id="totalprices" name="totalprices" value="FREE" style="border: none; background-color: transparent;" readonly></h3>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <div class="pull-left">
                        <a href="{{ url('maklumat-pembeli') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $student->ic }}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                    </div>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-circle btn-lg btn-dark"><i class="fas fa-arrow-right py-1"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>

<!--
|--------------------------------------------------------------------------
| This function is to calculate Total Price
|--------------------------------------------------------------------------
-->
<script>
    function calculateAmount(val) {
        
      var prices = document.getElementById("price").value;
      var total_price = val * prices;
  
      /*display the result*/
      var divobj = document.getElementById('totalprices');
      total_prices = FREE;
      divobj.value = total_prices;
  
    }
</script>
@endsection