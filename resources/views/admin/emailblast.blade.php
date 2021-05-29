@extends('layouts.app')

@section('title')
    Email Blasting
@endsection

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')
<div class="row py-4">     
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

      <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
        <a href="/dashboard"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="dashboard">Dashboard</a> / <b>Email Blasting</b>
      </div>

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Email Blasting</h1>
      </div>

        <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Please Enter Event Name" title="Type in a name">

        <div class="float-right pt-3">{{$product->links()}}</div>

        <br> 

        @if(count($product) > 0)
        <table class="table table-hover" id="myTable">
            <thead>
            <tr class="header">
                <th>#</th>
                <th style="width:12%">Event Date</th>
                <th>Event Name</th>
                {{-- <th class="text-center">Participant</th> --}}
                <th><i class="fas fa-cogs"></i></th>
            </tr>
            </thead>
            <tbody> 
            @foreach ($product as $key => $products)
            <tr>
                <td>{{ $product->firstItem() + $key }}</td>
                <td>{{ date('d/m/Y', strtotime($products->created_at)) }}</td>
                <td>{{ $products->name }}</td>
                {{-- <td class="text-center">{{$totalcust}}</td> --}}
                <td>
                    <a class="btn btn-dark" href="{{ url('view') }}/{{ $products->product_id }}"><i class="fas fa-chevron-right"></i></a>
                    {{-- <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-paper-plane"></i></button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Blast Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to blast the email to all participant in this event ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a class="btn btn-primary" href="">Confirm</a>
                            </div>
                            </div>
                        </div>
                    </div> --}}
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>        
      @else
        <p>There are no record to display.</p>
      @endif
    </main>
  </div>
</div>

<!-- Enable function for search data ------------------------------------->
<script>
  function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[2];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }       
    }
  }
</script>
@endsection