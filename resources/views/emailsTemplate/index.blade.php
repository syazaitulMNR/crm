@extends('layouts.app')

@section('title')
  Sales Report
@endsection


@section('content')

<div class="row">
    <div class="col-md-12 px-4 py-4">   
        <div class="card">
            <div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
                <a href="/dashboard"><i class="bi bi-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <b>Customer</b>
            </div> 
            
            <div class="card-body">
                <div class="flex-md-nowrap pt-3 pb-2 mb-3 border-bottom d-flex justify-content-between">
                    <h1 class="h2">Customer</h1>
                    <a href="/emailtemplate/add" class="btn btn-primary">Add mail</a>
                </div> 
                <div class="row">
                    <div class="col-md-12 "> 
                        <!-- Search box ---------------------------------------------------------->
                        <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Please Enter Event Name" title="Type in a name">
                        <br>
                    
                        <!-- View event details in table ----------------------------------------->
                        <div class="table-responsive">
                            <table class="table table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col"><i class="fas fa-cogs"></i></th>
                                    </tr>
                                </thead>

                                <tbody> 
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <a class="btn btn-dark" href="">Edit<i class="bi bi-chevron-right"></i></a>
                                            <a class="btn btn-dark" href="">Delete<i class="bi bi-chevron-right"></i></a>
                                        </td>
                                    </tr>
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