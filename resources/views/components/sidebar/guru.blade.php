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

                <li class="pc-item pc-caption">
                <label>Data Akademik</label>
                <i class="ti ti-news"></i>
                </li>
                <li class="pc-item">
                <a href="{{ route('absensi.index') }}" class="pc-link">
                    <span class="pc-micon"><i class="feather icon-check-square"></i></span>
                    <span class="pc-mtext">Absensi</span>
                </a>
                </li>
                <li class="pc-item">
                <a href="{{ route('nilai.index') }}" class="pc-link">
                    <span class="pc-micon"><i class="feather icon-bar-chart-2"></i></span>
                    <span class="pc-mtext">Nilai</span>
                </a>
                </li>
                
                <li class="pc-item">
                <a href="{{ route('pengumuman_akademik.index') }}" class="pc-link">
                    <span class="pc-micon"><i class="feather icon-bell"></i></span>
                    <span class="pc-mtext">Pengumuman Akademik</span>
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