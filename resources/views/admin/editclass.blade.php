@extends('layouts.app')

@section('title')
    Package
@endsection


@section('content')

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
        
          @foreach ($name as $key => $data)
          <tr>
            <td>
              {{ $data->id }}
            </td>
            <td>
              {{ $data->name }}
            </td>
            <td>
              {{ $data->description }}
            </td>
            <td>
              {{ $data->classification }}
            </td>
            <td>
              <a class="btn btn-dark"><i class="bi bi-chevron-right"></i></a>
              <a class="btn btn-outline-warning" href="{{ url('updateclass') }}"><i class="bi bi-pencil-square"></i></a>
            </td>  
          </tr>  
          @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection