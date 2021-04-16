@extends('layouts.temp')

@section('title')
Pendaftaran Pembeli
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 py-5 text-center">
            <img src="/assets/images/logo.png" style="max-width:200px">
            <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
            <input type="hidden" data-id="{{ $product->product_id }}" />
        </div>

        <div class="col-md-12 d-flex justify-content-center pb-5">
            <form id="payment-form" method="POST" onsubmit="return checkForm(this);">
                @csrf
                <div class="card w-100">
                    <div class="card-header bg-dark text-white">Langkah 5: Pembayaran Tiket </div>
  
                    <div class="card-body">
  
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="px-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-row d-flex justify-content-center py-2">
                            <div class="text-start">
                                <img class="img-responsive pb-1" style="width:20%" src="/assets/images/Logo-FPX.png">

                                <div id="fpx-bank-element" style="background-color: #f3f3f3; border: 1px #e7e7e7 solid; border-radius:5px; width:350px">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                            </div>
                        </div>
                
                        <!-- Used to display form errors. -->
                        <div id="error-message" role="alert"></div>

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
p
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
  
                    </div>

                    <div class="card-footer">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a href="{{ url('jenis-pembayaran') }}/{{ $product->product_id }}/{{ $package->package_id }}" class="btn btn-danger pull-right">Kembali</a>
                            </div>
                            <div class="pull-right">
                                <button type="submit" name="myButton" id="fpx-button" data-secret="{{ $intent->client_secret }}" class="btn btn-primary">
                                    Bayar RM {{$payment->totalprice}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- <script src="{{ asset('js/client.js') }}"></script> --}}
<script>

    var form = document.getElementById('payment-form');

    form.addEventListener('submit', function (event) {
    event.preventDefault();

    var fpxButton = document.getElementById('fpx-button');
    var clientSecret = fpxButton.dataset.secret;
    stripe.confirmFpxPayment(clientSecret, {
        payment_method: {
        fpx: fpxBank,
        },
        // Return URL where the customer should be redirected after the authorization
        return_url: "{{ url('storeFpx') }}/{{ $product->product_id }}/{{ $package->package_id }}",
    }).then((result) => {
        if (result.error) {
        // Inform the customer that there was an error.
        var errorElement = document.getElementById('error-message');
        errorElement.textContent = result.error.message;
        }
    });
    });

</script>

<script>
    var stripe = Stripe('pk_live_lNl5S8TossaoQYO0qKwSM5pr004b28isKu');
    var elements = stripe.elements();

    var style = {
        base: {
            // Add your base input styles here. For example:
            padding: '10px 12px',
            color: '#32325d',
            fontSize: '16px',
        },
    };

    // Create an instance of the fpxBank Element.
    var fpxBank = elements.create(
        'fpxBank', {
            style: style,
            accountHolderType: 'individual',
        }
    );

    // Add an instance of the fpxBank Element into the container with id `fpx-bank-element`.
    fpxBank.mount('#fpx-bank-element');

</script>

{{-- Disabled multiple submission on payment --------------------------------------------------------------------------------}}
<script type="text/javascript">

    function checkForm(form) // Submit button clicked
    {
        form.myButton.disabled = true;
        form.myButton.value = "Wait...";
        return true;
    }

</script>
{{-- End Disabled multiple submission on payment ----------------------------------------------------------------------------}}
@endsection