@extends('layouts.app')

@section('title')
    Event
@endsection

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')

<!-- Jquery (For Date) --------------------------------------------------->
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/humanity/jquery-ui.css"> 

<div class="row py-4">
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        
        <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
            <a href="/product"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="dashboard">Dashboard</a> / <a href="/product">Event</a> / <b>Create Event</b>
        </div>
  
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Create Event</h1>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
            </div>
        @endif

        <!-- Add product form --------------------------------------------------->
        <form action="{{ url('addproduct') }}" method="POST" enctype="multipart/form-data"> 
        @csrf
            <div class="row pt-3" style="padding-left: 8%">
                <div class='col-md-8'>         
                    <div class="form-group">
                        <label for="name">Event Name</label>
                        <input name="prodname" type="text" class="form-control" required>
                    </div>
                </div>

                <div class='col-md-8'>         
                    <div class="form-group">
                        <label for="name">Description</label>
                        <textarea name="description" type="text" class="form-control" required></textarea>
                    </div>
                </div>

                <div class='col-md-8'>     
                    <label for="name">Date</label>
                    <div class="form-group row pl-3">
                        <input type="text" name="date1" id="date1" class="form-control" style="width:46.5%" placeholder="Date From" required/>
                        &nbsp;&nbsp;&nbsp; To &nbsp;&nbsp;&nbsp;
                        <input type="text" name="date2" id="date2" class="form-control" style="width:46.5%" placeholder="Date To" required/>
                    </div>
                </div>

                <div class='col-md-8'>     
                    <label for="name">Time</label>
                    <div class="form-group row pl-3">
                        <input type="time" name="time1" class="form-control" style="width:46.5%" required/>
                        &nbsp;&nbsp;&nbsp; To &nbsp;&nbsp;&nbsp;
                        <input type="time" name="time2" class="form-control" style="width:46.5%" required/>
                    </div>
                </div>

                <div class="col-md-8">                         
                    <div class="form-group">
                        <label for="formFile" class="form-label">Certificate Image</label>
                        <input class="form-control" type="file" id="formFile" name="cert_image">
                        <em>*Please ignore this part if there is no certificate provided for the event</em>
                    </div>
                </div>
                        
                <div class='col-md-8 pt-3'>
                    <button type='submit' class='btn btn-primary float-right'> Submit </button>
                </div>
            </div>
        </form>

    </main>
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
</script>
  
@endsection

