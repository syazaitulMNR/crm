@extends('layouts.temp')

@section('title')
Pendaftaran Pembeli
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 px-2 py-5 text-center">
        <img src="/assets/images/logo.png" style="max-width:150px">
        <h1 class="display-5 text-dark px-3 pt-4">{{ $product->name }}</h1>
    </div>

    <div class="col-md-8 offset-md-2 pb-5">
        <form action="{{ url('store-manual') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $ticket->ticket_id}}" method="post" enctype="multipart/form-data" >
            {{ csrf_field() }}
            <div class="card px-4 py-4 shadow">
                <div class="bg-dark text-white px-2 py-2">Bukti Pembayaran Upgrade Tiket</div>
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger mt-2">
                        <small><strong>{{ $message }}</strong></small>
                    </div>
                @endif

                <div class="card-body px-2">
                    <div class="row">
                        <div class="col-md-6" style="border-right: 1px solid #C0C0C0;">
                            <h5 class="mb-3">Maklumat Pelanggan</h5>
                            <table class="table table-borderless" style="font-size: 9pt;">
                                <tr>
                                    <td class="w-20">No. Kad Pengenalan / Passport</td>
                                    <td>:</td>
                                    <td><strong>{{$student->ic}}</strong></td>
                                </tr>
                                <tr>
                                    <td class="w-20">Nama Pembeli</td>
                                    <td>:</td>
                                    <td class="text-break"><strong>{{$student->first_name}}</strong> <strong>{{$student->last_name}}</strong></td>
                                </tr>
                                <tr>
                                    <td class="w-20">Emel</td>
                                    <td>:</td>
                                    <td class="text-break"><strong>{{$student->email }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="w-20">No. Telefon</td>
                                    <td>:</td>
                                    <td><strong>{{$student->phoneno}}</strong></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5 class="mb-3">Maklumat Tiket</h5>
                            <table class="table table-borderless" style="font-size: 9pt;">
                                @foreach ($packagename as $packages)
                                    @if ($new_package->package_id == $packages->package_id)
                                        <tr>
                                            <td class="w-20">Pakej</td>
                                            <td>:</td>
                                            <td><strong>{{$packages->name}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="w-20">Jumlah Bayaran Tambahan</td>
                                            <td>:</td>
                                            <td><strong>RM {{$new_package->pay_price}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="w-20">Nama Team Momentum</td>
                                            <td>:</td>
                                            <td><input type="text" name="pic" id="pic" class="form-control form-control-sm" placeholder="Nama team yang berurusan" required> </td>
                                        </tr>
                                        <tr>
                                            <td class="w-20">Tarikh/Masa Pembayaran</td>
                                            <td>:</td>
                                            <td><input type="datetime-local" name="pay_datetime" id="pay_datetime" class="form-control form-control-sm" required></td>
                                        </tr>
                                        <tr>
                                            <td class="w-20">Bukti Pembayaran 
                                                <!-- info Modal Button -->
                                                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#infoModal"><i class="bi bi-info-circle" style="color: red" ></i></button>
                                                
                                            </td>
                                            <td>:</td>
                                            <td><input type="file" class="form-control form-control-sm" name="receipt_path" id="receipt_path"></td>
                                        </tr>
                                    @endif  
                                @endforeach 
                            </table>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-sm float-end" >Simpan</button>
                            </div>
                        </div>
                      
                    </div>

                    <hr>
                    <div class="col-md-12">
                        <p class="fs-6 text-center">Sila pastikan maklumat telah diisi dengan betul</p>
                    </div>
                    <hr>
                </div>

                <div class="col-md-12">
                    <div class="pull-left">
                        <a href="{{ url('upgrade-payment') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $ticket->ticket_id}}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                    </div>
                </div>

                <!-- Participant Modal Triggered -->
                <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="participantModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Sending Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to send '<b>Pengesahan Pendaftaran Peserta</b>' to this customer?</p>
                                <p>Example: </p>
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/pengesahan_peserta.jpg') }}" style="max-width:300px">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a class="btn btn-sm btn-dark" href="{{ url('updated-mail') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $ticket->ticket_id }}/{{ $student->stud_id }}">
                                    Send
                                </a>
                            </div>
                            </div>
                        </div>
                    </div>
                
            </div>
        </form>
    </div>
</div>
@endsection