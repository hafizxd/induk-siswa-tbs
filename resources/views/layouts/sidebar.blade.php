<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <h4 style="color: white; margin: 0; padding: 0;">Buku Induk Siswa</h4>
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
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('grades.index') }}"><i data-feather="book"> </i><span>Nilai</span></a>
                            </li>
                            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="folder-plus"></i><span>Import</span></a>
                                <ul class="sidebar-submenu">
                                    <li><a href="{{ route('import.index') }}">Import Tambah</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
