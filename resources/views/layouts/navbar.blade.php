@if(Auth::user()->user_id == 'UID002' || Auth::user()->user_id == 'UID003' || Auth::user()->user_id == 'UID004')
@else
<nav class="navbar navbar-expand-lg navbar-light sticky-top px-5" style="background-color: #ffffff; padding-top:1%; padding-bottom:1%; box-shadow: 0 0px 30px 0 rgba(0, 0, 0, 0.2);">
        <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="site-logo-inner" href="#">
            <img src="{{ asset('assets/images/logo.png') }}" class="custom-logo" width="80" alt="">
        </a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
        </div>
</nav>
@endif

<nav class="navbar navbar-expand-lg navbar-light sticky-top px-5" style="background-color: #ffffff; padding-top:1%; padding-bottom:1%; box-shadow: 0 0px 30px 0 rgba(0, 0, 0, 0.2);">
    <a class="site-logo-inner" href="#">
        <img src="{{ asset('assets/images/logo.png') }}" class="custom-logo" width="80" alt="">
    </a>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="padding-left:2%;">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/">User <span class="sr-only">(current)</span></a>
          </li>
      </ul>
    </div>

    <!-- Right Side Of Navbar -->
    <ul class="nav navbar-nav justify-content-end">
        <!-- Authentication Links -->
        @if (Auth::guest())
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            <!--<li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>-->
        @else
            <li class="dropdown">
                <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                    <i class="fas fa-user"></i> <span class="caret"></span>
                </a>

                <ul class="dropdown-menu dropdown-menu-right" role="menu">  
                    <li class="nav-item">
                      <a class="dropdown-item" href="/dashboard"><i class="fas fa-home pr-3"></i> Dashboard</a>
                    </li>
                    {{-- <li class="nav-item">
                        {{-- <a class="dropdown-item" href="/manageprofile"><i class="fas fa-address-card pr-3"></i> Manage Profile</a> 
                        <!-- Button trigger modal -->
                        <a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#passwordModal"><i class="fas fa-address-card pr-3"></i> Change Password</a>
                    </li> --}}
                    <div class="dropdown-divider"></div>
                    <li class="nav-item">
                        <a class="dropdown-item" href="/logout"
                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                           <i class="fas fa-sign-out-alt pr-3"></i> Logout
                        </a>

                        <form id="logout-form" action="/logout" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</nav>

<!-- Modal -->
{{-- <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" action="{{ url('updateprofile') }}/{{ Auth::user()->user_id }}">
        @csrf
            <div class="modal-body">

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ Auth::user()->password }}" required autocomplete="new-password">
        
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ Auth::user()->password }}" required autocomplete="new-password">
                </div>
                      
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
    </div>
</div> --}}

