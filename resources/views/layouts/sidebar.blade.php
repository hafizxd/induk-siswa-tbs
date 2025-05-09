<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            {{-- <h4 style="color: white; margin: 0; padding: 0;">Buku Induk Siswa</h4> --}}
            <a href="{{ route('students.index') }}" class="d-flex gap-2">
                <img class="img-fluid for-light" style="max-width: 40px;" src="{{ url('/html/assets/images/logo/logo.png') }}" alt="">
                <h4 style="margin-top: 10px; color: white;">MTs NU TBS</h4>
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            {{-- <div class="toggle-sidebar"><i class="fa fa-cog status_toggle middle sidebar-toggle"> </i></div> --}}
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('students.index') }}"><img class="img-fluid" src="{{ url('/html/assets/images/logo/logo-icon1.png') }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="{{ route('students.index') }}"><img class="img-fluid" src="{{ url('/html/assets/images/logo/logo-icon.png') }}" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li class="menu-box">
                        <ul>
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('students.index') }}"><i data-feather="users"> </i><span>Siswa</span></a>
                            </li>
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('grades.index', 'RAPOR') }}"><i data-feather="book-open"> </i><span>Nilai</span></a>
                            </li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="book"></i><span>Master Data</span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('subjects.index', 'RAPOR') }}">Mata Pelajaran</a></li>
                                    <li><a href="{{ route('curriculums.index') }}">Kurikulum</a></li>
                                    <li><a href="{{ route('periods.index') }}">Periode Pembelajaran</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="folder-plus"></i><span>Import</span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('import.students.index') }}">Import Siswa</a></li>
                                    <li><a href="{{ route('import.grades.index') }}">Import Nilai</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('admins.index') }}"><i data-feather="user"> </i><span>Admin</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
