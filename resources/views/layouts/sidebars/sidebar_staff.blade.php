<div class="sidebar" style="position: fixed; top: -65px; left: 0; height: 100vh; z-index: 1030; overflow-y: auto;">
    <div class="sidebar-wrapper">
        <div class="logo" style="display: flex; align-items: center; padding: 10px;">
            <img src="{{ asset('assets/bootstrap-auth/img/logo_smk.png') }}" alt="Logo SMK" style="width: 30px; height: auto; margin-right: 10px;">
            <div>
                <a href="javascript:void(0)" class="simple-text logo-normal">
                    <strong>SMKN 1 MEMPURA</strong>
                </a>
            </div>
        </div>
        <ul class="nav">
            <li class="{{ Request::routeIs('dashboard.index') ? 'active' : '' }}">
                <a href="{{ route('dashboard.staff') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="{{ Request::routeIs('guru.index') ? 'active' : '' }}">
                <a href="{{ route('guru.index') }}">
                    <i class="tim-icons icon-badge"></i>
                    <p>Data Guru</p>
                </a>
            </li>
            <li class="{{ Request::routeIs('siswa.index') ? 'active' : '' }}">
                <a href="{{ route('siswa.index') }}">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <p>Data Siswa</p>
                </a>
            </li>
            <li class="{{ Request::routeIs('kelas.index') ? 'active' : '' }}">
                <a href="{{ route('kelas.index') }}">
                    <i class="tim-icons icon-bank"></i>
                    <p>Kelas</p>
                </a>
            </li>
            <li class="{{ Request::routeIs('mata_pelajaran.index') ? 'active' : '' }}">
                <a href="{{  route('mata_pelajaran.index') }}">
                    <i class="tim-icons icon-book-bookmark"></i>
                    <p>Mata Pelajaran</p>
                </a>
            </li>
            <li class="{{ Request::routeIs('pengumuman_akademik.index') ? 'active' : '' }}">
                <a href="{{ route('pengumuman_akademik.index') }}">
                    <i class="tim-icons icon-volume-98"></i>
                    <p>Pengumuman Akademik</p>
                </a>
            </li>
            <li class="{{ Request::is('tables') ? 'active' : '' }}">
                <a href="./tables.html">
                    <i class="tim-icons icon-single-02"></i>
                    <p>User Profile</p>
                </a>
            </li>
            <li class="{{ Request::is('typography') ? 'active' : '' }}">
                <a href="./typography.html">
                    <i class="tim-icons icon-settings"></i>
                    <p>User Management</p>
                </a>
            </li>
        </ul>
    </div>
</div>
