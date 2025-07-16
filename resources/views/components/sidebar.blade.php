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
                  <p>Orders</p>
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
              <a href="{{route('creditchart')}}">
                  <i class="fas fa-receipt"></i>
                  <p>Credits Chart</p>
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
@php
    $pendingAssignedCount = 0;

    if (auth()->check() && auth()->user()->role === 'admin') {
        $pendingAssignedCount = \App\Models\Orders::where('assigned_to', auth()->id())
                                ->where('status', 'Pending')
                                ->count();
    }
@endphp

@if(Auth::user()->role === 'admin')
    <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
        </a>
    </li>

    <li class="nav-item relative">
        <a href="{{ route('admin.orders') }}" class="flex items-center space-x-1">
            <i class="fas fa-box"></i>
            <p>Orders</p>

            @if($pendingAssignedCount > 0)
                <span
                    class=" h-5 w-5
                           flex items-center justify-center rounded-full
                           bg-red-600 text-white text-xs font-bold">
                    {{ $pendingAssignedCount }}
                </span>
            @endif
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.enquires') }}">
            <i class="fas fa-box"></i>
            <p>Enquires</p>
        </a>
    </li>
    <li class="nav-item">
              <a href="{{route('creditchart')}}">
                  <i class="fas fa-receipt"></i>
                  <p>Credits Chart</p>
              </a>
          </li>
@endif


            {{-- Admin Menu  --}}
            @if(Auth::user()->role === 'qualitychecker')
            <li class="nav-item">
                <a href="{{ route('qc.dashboard') }}">
                    <i class="fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('qc.orders') }}">
                    <i class="fas fa-box"></i>
                    <p>Orders</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('qc.lists')}}">
                    <i class="fas fa-clipboard-check"></i>
                    <p>QC List</p>
                </a>
            </li>
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
              <a href="{{route('superadmin.transactions')}}">
                  <i class="fas fa-chart-bar"></i>
                  <p>Transactions</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{route('creditchart')}}">
                  <i class="fas fa-receipt"></i>
                  <p>Credits Chart</p>
              </a>
          </li>
      @endif
  </ul>
  

   </div>
   </div>


</div>
      <!-- End Sidebar -->