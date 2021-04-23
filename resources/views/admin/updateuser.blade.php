@extends('layouts.app')

@section('title')
    User Information
@endsection

@include('layouts.navbar')

@section('content')
@include('layouts.sidebar')
<div class="row py-4">     
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

        <div class="card-header" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
            <a href="/manageuser"><i class="fas fa-arrow-left"></i></a> &nbsp; <a href="/dashboard">Dashboard</a> / <a href="/manageuser">Manage User</a> / <b>User Information</b>
        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">User Information</h1>
        </div>

        <form method="POST" action="{{ url('updateuser') }}/{{ $users->user_id }}">
            @csrf
            <div class="row pt-3" style="padding-left: 8%">
                
                <div class='col-md-8'>
                    @foreach ($roles as $role)
                    @if ($users->role_id == $role->role_id)
                    <div class="form-group">
                        <label for="role"><b>Current Role</b></label>
                        <input type="text" class="form-control" name="name" value="{{ $role->name }}" disabled>
                    </div>   
                    @endif 
                    @endforeach  
                </div>

                <div class='col-md-8'>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $users->name }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class='col-md-8'>
                    <div class="form-group">
                        <label for="email" >E-Mail Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $users->email }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">                    
                    <div style="width:387px">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ $users->password }}" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div style="width:387px">
                        <div class="form-group">
                            <label for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ $users->password }}" required autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <div class='col-md-8'>
                    <label for="name">Change Role</label>
                    <br>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            @foreach ($roles as $role)
                            <input type="radio" class="form-check-input" name="optradio[]" value="{{ $role->role_id  }}">{{ $role->name  }} &nbsp;&nbsp;
                            @endforeach
                        </label>
                    </div>
                </div>

                <div class='col-md-8 pt-3'>
                    <button type="submit" class="btn btn-primary float-right">
                        Update
                    </button>
                </div>
            </div>
        </form>
        
    </main>
</div>
@endsection