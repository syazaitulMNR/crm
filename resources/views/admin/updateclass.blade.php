
@extends('layouts.app')

@section('title')
    Update Class
@endsection


@section('content')

<div class="col-md-12 pt-3">

    <div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
        <a href="{{ url('segmentation')}}"><i class="bi bi-arrow-left"></i></a> &nbsp; <a href="dashboard">...</a> / <a href="/segmentation">Segmentation</a> / <a href="{{ url('updateclass')}}/{id}">Update Class</a>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Update Class</h1>
    </div>
    
   
    <form action="{{ url('updatesegmentation')}}/{{ $segment->id }}" method="GET" enctype="multipart/form-data"> 
        @csrf
            <div class='col-md-8'>
                <div class='row'>
                    <div class='col-md-9'>         
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input name="name" type="text" class="form-control" value="{{ $segment->name }}" required>
                        </div>
                    </div>
            
                    <div class='col-md-9'>
                        <div class="form-group">
                            <label for="phone">Description</label>
                            <input name="description" type="text" class="form-control" value="{{ $segment->description }}" required>
                        </div>
                    </div>

                    <div class='col-md-9'>
                        <div class="form-group">
                            <label for="phone">Classification</label>
                            <input name="classification" type="text" class="form-control" value="{{ $segment->classification }}" required>
                        </div>
                    </div>

                </div>
            </div>
 
            <div class='col-md-8 pt-3'>
                <button type='submit' class='btn btn-primary float-right'> <i class="bi bi-save pr-2"></i>Update </button>
            </div>
    
        </form>
    
    </div>
@endsection