<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Enzo admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Enzo admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ url('/html/assets/images/logo/logo.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ url('/html/assets/images/logo/logo.png') }}" type="image/x-icon">
    <title>TBS | Master Siswa</title>
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
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ url('/html/assets/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ url('/html/assets/css/responsive.css') }}">

    <style>
        body {
            background-image: linear-gradient(to bottom, #4D6FCB, #162C65);
        }
    </style>
</head>

<body>
    <div class="loader-wrapper">
        <div class="loader"></div>
    </div>

    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card">
                    <div>
                        <div class="login-main">
                            <form action="{{ route('login.store') }}" method="POST" class="theme-form">
                                @csrf

                                <div class="mb-5 text-center">
                                    <img class="img-fluid for-light mb-3" style="max-width: 120px;" src="{{ url('/html/assets/images/logo/logo2.png') }}" alt="loginpage">
                                    <h5>MTS NU TBS</h5>
                                </div>


                                <div class="form-group">
                                    <input class="form-control" name="username" value="{{ old('username') }}" type="text" required placeholder="Masukkan Username">
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="password" required placeholder="Password">
                                        <div class="show-hide"><span class="show"></span></div>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block w-100 mt-3" type="submit">Login</button>
                                </div>
                                <div class="form-group">
                                    <p class="text-center">Copyright &copy; TBS 2024</p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ url('/html/assets/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ url('/html/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ url('/html/assets/js/icons/feather-icon/feather.min.js') }}"></script>
        <script src="{{ url('/html/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
        <script src="{{ url('/html/assets/js/config.js') }}"></script>
        <script src="{{ url('/html/assets/js/script.js') }}"></script>

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
                Toast.fire({
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
                Toast.fire({
                    icon: "error",
                    title: "Gagal",
                    text: "{{ Session::get('ERROR') }}"
                })
                @php
                    Session::forget('ERROR');
                @endphp
            @endif
        </script>
    </div>

</body>

</html>
