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
        <h1 class="display-1">CERTIFICATE</h1>
        <h1 class="display-4">OF COMPLETION</h1>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-12 pt-5 text-center">
        <p class="lead"> {{ $student->first_name }} {{ $student->last_name }}</p>
        <hr>
    </div>
</div>


@endsection