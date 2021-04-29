@extends('layouts.temp')

@section('title')
Upgrade Pakej
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 pt-5 pb-3 text-center">
            <img src="/assets/images/logo.png" style="max-width:150px">
            <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
        </div>

        <div class="col-md-12 py-3">
            <form action="" method="POST">
                @csrf
                <div class="container text-center">
                    <div class="row">
                        <div class="col-auto pb-4 d-block mx-auto">
                            <div class="pricing-item bg-white py-4 px-4" style=" box-shadow: 0px 0px 30px -7px rgba(0,0,0,0.29); border-radius: 5px;">
                                <div class="border-bottom pb-1" style="letter-spacing: 2px">
                                    <h4>Jenis Pembayaran</h4>
                                </div>
                                
                                @if(session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }} 
                                </div>
                                @endif
        
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <img class="img-responsive" style="width:200px" src="https://www.hydrohotel.co.im/wp-content/uploads/2020/03/payment-options.png">

                                <div class="form-group px-2">
                                    <input class="form-control" type="text" name="cardholder" placeholder="Name on Card" required>
                                </div>

                                <div class="field px-2">

                                    <!-- A Stripe Element will be inserted here. -->
                                    <div id="card-element"></div>

                                    <!-- Used to display form errors. -->
                                    <div id="card-errors" role="alert"></div>
                                    
                                </div>

                                <div class="form-group px-2">
                                    <input  class="creditcard form-control" name="cardnumber" placeholder="Card Number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    type="number" maxlength="16" required="">
                                </div>

                                <div class="field px-2">
                                    <div class="one fields">
                                        <div class="field">
                                            <div class="row">
                                                <div class="col">
                                                    <input class="form-control w-25" type="number" name="month" placeholder="MM" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2" required="">
                                                </div>
                                                /
                                                <div class="col">
                                                    <input class="form-control w-25" type="number" name="year" placeholder="YYYY" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" required="">
                                                </div>
                                                <div class="col">
                                                    <input class="form-control w-25" type="number" name="cvc" placeholder="CVC Code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="3" required>
                                                </div>
                                                <input type="hidden" name="jumlah" class="col-sm-6 text-left pt-2" value="{{ $payment->totalprice }}" readonly >
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="inline field px-2 pb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Saya telah membaca dan bersetuju dengan <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" >Terma & Syarat</a> yang telah ditetapkan.
                                        </label>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">TERMA & SYARAT</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="px-4">
                                                            <li class="text-justify py-2">Segala pembayaran yang telah dibuat kepada pihak penganjur untuk tujuan penyertaan program yang 
                                                                telah didaftarkan <b>TIDAK AKAN DIKEMBALIKAN</b>.</li>

                                                            <li class="text-justify py-2">Bayaran penuh yuran penyertaan program mestilah diselesaikan 7 hari sebelum program bermula. Kegagalan 
                                                                menjelaskan baki bayaran yuran penyertaan anda sebelum program akan mengakibatkan penyertaan anda dibatalkan.</li>

                                                            <li class="text-justify py-2">Sekiranya anda telah menjelaskan bayaran penuh bagi pakej yang ditawarkan, anda dibenarkan untuk menunda 
                                                                ke program dan pakej yang sama pada tarikh yang akan datang dalam tempoh 6 bulan. Anda <b>MESTI</b> memaklumkan pihak 
                                                                penganjur untuk tujuan ini secara bertulis.</li>

                                                            <li class="text-justify py-2">Akan tetapi, sekiranya anda menunda program yang telah didaftarkan dan bayaran penuh masih belum dijelaskan, 
                                                                jumlah yuran penyertaan program baru akan dikenakan mengikut harga dan pakej semasa. Perlu dijelaskan bahawa 
                                                                anda tidak lagi berpeluang mendapatkan harga promosi yang ditawarkan pada tarikh borang ini ditandatangani.</li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                    
                                
                                <div class="col-md-12 pb-5">
                                    <div class="pull-left">
                                        <a href="{{ url('pay-upgrade') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $student->stud_id }}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                                    </div>
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-circle btn-lg btn-success"><i class="fas fa-check py-1"></i></button>
                                    </div>
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