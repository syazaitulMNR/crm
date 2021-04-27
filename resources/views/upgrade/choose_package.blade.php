@extends('layouts.temp')

@section('title')
Upgrade Pakej
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 py-5 text-center">
            <img src="/assets/images/logo.png" style="max-width:200px">
            <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
            <h6>Hai! Sila buat pilihan di bawah untuk upgrade pakej</h6>
        </div>

        <div class="col-md-12 d-flex justify-content-center pb-5">
            <form action="" method="POST">
                @csrf
  
                <div class="card w-100">
                    <div class="card-header bg-dark text-white">Langkah 1: Maklumat Pembeli</div>
  
                    <div class="card-body">

                        <div class="form-group row">

                            {{-- <input type="hidden" value="{{ $stud_id ?? '' }}" class="form-control" name="stud_id" readonly/>

                            <div class="col-md-12 pb-2">
                                <label for="description">No. Kad Pengenalan/Passport:</label>
                                <input type="text"  value="{{ $stud_ic ?? ''}}" class="form-control" id="productAmount" name="ic" readonly/>
                            </div>

                            <div class="col-md-6 pb-2">
                                <label for="title">Nama Pertama:</label>
                                <input type="text" value="{{ $student->first_name ?? '' }}" class="form-control" placeholder="Mohammad"  name="first_name">
                            </div>
                            <div class="col-md-6 pb-2">
                                <label for="title">Nama Akhir:</label>
                                <input type="text" value="{{ $student->last_name ?? '' }}" class="form-control" placeholder="Ali"  name="last_name">
                            </div>

                            <div class="col-md-6 pb-2">
                                <label for="description">Emel:</label>
                                <input type="text"  value="{{ $student->email ?? '' }}" class="form-control" name="email" placeholder="example@gmail.com"/>
                            </div>
                            
                            <div class="col-md-6 pb-2">
                                <label for="description">No. Telefon:</label><br>
                                <input id="input-phone" type="tel" name="phoneno" value="+60{{ $student->phoneno ?? '' }}" class="form-control" />
                                <label style="font-size: 10pt;"><em>Sila pilih kod negara Cth: *+60 dan isikan no anda *Cth: 1123456789</em></label>
                            </div> --}}
                        </div>
                          
                    </div>
  
                    <div class="card-footer">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-dark">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection