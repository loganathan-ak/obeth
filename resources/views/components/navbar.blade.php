<div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="/" class="logo">
                <img
                  src=""
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
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
          <!-- Navbar Header -->
       <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
            <div class="container-fluid">
              

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                {{-- <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Search ..."
                          class="form-control"
                        />
                      </div>
                    </form>
                  </ul>
                </li> --}}


                <div class="card-action me-4">
                  @if (auth()->check() && auth()->user()->role === 'subscriber') 
                    <!--<a href="{{route('plans')}}"><button class="btn btn-success me-3">Buy Plan</button></a>-->
                  @endif
                   <a href="#" class="hidden"><button class="btn btn-danger me-3">Art Gallery</button></a>
                </div>


                @php
                    use App\Models\Notifications;

                    $notifications = [];

                    if (auth()->check()) {
                        $user = auth()->user();
                        $query = Notifications::where('created_at', '>=', now()->subDay())->latest();

                        if ($user->role === 'subscriber') {
                            $notifications = $query->where('client_id', $user->id)->get();
                        } elseif ($user->role === 'admin') {
                            $notifications = $query->where('designer_id', $user->id)->get();
                        } elseif ($user->role === 'superadmin') {
                            $notifications = $query->where('superadmin_id', $user->id)->get();
                        }
                    }
                @endphp

                <li class="nav-item topbar-icon dropdown hidden-caret me-3">
                  <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-bell"></i>
                      <span class="notification">{{ count($notifications) }}</span>
                  </a>
                  <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                      <li>
                          <div class="notif-scroll scrollbar-outer">
                              <div class="notif-center">
                                  @forelse ($notifications as $notification)
                                      <a href="#">
                                          <div class="notif-icon notif-primary">
                                              <i class="fa fa-bell"></i>
                                          </div>
                                          <div class="notif-content">
                                              <span class="block">{{ $notification->message }}</span>
                                              <span class="time">{{ $notification->created_at->diffForHumans() }}</span>
                                          </div>
                                      </a>
                                  @empty
                                      <div class="text-center text-muted p-3">No notifications</div>
                                  @endforelse
                              </div>
                          </div>
                      </li>
                  </ul>
                </li>

                

                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >

                  @php
                      $imagepath = 'user.png'; // fallback image

                      if (auth()->check()) {
                          switch (auth()->user()->role) {
                              case 'subscriber':
                                  $imagepath = 'blue-user.png';
                                  break;
                              case 'admin':
                                  $imagepath = 'green-user.png';
                                  break;
                              case 'superadmin':
                                  $imagepath = 'yellow-user.png';
                                  break;
                          }
                      }
                  @endphp

                  <img src="{{ asset($imagepath) }}" alt="User Role Image" class="h-8 w-8 rounded-full"  />

                  <!--<span class="text-white text-sm">{{ Auth::user()->first_name }}</span>-->
                    <span class="profile-username">
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold">{{Auth::user()->first_name}}</span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <a class="dropdown-item" href="{{route('profile')}}">Account Setting</a>
                        <div class="dropdown-divider"></div>
                    
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-left w-full bg-transparent border-none px-3 m-0 cursor-pointer">
                                Logout
                            </button>
                        </form>
                    </li>
                    
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
       </nav>
          <!-- End Navbar -->
</div>

