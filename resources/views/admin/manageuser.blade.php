@extends('layouts.app')

@section('title')
  Manage User
@endsection

@include('layouts.navbar')
@section('content')
@include('layouts.sidebar')
<div class="row py-4">    
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

      <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
        <a href="/dashboard"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <b>Manage User</b>
      </div>
      
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage User</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group">
            <a href="managerole" type="button" class="btn btn-sm btn-outline-primary"><i class="fas fa-users pr-3"></i> Manage Role</a>
            <a href="create" type="button" class="btn btn-sm btn-outline-secondary"><i class="fas fa-plus pr-1"></i> Add New User</a>
          </div>
        </div>
      </div>
      
      <div>              
          @if ($message = Session::get('success'))
          <div class="alert alert-success alert-block">
              <button type="button" class="close" data-bs-dismiss="alert">×</button>	
              <strong>{{ $message }}</strong>
          </div>
          @endif

          @if ($message = Session::get('updatesuccess'))
          <div class="alert alert-info alert-block">
              <button type="button" class="close" data-bs-dismiss="alert">×</button>	
              <strong>{{ $message }}</strong>
          </div>
          @endif
              
          @if ($message = Session::get('delete'))
          <div class="alert alert-danger alert-block">
              <button type="button" class="close" data-bs-dismiss="alert">×</button>	
              <strong>{{ $message }}</strong>
          </div>
          @endif

        <!-- Put content here-->
        <div class="float-right pt-3">{{$users->links()}}</div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th><i class="fas fa-cogs"></i></th>
                </tr>
            </thead>
            <tbody>
              @foreach ($users as $key => $user)
                @foreach ($roles as $role)
                  @if ($user->role_id == $role->role_id)
                  <tr>
                    <td>{{$users->firstItem() + $key }}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$role->name}}</td>
                    <td>
                      <a href="{{ url('update') }}/{{ $user->user_id }}" class="btn btn-dark"><i class="fas fa-eye"></i></a>
                      <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $user->user_id }}"><i class="fas fa-trash-alt"></i></button>
                      <!-- Modal -->
                      <div class="modal fade" id="exampleModal{{ $user->user_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Are you sure you want to delete this user ?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <a class="btn btn-danger" href="{{ url('deleteuser') }}/{{ $user->user_id }}">Delete</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>  
                  @endif
                @endforeach                  
              @endforeach
            </tbody>
        </table>
      </div>
    </main>
  </div>
</div>
@endsection

