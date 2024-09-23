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
    <title>Login Admin</title>
</head>
<body>
    <div class="container my-5 py-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="w-100 bg-white position-relative shadow rad mt-5 py-3 px-3">
                    @if(Session::get('tokenError'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>{{ Session::get('tokenError') }}</strong>
                    </div>
                    @endif
                    <form action="{{ route('first.token') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="token">Token admin</label>
                            <input type="text" required name="token" id="token" class="form-control" placeholder="XXXXXXXX" aria-describedby="token">
                            <small id="token" class="text-muted d-none">Token</small>
                        </div>
                        <div class="position-absolute text-center" id="button-submit-search">
                            <button type="submit" class="btn btn-warning shadow-warning rounded-pill px-5 py-2 montserrat">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
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