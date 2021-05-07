@extends('layouts.temp')

@section('title')
E-Certificate
@endsection

@section('content')

<div class="container border border-secondary my-3">
    <div class="row py-5">
        <div class="col-md-12 pt-5 text-center">
            <img src="/assets/images/logo.png" style="max-width:150px">
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 pt-5 text-center">
            <h1 class="display-1 text-break">CERTIFICATE</h1>
            <h1 class="display-4">OF COMPLETION</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 pt-5 text-center">
            <h3> {{ $student->first_name }} {{ $student->last_name }}</h3>
            <h5> ({{ $student->ic }})</h5>
        </div>
    </div>
    
    <div class="row pb-5">
        <div class="col-md-12 pt-5 text-center">
            <p class="lead"> Successfully complete the</p>
            <h3> {{ $product->name }}</h3>
        </div>
        <div class="col-md-12 pt-5 text-center">
            <p class="lead"> that was held on </p>
            <h3> {{ $product->date_from }} &nbsp; to &nbsp; {{ $product->date_to }}</h3>
        </div>
    </div>
    
    <div class="row py-5">
        <div class="col-md-6 text-center" style="padding-left: 10%;">  
            <img src="/assets/images/certified_cop.png" style="max-width:150px;">
        </div>
        <div class="col-md-6 text-center" style="padding-right: 10%;">  
            <img src="/assets/images/signature.png" style="max-width:80px;">
            <h3 class="border-top border-dark mt-2">Najib Asaddok</h3>
            <p class="lead m-0"> Chief Executive Officer (CEO)</p>
            <p class="lead m-0"> Momentum Internet Sdn Bhd </p>
        </div>
    </div>
</div>

@endsection