@extends('layouts.temp')

@section('title')
Pendaftaran Peserta
@endsection

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>

{{-- Style to remove arrow in number input ---------}}
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }
</style>

{{-- Phone country code css -----------------------}}
<link rel="stylesheet" href="{{ URL::asset('assets/css/intlTelInput.css') }}" />
<style>
    .iti-flag {background-image: url(cover_images/flags.png);}

    @media (-webkit-min-device-pixle-ratio: 2), (min-resolution: 192dpi){
        .iti-flag {background-image: url(image/flag@2x.png);}
    }
</style>

{{-- Custom button css ----------------------------}}
<style>
    .button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 32px 16px;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 5px;
    transition-duration: 0.4s;
    cursor: pointer;
    }
    .button4 {
    background-color: #f3f3f3;
    color: #202020;
    border: 1px #e7e7e7 solid;
    width: 150px;
    }

    .button4:hover {background-color: #e7e7e7;}
</style>

{{-- Heading --}}
<div class="col-md-12 px-2 pt-5 text-center">
    <img src="/assets/images/logo.png" style="max-width:200px">
    <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>

    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }} 
    </div>
    @endif
</div>

<!-- MultiStep Form -->
<div class="col-md-12 px-2 py-3">
    <form class="pb-4" id="msform" name="frm" action="{{ url('register') }}/{{ $product->product_id }}/{{ $package->package_id }}/{{ $student->stud_id }}" method="post" onsubmit="return checkForm(this);">
        @csrf
        <!-- fieldsets -->
        <fieldset>
            <div class="col-md-12">
                <h3 class="fs-subtitle" style="background: #202020; padding:  10px; border-radius: 5px; color: #fff;"> Langkah 1/5 </h3>
                <h2 class="fs-title">Maklumat Peribadi</h2>
                <h3 class="fs-subtitle">Hai! Terima kasih kerana masih setia menghadiri program kami. Sila semak butiran peribadi anda.</h3>
                <hr>
            </div>

            <div class="col-sm-10 mx-auto py-2">   
                <input class="form-control" type="text" id="ic" name="ic" value="{{ $student->ic }}" readonly/>
            </div>
            <div class="col-sm-10 mx-auto py-2">
                <input class="form-control" type="text" id="first_name" name="first_name" value="{{ $student->first_name }}" placeholder="Nama Pertama" required/>
            </div>
            <div class="col-sm-10 mx-auto py-2">
                <input class="form-control" type="text" id="last_name" name="last_name" value="{{ $student->last_name }}" placeholder="Nama Akhir" required/>
            </div>
            <div class="col-sm-10 mx-auto py-2">
                <input class="form-control" type="email" id="email" name="email" value="{{ $student->email }}" placeholder="Emel *Cth: contoh@gmail.com" required/>
            </div>
            <div class="col-sm-10 mx-auto py-2">  
                {{-- code --}}
                <input class="form-control" id="input-phone" type="tel" name="phoneno" value="{{ $student->phoneno }}" required/>
                <br>
                <label style="font-size: 10pt; color:rgb(34, 34, 34);"><em>Sila pilih kod negara Cth: *+60 dan isikan no anda *Cth: 1123456789</em></label>
                {{-- code --}}
            </div>
            
            <input type="button" name="next" class="next action-button" value="Next"/>

        </fieldset>
        <fieldset>
            <div class="col-md-12">
                <h3 class="fs-subtitle" style="background: #202020; padding:  10px; border-radius: 5px; color: #fff;"> Langkah 2/5 </h3>
                <h2 class="fs-title">Maklumat Tiket</h2>
                <h3 class="fs-subtitle">Sila masukkan kuantiti tiket yang diperlukan.</h3>
                <hr>
            </div>

            <table class="table table-borderless">
                <tr>
                    <th scope="col" class="text-right" style="width:50%">Pakej:</th>
                    <td class="text-left" style="width:50%">{{ $package->name }}</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" style="width:50%">Harga:</th>
                    <td class="text-left" style="width:50%">RM {{ $package->price }}<input type="hidden" id="price" name="price" value="{{ $package->price }}" disabled></td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" style="width:50%">Kuantiti:</th>
                    <td class="text-left" style="width:50%"><select id="quantity" name="quantity" onchange="calculateAmount(this.value)" required>
                        <option value="" disabled selected>-- Tiket --</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" style="width:50%">Jumlah:</th>
                    <td class="text-left" style="width:50%">RM <input type="text" id="item_total" name="item_total" style="width:50px; border: none; outline-width: 0;" readonly></td>
                </tr>
            </table>

            {{-- <div class="col-sm-10 mx-auto py-2 text-center">
                <b>Pakej</b><br>
                <span>{{ $package->name }}</span>
            </div>
            <div class="col-sm-10 mx-auto py-2 text-center">
                <b>Harga</b><br>
                <span>RM {{ $package->price }}<input type="hidden" id="price" name="price" value="{{ $package->price }}" disabled></span>
            </div>
            <div class="col-sm-10 mx-auto py-2 text-center">
                <b>Kuantiti</b><br>
                <span>
                    <select id="quantity" name="quantity" onchange="calculateAmount(this.value)" required>
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </span>
            </div>
            <div class="col-sm-10 mx-auto py-2 pb-4 text-center">
                <b>Jumlah Bayaran</b><br>
                <h4>RM <input type="text" id="item_total" name="item_total" value="{{ $package->price }}" style="width:60px; border: none; outline-width: 0;" readonly></h4>
            </div> --}}
                            
            <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
            <input type="button" name="next" class="next action-button" value="Next"/>
        </fieldset>
        <fieldset>
            <div class="col-md-12">
                <h3 class="fs-subtitle" style="background: #202020; padding:  10px; border-radius: 5px; color: #fff;"> Langkah 3/5 </h3>
                <h2 class="fs-title">Pengesahan Pembelian</h2>
                <h3 class="fs-subtitle">Sila pastikan maklumat telah diisi dengan betul.</h3>
                <hr>
            </div>

            <div class="col-sm-10 mx-auto py-2 text-center">
                <b>No Kad Pengenalan</b><br>
                <span id="icVal"></span>
            </div>
            <div class="col-sm-10 mx-auto py-2 text-center">
                <b>Nama</b><br>
                <span id="first_nameVal" class="text-break"></span>
                <span id="last_nameVal" class="text-break"></span>
            </div>
            <div class="col-sm-10 mx-auto py-2 text-center">
                <b>Emel</b><br>
                <span id="emailVal" class="text-break"></span>
            </div>
            <div class="col-sm-10 mx-auto py-2 text-center">
                <b>No Telefon</b><br>
                <span id="input-phoneVal"></span>
            </div>
            <div class="col-sm-10 mx-auto py-2 text-center">
                <b>Pakej</b><br>
                {{ $package->name }}
            </div>
            <div class="col-sm-10 mx-auto py-2 text-center">
                <b>Kuantiti</b><br>
                <span id="quantityVal" value=""></span>
            </div>
            <div class="col-sm-10 mx-auto py-2 pb-4 text-center">
                <b>Jumlah Bayaran</b><br>
                <h4>RM <span id="total_lah"></span></h4>
            </div>

            <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
            <input type="button" name="next" class="next action-button" value="Next"/>
        </fieldset>
        <fieldset>
            <div class="col-md-12">
                <h3 class="fs-subtitle" style="background: #202020; padding:  10px; border-radius: 5px; color: #fff;"> Langkah 4/5 </h3>
                <h2 class="fs-title">Jenis Pembayaran</h2>
                <h3 class="fs-subtitle">Sila pilih jenis pembayaran anda</h3>
                <hr>
            </div>

            <div class="row d-flex justify-content-center">
                <button class="button button4" id="nextPay" name="pay_method" value="card" href="">
                    <i class="far fa-credit-card fa-3x"></i>
                    <br>Card Debit/Credit
                </button>
            
                <button class="button button4" name="pay_method" value="fpx" href="">
                    <i class="fas fa-university fa-3x"></i>
                    <br>Online Banking
                </button>
            </div>
            
            {{-- <table class="table table-borderless">
                <tr>
                    <td scope="col" class="text-right" style="width:47%">
                        <div class="form-check pt-2">
                            <input class="form-check-input" type="radio" name="stripe" id="stripe" value="stripe" checked>  
                        </div>
                    </td>
                    <td class="text-left" style="width:63%">
                        <label class="form-check-label" for="exampleRadios1">
                            <img class="img-responsive" style="width:80px" src="https://upload.wikimedia.org/wikipedia/en/e/eb/Stripe_logo%2C_revised_2016.png">
                        </label>
                    </td>
                </tr>
            </table>            

            <input type="button" name="next" class="next action-button" value="Next"/> --}}
            <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
        </fieldset>
        <fieldset>
            <div class="col-md-12">
                <h3 class="fs-subtitle" style="background: #202020; padding:  10px; border-radius: 5px; color: #fff;"> Langkah 5/5 </h3>
                <h2 class="fs-title">Check Out</h2>
                <h3 class="fs-subtitle">Sila masukkan maklumat pembayaran anda</h3>
                <hr>
            </div>
            
            <img class="img-responsive" style="width:200px" src="https://www.hydrohotel.co.im/wp-content/uploads/2020/03/payment-options.png">

                <div class="form-group px-2">
                    <input class="form-control" type="text" name="cardholder" placeholder="Name on Card" required>
                </div>

                <div class="field px-2">

                    <!-- A Stripe Element will be display here. -->
                    <div id="card-element"></div>

                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                    
                </div>

                <div class="form-group px-2">
                    <input  class="creditcard form-control" name="cardnumber" placeholder="Card Number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    type="number" maxlength="16" required="">
                </div>

                <div class="field px-2">
                    <div class="two fields">
                        <div class="field">
                            <div class="row">
                                <div class="col">
                                    <input class="form-control" type="number" name="month" placeholder="MM" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2" required="">
                                </div>
                                /
                                <div class="col">
                                    <input class="form-control" type="number" name="year" placeholder="YYYY" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" required="">
                                </div>
                            </div>
                        </div>
    
                        <div class="field py-3">
                            <input class="form-control" type="number" name="cvc" placeholder="CVC Code" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="3" required>
                        </div>
                        <input type="hidden" name="jumlah" class="col-sm-6 text-left pt-2" id="total_lagi" readonly >
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

            <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
            <input type="submit" name="myButton" onclick="return IsEmpty();" class="submit action-button" value="Submit"/>
        </fieldset>
    </form>
</div>

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

{{-- Form validation --------------------------------------------------------------------------------------------------------}}
<script>
    var val = {
    // Specify validation rules
    rules: {
        ic: "required",
        first_name: "required",
        last_name: "required",
        email: {
            required: true,
            email: true
            },
    // phoneno: {
    //     required:true,
    //     minlength:10,
    //     maxlength:10,
    //     digits:true
    // },
    
    },
    
    // Specify validation error messages
    messages: {
    ic:    "IC is required",
    first_name:    "First name is required",
    last_name:    "Last name is required",
    email: {
        required:   "Email is required",
        email:    "Please enter a valid e-mail",
    },
    phoneno:{
        required:   "Phone number is requied",
        minlength:  "Please enter 10 digit mobile number",
        maxlength:  "Please enter 10 digit mobile number",
        digits:   "Only numbers are allowed in this field"
    },
    
    }
}
 
$("form").multiStepForm({
  validations:val
});
</script>
{{-- End Form validation ----------------------------------------------------------------------------------------------------}}

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

