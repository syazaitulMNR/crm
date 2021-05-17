@extends('layouts.temp')

@section('title')
E-Certificate
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 pt-5 pb-3 text-center">
            <img src="/assets/images/logo.png" style="max-width:150px">
            <h1 class="display-4 text-dark px-4 pt-3">{{ $product->name }}</h1>
        </div>

        <div class="col-md-12 d-flex justify-content-center pb-5">
  
            <div class="card w-100 shadow">
                <div class="card-header bg-dark text-white">Sila semak maklumat anda</div>

                <div class="card-body px-3">

                    <table class="table table-borderless">
                        <tr>
                            <td >No. IC</td>
                            <td>:</td>
                            <td class="text-break">{{ $student->ic }}</td>
                        </tr>
                        <tr>
                            <td >Nama</td>
                            <td>:</td>
                            <td class="text-break">{{ $student->first_name }} {{ $student->last_name }}</td>
                        </tr>
                        <tr>
                            <td >No Tel</td>
                            <td>:</td>
                            <td> {{ $student->phoneno }} </td>
                        </tr>
                        <tr>
                            <td >Email</td>
                            <td>:</td>
                            <td> {{ $student->email }} </td>
                        </tr>
                    </table> 
                </div>

                <div class="card-footer">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <a href="{{ url('e-cert') }}/{{ $product->product_id }}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ url('certificate') }}/{{ $product->product_id }}/{{ $student->stud_id }}" class="btn btn-circle btn-lg btn-success"><i class="fas fa-check py-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</div>


@endsection