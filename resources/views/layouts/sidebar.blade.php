<div class="col-md-12">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse px-2" style="padding-top: 5%">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column ">
          <div class="nav-link" style="color: #ABB2B9">Home</div>
          <li class="nav-item pb-3">
            <a class="nav-link text-white bg-dark " href="/dashboard">
              <span data-feather="home"></span>
              <i class="fas fa-home" style="margin-right: 25px"></i> Dashboard 
            </a>
          </li>

          @if(Auth::user()->role_id == 'ROD003' || Auth::user()->role_id == 'ROD004')
          @else
          <li class="nav-item pb-3">
          <div class="nav-link" style="color: #ABB2B9">Users</div>
            <a class="nav-link text-white bg-dark " href="/manageuser">
              <span data-feather="home"></span>
              <i class="fas fa-users" style="margin-right: 25px"></i> User Management 
            </a>
          </li>
          
          <div class="nav-link" style="color: #ABB2B9">Events</div>
          <li class="nav-item pb-3">
            <a class="nav-link text-white bg-dark " href="/product">
              <span data-feather="home"></span>
              <i class="fas fa-calendar" style="margin-right: 30px"></i> Event Management
            </a>            
          </li>  
          
          <div class="nav-link" style="color: #ABB2B9">Configuration</div>

          <li class="nav-item">
            <a class="nav-link text-white bg-dark " href="/viewstudents">
              <span data-feather="home"></span>
              <i class="fas fa-user-tie" style="margin-right: 29px"></i> Customer 
            </a>            
          </li>

          <li class="nav-item">
            <a class="nav-link text-white bg-dark " href="/database-management">
              <span data-feather="home"></span>
              <i class="fas fa-database" style="margin-right: 29px"></i> Database Management
            </a>            
          </li>

          <li class="nav-item pb-3">
            <a class="nav-link text-white bg-dark " href="/emailblast">
              <span data-feather="home"></span>
              <i class="fas fa-mail-bulk" style="margin-right: 25px"></i> Email Blasting
            </a>            
          </li>        
          @endif
          
          <div class="nav-link" style="color: #ABB2B9">Sales Tracking</div>
          <li class="nav-item pb-3">
            <a class="nav-link text-white bg-dark " href="/trackprogram">
              <span data-feather="home"></span>
              <i class="fas fa-clipboard-list" style="margin-right: 25px"></i> Order History
            </a>            
          </li>
          {{-- <li class="nav-item"> 
            <a class="nav-link dropdown-toggle text-white bg-dark active" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-clipboard-list"  style="margin-right: 32px"></i> Order History
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="/trackcustomer">Track by Customer</a>
              <a class="dropdown-item" href="/trackprogram">Track by Event</a>
            </div>          
          </li> --}}

        </ul>
      </div>
    </nav>
</div>