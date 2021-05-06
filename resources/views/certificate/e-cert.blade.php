@extends('layouts.temp')

@section('title')
E-Certificate
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 pt-5 text-center">
        <img src="/assets/images/logo.png" style="max-width:150px">
    </div>
</div>

<div class="row">
    <div class="col-md-12 pt-5 text-center">
        <h1 class="display-1 text-break">CERTIFICATE</h1>
        <h1 class="display-4">OF COMPLETION</h1>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-12 pt-5 text-center">
        <h3> {{ $student->first_name }} {{ $student->last_name }}</h3>
        <h5> ({{ $student->ic }})</h5>
    </div>
</div>

<div class="row">
    <div class="col-md-12 pt-5 text-center">
        <p class="lead"> Successfully complete the</p>
        <h3> {{ $product->name }}</h3>
    </div>
    <div class="col-md-12 pt-5 text-center">
        <p class="lead"> Date</p>
        <h3> {{ $product->date_from }} &nbsp; to &nbsp; {{ $product->date_to }}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12 py-5 px-5">
        <div style="padding-left: 20%; padding-right: 20%;">  
            <img src="/assets/images/certified_cop.png" style="max-width:150px;">
        </div>
    </div>
</div>
@endsection