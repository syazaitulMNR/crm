@extends('layouts.temp')

@section('title')
{{ $packageName }}
@endsection

@section('content')
<div class="row pt-4">
    <div class="col-md-12 px-2 py-5 text-center">
        <img src="/assets/images/logo.png" style="max-width:150px">
        <h1 class="display-5 text-dark px-3 pt-4">{{ $productName }}</h1>
    </div>

<script type="text/javascript">
    function ShowHideDiv() {
        var formGroupExampleInput = document.getElementById("formGroupExampleInput");
        var dvbusiness = document.getElementById("dvbusiness");
        dvbusiness.style.display = formGroupExampleInput.value == "Lain-lain" ? "block" : "none";
    }
</script>

    <div class="col-md-6 offset-md-3">
        <div class="card px-4 py-4 shadow">
            {{-- <div class="bg-dark text-white px-2 py-2">Langkah 2/2: Maklumat Bisnes</div> --}}
            <div class="card-body">
                <form action="{{ url('save-business-details') }}/{{ $ticket_id }}" method="POST" class="col-md-12">
                    @csrf
                    <h5 class="card-title">Isikan Maklumat Perniagaan</h5>
                    <hr>
                    
                    <div class="pb-3 form-group">
                        <label for="formGroupExampleInput">Jenis Perniagaan:</label>
                        <select name="business" class="form-select" id="formGroupExampleInput" required onchange = "ShowHideDiv()">
                            <option value="" disabled selected>-- Sila Pilih --</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Katering & Perkahwinan">Katering & Perkahwinan</option>
                            <option value="Kesihatan">Kesihatan</option>
                            <option value="Kecantikan">Kecantikan</option>
                            <option value="Pelancongan">Pelancongan</option>
                            <option value="Automotif">Automotif</option>
                            <option value="Hartanah">Hartanah</option>
                            <option value="Umrah">Umrah</option>
                            <option value="Takaful / Insuran">Takaful / Insuran</option>
                            <option value="Perunding Kewangan">Perunding Kewangan</option>
                            <option value="Homedeco / Interior Designer">Homedeco / Interior Designer</option>
                            <option value="Pecetakan">Percetakan</option>
                            <option value="Belum Berniaga">Belum Berniaga</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </select>
                        <br>


                        <div class="pb-3 form-group" id="dvbusiness" style="display: none">
                            <label for="title">Sila Nyatakan:</label>
                            <input type="text" name="lain" class="form-control" placeholder="Sila Nyatakan" >
                        </div>

                    </div>
                    
                    <div class="pb-3 row">
                        <div class="form-group col-md-6">
                            <label for="formGroupExampleInput2">Purata Jualan Bulanan</label>
                            {{-- <input type="number" name="income" class="form-control" min="0" id="formGroupExampleInput2" placeholder="0" onkeypress="return isNumber(event)" required> --}}
                            <select id="inputState" class="form-select" name='income' required>
                                <option value=''>-- Sila Pilih --</option>
                                @foreach ($incomeOptions as $i)
                                    <option value="{{ $i->range }}">{{ $i->range }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputState">Status dalam Perniagaan</label>
                            <select id="inputState" class="form-select" name='role' required>
                                <option value=''>-- Sila Pilih --</option>
                                <option value="Founder">Founder</option>
                                <option value="Agent">Agent</option>
                                <option value="Stokis">Stokis</option>
                                <option value="Dropship">Dropship</option>
                                <option value="Team / Pekerja Syarikat">Team / Pekerja Syarikat</option>
                                <option value="Lain-lain">Lain-lain</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-end"><i class="bi bi-save pr-2"></i> Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 text-center pt-3">
        <a href="https://momentuminternet.com/privacy-policy/">Privacy & Policy</a>
    </div>
</div>
<script type="text/javascript">     
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ( (charCode > 31 && charCode < 48) || charCode > 57) {
            return false;
        }
        return true;
    }
</script>

<footer class="text-center px-4 py-5">
    <b>Momentum Internet (1079998-A) © 2022 All Rights Reserved​</b>
</footer>

@endsection