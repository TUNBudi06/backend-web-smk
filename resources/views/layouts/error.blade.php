<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jssocials-theme-classic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jssocials-theme-flat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jssocials-theme-minima.css') }}">
    <link rel="icon" type="image/x-icon" class="rounded-circle" href="{{ asset('smkicon.ico') }}" />
    <title>Not found</title>
</head>
<body>
    <div class="row my-5">
        <div class="col-md-6 offset-md-3 text-center pt-5 mt-5">
            <img src="{{ asset('img/illust/404.svg') }}" class="w-50" alt="not found">
            <h3 class="poppins mt-3">Opps... Halaman tidak tersedia</h3>
            <p class="mt-2 mb-3 montserrat">Kami mohon maaf, Halaman yang diinginkan tidak ditemukan.</p>
            {{-- <button onclick="window.location.href='{{ route('dashboard', ['token' => $token]) }}';" class="btn btn-warning shadow-warning rounded-pill px-5"><i class="fas fa-home"></i> Kembali ke beranda</button> --}}
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/sharer.min.js') }}"></script>
    <script src="{{ asset('js/fontawesome.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/typeit.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>