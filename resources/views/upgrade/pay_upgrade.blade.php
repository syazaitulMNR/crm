@extends('layouts.temp')

@section('title')
Upgrade Pakej
@endsection

<style>
    .myButton{
        cursor:pointer;
        border:none;
        width:100px;
        height:100px;
    }

</style>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 pt-5 pb-3 text-center border-bottom">
            <img src="/assets/images/logo.png" style="max-width:150px">
            <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
        </div>

        <div class="col-md-12 py-3">
            <form action="" method="POST">
                @csrf
                <div class="container text-center">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-10 pb-4 d-block mx-auto">
                            <div class="pricing-item bg-white py-4" style=" box-shadow: 0px 0px 30px -7px rgba(0,0,0,0.29); border-radius: 5px;">
                                <div class="col-md-6 pb-2">
                                    <label for="package">Pakej:</label>
                                    <input type="text"  value="{{ $package->name }}" class="form-control" readonly/>
                                </div>
                                <div class="col-md-6 pb-2">
                                    <label for="price">Harga:</label>
                                    <input type="text" value="{{ $package->price }}" class="form-control" readonly/>
                                    <input type="hidden" id="price" name="price" value="{{ $package->price }}" disabled>
                                </div>


                                <div class="pricing-button pt-1 pb-1">
                                    <button type="button" class="btn btn-lg btn-outline-dark w-75" disabled>Pakej Semasa</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                    
            </form>
        </div>
    </div>
</div>
@endsection