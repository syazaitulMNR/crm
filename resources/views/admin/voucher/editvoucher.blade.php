@extends('layouts.app')

@section('title')
    Voucher
@endsection


@section('content')

<!-- Jquery (For Date) --------------------------------------------------->
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/humanity/jquery-ui.css"> 

<div class="col-md-12 pt-3">
        
    <div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
        <a href="/managevoucher"><i class="bi bi-arrow-left"></i></a> &nbsp; <a href="dashboard">Dashboard</a> / <a href="/managevoucher">Voucher</a> / <b>Edit Voucher</b>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 text-capitalize">Edit Voucher : {{ $voucher->name }}</h1>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <!-- Add product form --------------------------------------------------->
    <form class="row g-3 px-3" action="{{ url('voucher/edit/save') }}/{{ $voucher->voucher_id }}" method="POST" enctype="multipart/form-data"> 
    @csrf
        <div class="col-md-6 px-0">
            <div class="col-md-12 mb-3">
                <label class="form-label">Voucher Name<span class="text-danger">*</span></label>
                <input name="name" type="text" class="form-control" value="{{ $voucher->name }}" required>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Voucher Description <span class="text-danger">(Optional)</span></label>
                <input name="desc" type="text" class="form-control" value="{{ $voucher->desc }}">
            </div>
            <div class="col-md-12">
                <label class="form-label">Voucher Image</label>
                <input class="form-control" type="file" id="formFile" name="img_path">
            </div>
        </div>

        <div class="col-md-6 mt-3 center">
            @if($width > $height)
                {{-- <img src="/assets/images/voucher/voucherMMB.jpg" style="max-width:80%"> --}}
                <img src="{{$voucher->img_path}} " style="max-width:80%">
            @else
                {{-- <img src="/assets/images/voucher/img_62dfac15d1dc3.jpg" style="max-width:20%"> --}}
                <img src="{{$voucher->img_path}} " style="max-width:20%">
            @endif
            {{-- <img src="{{$voucher->img_path}} " style="max-width:80%"> --}}
        </div>

        <div class="col-md-4">
            <label class="form-label">Date From<span class="text-danger">*</span></label>
            <input type="text" name="start_date" id="date1" class="form-control" value="{{ $voucher->start_date }}" placeholder="Date From" required/>
        </div>
        <div class="col-md-4">
            <label for="inputAddress2" class="form-label">Date To<span class="text-danger">*</span></label>
            <input type="text" name="end_date" id="date2" class="form-control" value="{{ $voucher->end_date }}" placeholder="Date To" required/>
        </div>
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select class="form-select" name="status" required>
                <option class="bg-dark text-white" value="{{ $voucher->status }}">{{ $voucher->status }}</option>
                <option value="Active">Active</option>
                <option value="Deactive">Deactive</option>
            </select>
        </div>

        <div class="col-md-12">
            <label class="form-label">Terms and Condition<span class="text-danger">*</span></label>
            <textarea name="tnc" rows="3" class="ckeditor form-control" id="exampleFormControlTextarea1" required>{{ $voucher->tnc }}</textarea>
        </div>

        <div class="col-md-4">
            <label class="form-label">Applicable For Event <span class="text-danger">(Optional)</span></label>
            <select name="product_id" id="product" class="form-select">
                @if($voucher->product_id != null)
                    <option value="{{ $voucher->product_id }}">{{ $voucher->proVoucher->name }}</option>
                    <option class="bg-dark text-white" value="">-- Remove Applicable Event --</option>
                @else
                    <option value="">-- Select Event --</option>
                @endif
                @foreach ($products as $p)
                    <option value="{{ $p->product_id }}">{{ $p->name }}</option>
                @endforeach
            </select>
            <em>*Please ignore this part if voucher open to all participant.</em>
        </div>
        <div class="col-md-4">
            <label class="form-label">Package of Event <span class="text-danger">(Optional)</span></label>
            <select name="package_id" id="package" class="form-select">
                @if($voucher->package_id != null)
                    <option value="{{ $voucher->package_id }}">{{ $voucher->pacVoucher->name }}</option>
                    <option class="bg-dark text-white" value="">-- Remove Applicable Package --</option>
                @else
                    <option value="">-- Select Package --</option>
                @endif
            </select>
            <em>*Please ignore this part if voucher open to all participant.</em>
        </div>
        <div class="col-md-4">
            <label class="form-label">Maximum Generate Voucher <span class="text-danger">(Optional)</span></label>
            <input class="form-control" type="number" name="max" value="{{ $voucher->max }}">
            <em>*Please ignore this part if there is no maximum number</em>
        </div>        

        <div class="col-12">
            <button type="submit" class="btn btn-primary float-right"><i class="bi bi-save pr-2"></i>Submit</button>
        </div>
    </form>

</div>

<!-- Function for datepicker --------------------------------------------------->
<script>
    $(document).ready(function ()
    {
        $('#product').on('change', function () {
            var productId = this.value;
            $('#package').html('');
            $.ajax({
                url: '{{ url('managevoucher/create/getPackage') }}?product_id='+productId,
                type: 'get',
                success: function (res) {
                    $('#package').html('<option value="">-- Select Package --</option>');
                    $.each(res, function (key, value) {
                        $('#package').append('<option value="' + value.package_id + '">' + value.name + '</option>');
                    });
                }
            });
        });

        $("#date1").datepicker({
            showAnim: 'drop',
            numberOfMonth: 1,
            dateFormat: 'dd-mm-yy',
            onClose: function (selectedDate) {
                $("#date2").datepicker("option", "minDate", selectedDate);
            }
        });

        $("#date2").datepicker({
            showAnim: 'drop',
            numberOfMonth: 1,
            dateFormat: 'dd-mm-yy',
            onClose: function (selectedDate) {
                $("#date1").datepicker("option", "maxDate", selectedDate);
            }
        });

        $('.ckeditor').ckeditor();
    });
</script>
  
@endsection

