<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <link href="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.1.8/af-2.7.0/b-3.1.2/b-colvis-3.1.2/b-html5-3.1.2/b-print-3.1.2/fc-5.0.3/fh-4.0.1/r-3.0.3/datatables.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.1.8/af-2.7.0/b-3.1.2/b-colvis-3.1.2/b-html5-3.1.2/b-print-3.1.2/fc-5.0.3/fh-4.0.1/r-3.0.3/datatables.min.js"></script>
    @if ($menu_active)
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endif

    @yield('title')
</head>
<body class="bg-light">

    @include('layouts.sidebar')

    <div class="container-fluid">
        @include('admin.partials.search')
        @yield('container')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
{{--    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>--}}
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/sharer.min.js') }}"></script>
    <script src="{{ asset('js/fontawesome.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/typeit.min.js') }}"></script>
    @if ($menu_active)
        <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('js/admin.js') }}"></script>
    @endif
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('script')
</body>
</html>
