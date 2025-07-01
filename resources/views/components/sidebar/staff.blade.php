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
                <label>Data Master</label>
                <i class="feather icon-box"></i>
                </li>
                <li class="pc-item">
                <a href="{{ route('guru.index') }}" class="pc-link">
                    <span class="pc-micon"><i class="feather icon-users"></i></span>
                    <span class="pc-mtext">Data Guru</span>
                </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('siswa.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="feather icon-users"></i></span>
                        <span class="pc-mtext">Data Siswa</span>
                    </a>
                </li>
                <li class="pc-item">
                <a href="{{ route('tahun_ajaran.index') }}" class="pc-link">
                    <span class="pc-micon"><i class="feather icon-layers"></i></span>
                    <span class="pc-mtext">Kelas</span>
                </a>
                </li>

                <li class="pc-item">
                <a href="{{  route('mata_pelajaran.index') }}" class="pc-link">
                    <span class="pc-micon"><i class="feather icon-book"></i></span>
                    <span class="pc-mtext">Mata Pelajaran</span>
                </a>
                </li>

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
                <label>Riwayat</label>
                <i class="ti ti-news"></i>
                </li>
                <li class="pc-item">
                    <a href="{{ route('riwayat.siswa') }}" class="pc-link">
                        <span class="pc-micon"><i class="feather icon-clock"></i></span>
                        <span class="pc-mtext">Riwayat Siswa</span>
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
                </li>
                <li class="pc-item">
                <a href="{{ route('users.index') }}" class="pc-link">
                    <span class="pc-micon"><i class="feather icon-users"></i></span>
                    <span class="pc-mtext">User Management</span>
                </a>
                </li>
                
                
            </ul>
            </div>
        </div>
    </nav>
</div>