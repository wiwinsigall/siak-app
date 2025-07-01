<div>
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <img src="{{ asset('template/dist') }}/assets/images/logo_smk.png" height="25" alt="logo">
                <div>
                    <a href="javascript:void(0)" class="simple-text logo-normal" 
                    style="font-size: 18px; font-weight: bold; color: #007bff; margin-left: 0.3cm;">
                    SMKN 1 MEMPURA
                    </a>
                </div>
            </a>
            </div>
            <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">
                <a href="{{ route('dashboard.staff') }}" class="pc-link">
                    <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                    <span class="pc-mtext">Dashboard</span>
                </a>
                </li>

                <li class="pc-item pc-caption">
                <label>Other</label>
                <i class="ti ti-brand-chrome"></i>
                </li>

                <li class="pc-item">
                <a href="{{ route('profile') }}" class="pc-link">
                    <span class="pc-micon"><i class="feather icon-user"></i></span>
                    <span class="pc-mtext">User Profile</span>
                </a>
                
            </ul>
            </div>
        </div>
    </nav>
</div>