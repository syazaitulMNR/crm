
@extends('layouts.app')

@section('title')
    Segmentation
@endsection


@section('content')

<div class="col-md-12 pt-3">     
      
  <div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px; mb-3">
    <a href="/dashboard"><i class="bi bi-arrow-left"></i></a> &nbsp; <a href="dashboard">Dashboard</a> / <b>Segmentation</b>
  </div>

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
    <h1 class="h2 mt-3">Class</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group mr-2">
        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#newmembership">
          <i class="bi bi-plus-lg pr-2"></i> Add Class
        </button>
        <div class="modal fade" id="newmembership" tabindex="-1" role="dialog" aria-labelledby="newmembershipLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Add New Class</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ url('addclass') }}" method="POST"> 
                @csrf
                <div class="form-group row px-4">
                    <label class="col-sm-4 col-form-label">Class Name</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" name="name" required>
                    </div>
                  </div>
                  <div class="form-group row px-4">
                    <label class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" name="description" required>
                    </div>
                </div>
                <div class="form-group row px-4">
                  <label class="col-sm-4 col-form-label">Classification</label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" name="classification" required>
                  </div>
                </div>
                                  
                <div class='col-md-12 text-right px-4 pb-3'>
                    <button type='submit' class='btn btn-success'> <i class="fas fa-save pr-1"></i> Save </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 <div class="float-right pt-3"></div> 
  


  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Description</th>
          <th scope="col">Classification</th>
          <th scope="col"><i class="fas fa-cogs"></i></th>
        </tr>
      </thead>
      <tbody>
        <tr>

          {{ $test->first_name }}<br>
          {{ $test->last_name }}<br>
          {{ $test->ic }}<br>
          {{ $test->email }}<br>
          {{ $test->phoneno }}<br>

          {{-- @foreach ($a as $studid => $aval)
            @foreach ($cdp as $studid2 => $cdpval)
              @foreach ($cdpval as $detail => $cdval)
                @if ( $cdval->stud_id == $studid2->stud_id)
                  {{ $detail->first_name }} {{ $detail->last_name }}<br>
                  {{ $detail->ic }}<br>
                  {{ $detail->email }}<br>
                  {{ $detail->phoneno }}<br>
                @endif

              @endforeach
            @endforeach
          @endforeach --}}
                  
          
          {{-- @foreach ($student as $key => $data)
          @foreach ($payment as $keyd => $datas)
          @if ($data->stud_id == $datas->stud_id)
            <td>
              {{ $data->id }}
            </td>
            <td>
              {{ $data->first_name }}
            </td>
            <td>
              {{ $data->email }}
            </td>
            <td>
              {{ $data->ic }}
            </td>
            <td>
              {{-- <a class="btn btn-dark" href="{{ url('classdata') }}/{{ $data->id }}"><i class="bi bi-chevron-right"></i></a>
              <a class="btn btn-warning"  href="{{ url('updateclass') }}/{{ $data->id }}"><i class="bi bi-pencil-square"></i></a> --}}
{{--                 
            </td>  
          @endif
          @endforeach
          @endforeach --}} 
                    </tr>  

      </tbody>
    </table>
    {{-- {{ $student->links() }} --}}
  </div>
</div>

@endsection