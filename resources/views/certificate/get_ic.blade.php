@extends('layouts.temp')

@section('title')
{{ $product->name }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 px-2 py-5 text-center">
        <img src="/assets/images/logo.png" style="max-width:200px">
        <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
    </div>
    
    <div class="col-md-12 d-flex justify-content-center">
        <div class="card w-75">
            <div class="px-3 py-3">No. Kad Pengenalan / Passport</div>
            <form action="{{ url('verify') }}/{{ $product->product_id }}" method="get">
                @csrf
                <div class="col-md-12">
                    <input type="text" class="form-control" name="ic" placeholder="tanpa '-'" maxlength="12" required="" >
                    <p style="font-size: 10pt; color:#202020; text-align: left;"><em>Cth: 91042409**** / A********</em></p>
                </div>
                <div class="col-md-12 pb-3">
                    <button type="submit" class="text-white btn btn-block" style="background-color: #202020">Seterusnya</button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="text-center px-4 py-5">
    <b>Momentum Internet (1079998-A) © 2020 All Rights Reserved​</b>
</footer>

@endsection