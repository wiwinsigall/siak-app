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
            <li class="{{ Request::is('tables') ? 'active' : '' }}">
                <a href="./tables.html">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>Nilai Siswa</p>
                </a>
            </li>
            <li class="{{ Request::routeIs('absensi.index') ? 'active' : '' }}">
                <a href="{{ route('absensi.index') }}">
                    <i class="tim-icons icon-pencil"></i>
                    <p>Absensi Siswa</p>
                </a>
            </li>
            <li class="{{ Request::is('tables') ? 'active' : '' }}">
                <a href="./tables.html">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <p>Pengumuman Akademik</p>
                </a>
            </li>
            <li class="{{ Request::is('tables') ? 'active' : '' }}">
                <a href="./tables.html">
                    <i class="tim-icons icon-single-02"></i>
                    <p>User Profile</p>
                </a>
            </li>
        </ul>
    </div>
</div>
