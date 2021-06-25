@extends('layouts.app')

@section('title')
    Product
@endsection

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')

<!---Jquery (For Date) -->
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/humanity/jquery-ui.css"> 


<div class="row py-4">
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

        <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
            <a href="/product"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="dashboard">Dashboard</a> / <a href="/product">Event</a> / <b>Update Product</b>
        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Update Product</h1>
        </div>
        
        <form class="row g-3 px-5" action="{{ url('update') }}/{{ $product->product_id }}" method="POST" enctype="multipart/form-data"> 
        @csrf

            <div class="col-md-6">
                <label class="form-label">Event Name</label>
                <input name="prodname" type="text" class="form-control" value="{{ $product->name }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Offer Provided</label>
                <select class="form-select" aria-label="Default select example" name="offer_id" required>
                    <option disabled selected>-- {{ $product->offer_id }} --</option>
                    @foreach($offers as $offer)
                    <option value="{{ $offer->offer_id }}">{{ $offer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Date From</label>
                <input type="text" name="date1" id="date1" class="form-control" value="{{ $product->date_from }}" required/>
            </div>
            <div class="col-md-6">
                <label for="inputAddress2" class="form-label">Date To</label>
                <input type="text" name="date2" id="date2" class="form-control" value="{{ $product->date_to }}" required/>
            </div>

            <div class="col-md-6">
                <label class="form-label">Time From</label>
                <input type="time" name="time1" class="form-control" value="{{ $product->time_from }}" required/>
            </div>
            <div class="col-md-6">
                <label class="form-label">Time To</label>
                <input type="time" name="time2" class="form-control" value="{{ $product->time_to }}" required/>
            </div>

            <div class="col-md-5">
                <label class="form-label">Certificate Image</label>
                <input class="form-control" type="file" id="formFile" name="cert_image">
                <em>*Please ignore this part if there is no certificate provided for the event</em>
            </div>

            <div class="col-md-4">
                <label class="form-label">Survey Form Link</label>
                <input name="survey_form" type="text" class="form-control" value="{{ $product->survey_form }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">BillPlz Collection ID</label>
                <select class="form-select" name="collection_id">
                    <option disabled selected>-- Please Select One --</option>
                    @foreach($offers as $offer)
                    <option value="{{ $offer->offer_id }}">{{ $offer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>

            {{-- <div class="row py-3" style="padding-left: 8%">
                <div class='col-md-4'>         
                    <div class="form-group">
                        <label for="name">Product</label>
                        <input name="prodname" type="text" class="form-control" value="{{ $product->name }}" required>
                    </div>
                </div>

                <div class='col-md-4'>         
                    <div class="form-group">
                        <label for="name">Offer Provided</label>
                        <select class="form-select" aria-label="Default select example" name="offer_id" required>
                            <option disabled selected>-- Please Select One --</option>
                            @foreach($offers as $offer)
                            <option value="{{ $offer->offer_id }}">{{ $offer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- <div class='col-md-8'>         
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" type="text" class="form-control" required>{{ $product->description }}</textarea>
                    </div>
                </div>

                <div class='col-md-8'>     
                    <label for="name">Date</label>
                    <div class="form-group row pl-3">
                        <input type="text" name="date1" id="date1" class="form-control" value="{{ $product->date_from }}" placeholder="From" style="width:46.5%" required/>
                        &nbsp;&nbsp;&nbsp; To &nbsp;&nbsp;&nbsp;
                        <input type="text" name="date2" id="date2" class="form-control" value="{{ $product->date_to }}" placeholder="To" style="width:46.5%" required/>
                    </div>
                </div>

                <div class='col-md-8'>     
                    <label for="name">Time</label>
                    <div class="form-group row pl-3">
                        <input type="time" name="time1" class="form-control" value="{{ $product->time_from }}" style="width:46.5%"/>
                        &nbsp;&nbsp;&nbsp; To &nbsp;&nbsp;&nbsp;
                        <input type="time" name="time2" class="form-control" value="{{ $product->time_to }}" style="width:46.5%"/>
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
                    <button type='submit' class='btn btn-primary float-right'> Update </button>
                </div>
            
            </div> --}}
                    
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