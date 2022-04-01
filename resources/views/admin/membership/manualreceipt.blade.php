@extends('layouts.app')

@section('title')
    Event
@endsection


@section('content')

<!-- Jquery (For Date) --------------------------------------------------->
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/humanity/jquery-ui.css"> 

<div class="col-md-12 pt-3">
        
    <div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
        <a href="/product"><i class="bi bi-arrow-left"></i></a> &nbsp; <a href="dashboard">Dashboard</a> / <a href="/product">Event</a> / <b>Create Invoice</b>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create Invoice</h1>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <!-- Add product form --------------------------------------------------->
    <form class="row g-3 px-3" action="{{ url('manualdownload-receipt') }}" method="POST" enctype="multipart/form-data"> 
    @csrf

        <div class="col-md-6">
            <label class="form-label">Receive From</label>
            <input name="receiptfrom" placeholder="John Doe" type="text" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Receipt No</label>
            <input name="receiptno" placeholder="OD98172974.." type="text" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Payment Date</label>
            <input type="text" name="date1" id="date1" class="form-control" placeholder="Date From" required/>
        </div>
        <div class="col-md-4">
            <label class="form-label">Reference Number</label>
            <input name="referencenumber" placeholder="Bank Reference Code or etc .." type="text" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Payment Method</label>
            <input name="paymentmethod" placeholder="Cheque, Transfer Online .." type="text" class="form-control" required>
        </div>

        <hr class="mb-2">

        <div class="col-md-12">
            <label for="feature">List of Receipt</label>
            <div id="inputFormRow">
                <div class="input-group mb-3">
                    <input type="text" name="receiptnumber[]" placeholder="Receipt Number" class="form-control" autocomplete="off" required>
                    <input type="text" name="receiptdate[]" placeholder="Receipt Date" class="form-control" autocomplete="off" required>
                    <input type="text" name="paymentamount[]" placeholder="Payment Amount" class="form-control" autocomplete="off" required>
                    <div class="input-group-append">                
                        <button id="removeRow" type="button" class="btn btn-danger"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>
            </div>

            <div id="newRow"></div>
            <button id="addRow" type='button' class='btn'><i class="bi bi-plus-lg pr-2"></i>Add Row</button>
        </div>
        <hr class="mb-2">

        <div class="col-md-4">
            <label class="form-label">Sub Total</label>
            <input name="subtotal" placeholder="RM 10000" type="text" class="form-control" required>
        </div>

        <div class="col-12"> 
            <button type="submit" class="btn btn-primary float-right"><i class="bi bi-save pr-2"></i>Submit</button>
        </div>
    </form>
</div>

<!-- Function for datepicker --------------------------------------------------->
<script>
    $(document).ready(function () {

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

    });

     // add row
     $("#addRow").click(function () {
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="receiptnumber[]" placeholder="Receipt Number" class="form-control" autocomplete="off" required>';
        html += '<input type="text" name="receiptdate[]" placeholder="Receipt Date" class="form-control" autocomplete="off" required>';
        html += '<input type="text" name="paymentamount[]" placeholder="Payment Amount" class="form-control" autocomplete="off" required>';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="bi bi-x-lg"></i></button>';
        html += '</div>';
        html += '</div>';

        $('#newRow').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });
</script>
  
@endsection

