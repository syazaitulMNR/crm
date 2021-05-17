@extends('layouts.temp')

@section('title')
E-Certificate
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 py-5 text-center">
            <img src="/assets/images/logo.png" style="max-width:200px">
            <h1 class="display-4 text-dark px-4 pt-3">{{ $product->name }}</h1>
            <h6>Hai! Terima kasih kerana masih setia menghadiri program kami. Sila semak butiran peribadi anda.</h6>
        </div>

        <div class="col-md-12 d-flex justify-content-center pb-5">  
            <div class="card w-100 shadow">
                <div class="card-header bg-dark text-white">Maklumat Peserta</div>

                <div class="card-body">

                    <div class="form-group row">

                        <div class="col-md-12 pb-2">
                            <label for="description">No. Kad Pengenalan/Passport:</label>
                            <input type="text"  value="{{ $student->ic }}" class="form-control" readonly/>
                        </div>

                        <div class="col-md-6 pb-2">
                            <label for="title">Nama Pertama:</label>
                            <input type="text" value="{{ $student->first_name }}" class="form-control" readonly/>
                        </div>
                        <div class="col-md-6 pb-2">
                            <label for="title">Nama Akhir:</label>
                            <input type="text" value="{{ $student->last_name }}" class="form-control" readonly/>
                        </div>

                        <div class="col-md-6 pb-2">
                            <label for="description">Emel:</label>
                            <input type="text"  value="{{ $student->email }}" class="form-control" readonly/>
                        </div>
                        
                        <div class="col-md-6 pb-2">
                            <label for="description">No. Telefon:</label><br>
                            <input type="tel" name="phoneno" value="{{ $student->phoneno }}" class="form-control" readonly/>
                        </div>
                    </div>
                        
                </div>

                <div class="card-footer">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <a href="{{ url('e-cert') }}/{{ $product->product_id }}" class="btn btn-circle btn-lg btn-outline-dark"><i class="fas fa-arrow-left" style="padding-top:35%"></i></a>
                        </div>
                    </div>

                    <div class="col-md-12 pb-3">
                        <div class="pull-right">
                            <button type="submit" name="myButton" class="btn btn-circle btn-lg btn-success"><i class="fas fa-check py-1"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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