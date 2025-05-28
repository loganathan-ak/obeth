      <!-- Sidebar -->
  <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
             <a href="#" class="logo">
                 <img
                 src="{{ asset('assets/img/obeth.webp') }}"
                   style="width: 160px; height: 50px; border-radius: 3px;"
                   alt="navbar brand"
                   class="navbar-brand"/>
             </a>

              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
               </button>
                <button class="btn btn-toggle sidenav-toggler">
                 <i class="gg-menu-left"></i>
                </button>
             </div>
               <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
               </button>
          </div>
          <!-- End Logo Header -->
        </div>


   <div class="sidebar-wrapper scrollbar scrollbar-inner">
   <div class="sidebar-content">
    <ul class="nav nav-secondary">
      {{-- Subscriber Menu --}}
      @if(Auth::user()->role === 'subscriber')
          <li class="nav-item">
              <a href="{{ route('subscribers.dashboard') }}">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ route('requests') }}">
                  <i class="fas fa-envelope-open-text"></i>
                  <p>Requests</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ route('brandprofile') }}">
                  <i class="fas fa-id-badge"></i>
                  <p>Brand Profiles</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ route('billing') }}">
                  <i class="fas fa-file-invoice"></i>
                  <p>Billing</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ route('usage') }}">
                  <i class="fas fa-chart-line"></i>
                  <p>Usage</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ route('helpcenter') }}">
                  <i class="fas fa-life-ring"></i>
                  <p>Help Center</p>
              </a>
          </li>
      @endif
  
      {{-- Admin Menu  --}}
         @if(Auth::user()->role === 'admin')
          <li class="nav-item">
              <a href="{{ route('admin.dashboard') }}">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ route('admin.orders') }}">
                  <i class="fas fa-box"></i>
                  <p>Orders</p>
              </a>
          </li>
          {{-- <li class="nav-item">
              <a href="#">
                  <i class="fas fa-comments"></i>
                  <p>Chats</p>
              </a>
          </li> --}}
      @endif
  
      {{-- Superadmin Menu --}}
      @if(Auth::user()->role === 'superadmin')
          <li class="nav-item">
              <a href="{{ route('superadmin.dashboard') }}">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{route('superadmin.orders')}}">
                  <i class="fas fa-box"></i>
                  <p>Orders</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{route('superadmin.subscribers')}}">
                  <i class="fas fa-users"></i>
                  <p>Subscribers</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{route('superadmin.admins')}}">
                  <i class="fas fa-user-shield"></i>
                  <p>Admins</p>
              </a>
          </li>
          <li class="nav-item">
            <a href="{{route('superadmin.enquires')}}">
                <i class="fas fa-folder-open"></i>
                <p>Enquires</p>
            </a>
        </li>
          <li class="nav-item">
              <a href="">
                  <i class="fas fa-chart-bar"></i>
                  <p>Reports</p>
              </a>
          </li>
      @endif
  </ul>
  

   </div>
   </div>


</div>
      <!-- End Sidebar -->