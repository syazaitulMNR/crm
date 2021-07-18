@extends('layouts.app')

@section('title')
  Sales Report
@endsection


@section('content')

<div class="row">
    <div class="col-md-12 px-4 py-4">   
        <div class="card">
            <div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
                <a href="/dashboard"><i class="bi bi-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <b>Email Template</b>
            </div> 
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h1>Email Template</h1>
                    </div> 
                    <div class="col-md-7">
                    </div>
                    <div class="col-md-1">
                        <a href="/emailtemplate/add" class="btn btn-primary">Add mail</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 "> 
                        <!-- Search box ---------------------------------------------------------->
                        <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Please Enter Event Name" title="Type in a name">
                        <br>

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        
                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-bs-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                    
                        <!-- View event details in table ----------------------------------------->
                        <div class="table-responsive">
                            <table class="table table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" class="text-center">Name</th>
                                        <th scope="col" class="text-right"><i class="fas fa-cogs"></i></th>
                                    </tr>
                                </thead>

                                <tbody> 
                                @foreach ($emailsTemplate as $key => $emailTemplate)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td class="text-center">{{$emailTemplate -> name}}</td>
                                        <td class="text-right">
                                            <a class="btn btn-success" href="/emailtemplate/edit/{{$emailTemplate->id}}"><i class="bi bi-pencil"></i></i></a>
                                            <a class="btn btn-danger" href="/emailtemplate/delete/{{$emailTemplate->id}}"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>   
                        </div>  

                    </div>
                </div>
            </div>
            
        </div>
    
    </div>
</div>

@endsection