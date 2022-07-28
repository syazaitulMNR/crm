@extends('layouts.temp')

@section('title')
    Maklumat Pelanggan
@endsection

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
{{-- Phone country code css -----------------------}}
{{-- <link rel="stylesheet" href="{{ URL::asset('assets/css/intlTelInput.css') }}" /> --}}

<style>
    .iti-flag {background-image: url(cover_images/flags.png);}

    @media (-webkit-min-device-pixle-ratio: 2), (min-resolution: 192dpi){
        .iti-flag {background-image: url(image/flag@2x.png);}
    }
</style>

    <div class="row">
        <div class="col-md-12 px-3 pt-5 pb-3 text-center">
            <img src="{{ asset('assets/images/logo.png') }}" style="max-width:150px">
            <h1 class="text-dark px-4 pt-3">{{ $voucher->name }}</h1>
            <p>Hai! Sila semak butiran peribadi anda.</p>
        </div>
    </div>

    <div class="col-md-8 mb-3 offset-md-2">
        <div class="container">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-center bg-dark text-white px-4 py-2">Maklumat Pelanggan</h5>

                    <form action="{{ url('voucher/details/save') }}/{{ $voucher->voucher_id }}/{{ $student->stud_id }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 pb-2">
                                <label for="description">No. Kad Pengenalan/Passport:</label>
                                <input type="text" value="{{ $student->ic ?? '' }}" class="form-control" name="ic" readonly/>
                            </div>

                            <div class="col-md-6 pb-1">
                                <label for="description">Nama Facebook Page:</label><br>
                                <input type="text" placeholder="Najib Asaddok" name="fb_page" value="{{ $claimed->fb_page ?? old('fb_page') }}" class="form-control" autofocus required>
                                <em class="text-danger">*Pastikan nama Facebook Page adalah betul dan sah.</em>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 pb-2">
                                <label for="title">Nama Pertama:</label>
                                <input type="text" value="{{ $student->first_name ?? '' }}" class="form-control" placeholder="Mohammad"  name="first_name" required>
                            </div>
                            
                            <div class="col-md-6 pb-2">
                                <label for="title">Nama Akhir:</label>
                                <input type="text" value="{{ $student->last_name ?? '' }}" class="form-control" placeholder="Ali"  name="last_name" required>
                            </div>
                        </div>
                            
                        <div class="row">
                            <div class="col-md-6 pb-2">
                                <label for="description">Emel:</label>
                                <input type="email"  value="{{ $student->email ?? '' }}" class="form-control" name="email" placeholder="example@gmail.com" required>
                            </div>
                            
                            <div class="col-md-6 pb-2">
                                <label for="description">No. Telefon:</label><br>
                                <input id="" type="tel" placeholder="0123456789" name="phoneno" value="{{ $student->phoneno ?? '' }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3 text-center">
                            <div class="pull-right">
                                <button type="submit" class="btn px-3 btn-dark">Simpan&nbsp;&nbsp;<i class="fas fa-arrow-right py-1"></i></button>
                            </div>                            
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <footer class="lead text-center px-4 py-2">
        <b>Momentum Internet (1079998-A) © 2020 All Rights Reserved​</b>
    </footer>

{{-- Phone country code -----------------------------------------------------------------------------------------------------}}
<script type="text/javascript" src="{{ URL::asset('assets/js/intlTelInput.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/cleave.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/test.js') }}"></script>
<script>
    var input = document.querySelector('#input-phone');
    var iti = window.intlTelInput (input,  {
        utilsScript:'js/utils.js'
    }); 
</script> 
{{-- End Phone country code -------------------------------------------------------------------------------------------------}}
@endsection