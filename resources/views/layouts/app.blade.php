<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="TBS">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ url('/html/assets/images/logo/logo.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ url('/html/assets/images/logo/logo.png') }}" type="image/x-icon">
    <title>TBS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/icofont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/themify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/flag-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/chartist.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ url('/html/assets/css/color-1.css" media="screen') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/calendar.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/datatables.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-2.1.6/fc-5.0.1/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/date-picker.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" href="{{ url('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ url('https://unpkg.com/leaflet@1.8.0/dist/leaflet.css') }}" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <script src="{{ url('https://unpkg.com/leaflet@1.8.0/dist/leaflet.js') }}" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
    {{-- <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css"> --}}

    <link rel="stylesheet" href="{{ url('/css/style.css') }}">

    @stack('style')
</head>

<body>
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <div class="loader-wrapper">
        <div class="loader"></div>
    </div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <div class="page-header">
            <div class="header-wrapper row m-0">
                <form class="form-inline search-full col" action="#" method="get">
                    <div class="form-group w-100">
                        <div class="Typeahead Typeahead--twitterUsers">
                            <div class="u-posRelative">
                                <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search In Enzo .." name="q" title="" autofocus>
                                <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
                            </div>
                            <div class="Typeahead-menu"></div>
                        </div>
                    </div>
                </form>
                <div class="col-auto p-0">
                    <a href="{{ route('students.index') }}" class="d-flex gap-2">
                        <img class="img-fluid for-light" style="max-width: 40px;" src="{{ url('/html/assets/images/logo/logo.png') }}" alt="">
                        <h4 style="margin-top: 10px;">MTs NU TBS</h4>
                    </a>
                </div>

                <div class="nav-right col-8 pull-right right-header p-0">
                    <ul class="nav-menus">
                        <li class="profile-nav onhover-dropdown me-0 p-0">
                            <div class="d-flex profile-media">
                                <img class="b-r-50" style="width: 40px; height: 40px;" src="{{ url('/html/assets/images/dashboard/profile.jpg') }}" alt="">
                                <div class="flex-grow-1"><span>{{ auth()->user()->name }}</span>
                                    <p class="font-roboto mb-0">{{ auth()->user()->name }} <i class="middle fa fa-angle-down"></i></p>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="#" onclick="document.querySelector('#logoutForm').submit();"><i data-feather="log-out"> </i><span>Log Out</span></a></li>
                                <form id="logoutForm" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                    </ul>
                </div>
                <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">                        
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName"></div>
            </div>
            </div>
          </script>
                <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
            </div>
        </div>
        <div class="page-body-wrapper">


            @include('layouts.sidebar')


            <div class="page-body">
                <div class="container-fluid default-dash">
                    @yield('content')
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 footer-left p-0">
                            <p class="mb-0">Copyright © TBS 2024</p>
                        </div>

                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ url('/html/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ url('/html/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('/html/assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ url('/html/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <script src="{{ url('/html/assets/js/scrollbar/simplebar.js') }}"></script>
    <script src="{{ url('/html/assets/js/scrollbar/custom.js') }}"></script>
    <script src="{{ url('/html/assets/js/config.js') }}"></script>
    <script src="{{ url('/html/assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ url('/html/assets/js/chart/chartist/chartist.js') }}"></script>
    <script src="{{ url('/html/assets/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>
    {{-- <script src="{{ url('/html/assets/js/chart/knob/knob.min.js') }}"></script>
    <script src="{{ url('/html/assets/js/chart/knob/knob-chart.js') }}"></script> --}}
    {{-- <script src="{{ url('/html/assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ url('/html/assets/js/chart/apex-chart/stock-prices.js') }}"></script> --}}
    {{-- <script src="{{ url('/html/assets/js/prism/prism.min.js') }}"></script> --}}
    {{-- <script src="{{ url('/html/assets/js/clipboard/clipboard.min.js') }}"></script> --}}
    {{-- <script src="{{ url('/html/assets/js/custom-card/custom-card.js') }}"></script> --}}
    {{-- <script src="{{ url('/html/assets/js/notify/bootstrap-notify.min.js') }}"></script> --}}
    <script src="{{ url('/html/assets/js/dashboard/default.js') }}"></script>
    <script src="{{ url('/html/assets/js/notify/index.js') }}"></script>
    <script src="{{ url('/html/assets/js/slick-slider/slick.min.js') }}"></script>
    <script src="{{ url('/html/assets/js/slick-slider/slick-theme.js') }}"></script>
    <script src="{{ url('/html/assets/js/typeahead/handlebars.js') }}"></script>
    <script src="{{ url('/html/assets/js/typeahead/typeahead.bundle.js') }}"></script>
    <script src="{{ url('/html/assets/js/typeahead/typeahead.custom.js') }}"></script>
    <script src="{{ url('/html/assets/js/typeahead-search/handlebars.js') }}"></script>
    <script src="{{ url('/html/assets/js/typeahead-search/typeahead-custom.js') }}"></script>
    <script src="{{ url('/html/assets/js/script.js') }}"></script>
    <script src="{{ url('/html/assets/js/theme-customizer/customizer.js') }}"></script>
    {{-- <script src="{{ url('/html/assets/js/calendar/fullcalendar.min.js') }}"></script> --}}
    {{-- <script src="{{ url('/html/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('/html/assets/js/datatable/datatables/datatable.custom.js') }}"></script> --}}
    <script src="{{ url('/html/assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ url('/html/assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ url('/html/assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{ url('/html/assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
    <script src="{{ url('https://cdn.jsdelivr.net/npm/flatpickr') }}"></script>
    <script src="{{ url('accounting.min.js') }}"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.6/fc-5.0.1/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        $(function() {
            $('form').on('submit', function() {
                $(':input[type="submit"]').prop('disabled', true);
            })
        })
        $(function() {
            $('.selectpicker').select2({
                placeholder: '-- Pilih --',
                allowClear: true
            });
        });
    </script>
    <script>
        config = {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
        }

        flatpickr("input[type=datetime-local]", config)
        flatpickr("input[type=datetime]", {})
    </script>
    

    <script type="module" src="{{ url('/js/script.js') }}"></script>

    {{-- sweet alert --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>
    <script>
        const Swal2 = Swal.mixin({
            customClass: {
                input: 'form-control'
            }
        })

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        @if ($errors->any())
            Swal2.fire({
                icon: "error",
                title: "Validasi Gagal",
                text: "Periksa pesan error pada isian",
            })
        @endif

        @if (Session::has('SUCCESS'))
            Toast.fire({
                icon: "success",
                title: "Berhasil",
                text: "{{ Session::get('SUCCESS') }}"
            })
            @php
                Session::forget('SUCCESS');
            @endphp
        @endif

        @if (Session::has('INFO'))
            Toast.fire({
                icon: "info",
                title: "Informasi",
                text: "{{ Session::get('INFO') }}"
            })
            @php
                Session::forget('INFO');
            @endphp
        @endif

        @if (Session::has('ERROR'))
            Swal2.fire({
                icon: "error",
                title: "Gagal",
                text: "{{ Session::get('ERROR') }}"
            })
            @php
                Session::forget('ERROR');
            @endphp
        @endif
    </script>

    @stack('script')


</body>

</html>
