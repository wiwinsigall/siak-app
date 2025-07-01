<div>
  <header class="pc-header">
    <div class="header-wrapper d-flex justify-content-between align-items-center px-3">
      <!-- Sidebar Toggle -->
      <div class="pc-mob-drp d-flex align-items-center">
        <ul class="list-unstyled d-flex mb-0">
          <li class="pc-h-item pc-sidebar-collapse me-2">
            <a href="#" class="pc-head-link" id="sidebar-hide" title="Toggle Sidebar">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
        </ul>
      </div>

      <!-- User Profile -->
      <div class="ms-auto">
        <ul class="list-unstyled mb-0 d-flex align-items-center">
          <li class="dropdown pc-h-item header-user-profile">
            <a class="pc-head-link dropdown-toggle arrow-none d-flex align-items-center" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <img src="{{ asset('template/dist') }}/assets/images/user/avatar-2.jpg" alt="user-avatar" class="user-avtar me-2">
              <span>{{ auth()->user()->nama }}</span>
            </a>

            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
              <div class="dropdown-header d-flex align-items-center px-3 py-2">
                <img src="{{ asset('template/dist') }}/assets/images/user/avatar-2.jpg" alt="user-avatar" class="user-avtar wid-35 me-2">
                <h6 class="mb-0">{{ auth()->user()->nama }}</h6>
              </div>

              <div class="dropdown-divider my-1"></div>

              <a href="{{ route('profile') }}" class="dropdown-item d-flex align-items-center">
                <i class="ti ti-user me-2"></i>
                <span>View Profile</span>
              </a>
              <a href="#" class="dropdown-item d-flex align-items-center text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="ti ti-power me-2 text-danger"></i>
                <span>Logout</span>
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </header>
</div>
