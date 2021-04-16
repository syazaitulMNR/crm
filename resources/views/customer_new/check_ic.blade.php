@extends('layouts.temp')

@section('title')
{{ $package->name }}
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
            <form action="{{ url('verification') }}/{{ $product->product_id }}/{{ $package->package_id }}" method="get">
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

    {{-- <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Manage Product</div>
  
                <div class="card-body">
                      
                    <a href="{{ url('step1') }}/{{ $product->product_id }}/{{ $package->package_id }}" class="btn btn-primary pull-right">Create Product</a>
  
                    @if (Session::has('message'))
                        <div class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">IC</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone No</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($student as $students)
                            <tr>
                                <th scope="row">{{$students->stud_id}}</th>
                                <td>{{$students->first_name}}</td>
                                <td>{{$students->last_name}}</td>
                                <td>{{$students->ic}}</td>
                                <td>{{$students->email}}</td>
                                <td>{{$students->phoneno}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
@endsection