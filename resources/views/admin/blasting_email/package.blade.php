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
          <a href="/emailblast"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <a href="/emailblast">Email Blasting</a> / <b>{{ $product->name }}</b>
        </div>
  
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">{{ $product->name }}</h1>

        </div>

        <div class="row">
          <div class="col-md-12 "> 
        
            <!-- Show package in table ----------------------------------------------->
            @if(count($package) > 0)
            <table class="table table-hover" id="successTable">
                <thead>
                <tr class="header">
                    <th>#</th>
                    <th>Package Name</th>
                    <th><i class="fas fa-cogs"></i></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($package as $key => $packages)    
                @if ($product->product_id == $packages->product_id)   
                <tr>
                  <td>{{ $package->firstItem() + $key }}</td>
                  <td>{{ $packages->name  }}</td>
                  <td>
                    <a class="btn btn-sm btn-dark" href="{{ url('view-event') }}/{{ $product->product_id }}/{{ $packages->package_id }}"><i class="fas fa-user pr-1"></i> Buyer</a>                   
                    <a class="btn btn-sm btn-dark" href="{{ url('blast-participant') }}/{{ $product->product_id }}/{{ $packages->package_id }}"><i class="fas fa-users pr-1"></i> Participant</a>
                  </td>
                </tr>
                @endif
                @endforeach
                </tbody>
            </table>  
            @else
            <p>There are no package yet.</p>
            @endif
            <div class="float-right pt-3">{{$package->links()}}</div>
            
          </div>
          
        </div>
        
    </main>
  </div>
</div>


<!-- Enable function for search payment ------------------------------------->
<script>
  function successFunction() 
  {
    var input, filter, table, tr, td, i, txtValue;

    input = document.getElementById("successInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("successTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) 
    {
      td = tr[i].getElementsByTagName("td")[1];
      
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
