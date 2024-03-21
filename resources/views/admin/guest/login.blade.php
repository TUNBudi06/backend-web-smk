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
    <link rel="icon" type="image/x-icon" class="rounded-circle" href="{{ asset('favicon.ico') }}" />
    <title>Login Admin</title>
</head>
<body>
    <div class="container my-5 py-5">
        <div class="w-100 bg-white shadow rad mt-5 p-2">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('img/smk.png') }}" class="w-100" style="border-radius: 10px;" alt="">
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-10 px-0 offset-1 py-3">
                            <div class="brand text-center">
                                <img src="{{ asset('img/fav.png') }}" class="mb-3 d-inline-block" width="40px" alt="">
                                <h2 class="d-inline-block montserrat">Login</h2>
                            </div>
                            <form action="{{ route('dashboard') }}" method="">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="input-group">
                                        <input required type="email" name="email" id="email" class="form-control border-right-0" placeholder="Email" aria-describedby="emailMsg">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white border-left-0"><i class="fas text-warning fa-envelope"></i></span>
                                        </div>
                                    </div>
                                    <small id="emailMsg" class="text-muted d-none">isikan email</small>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <input required type="password" name="password" id="password" class="form-control border-right-0" placeholder="password" aria-describedby="passwordMsg">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white border-left-0" id="toggler-password"><i id="icon-eye" class="fas fa-eye"></i></span>
                                        </div>
                                    </div>
                                    <small id="passwordMsg" class="text-muted d-none">isikan password</small>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="checkbox" name="cookie" id="cookie">
                                        <label for="cookie">Remember me</label>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-right">
                                            <button class="btn btn-warning shadow-warning px-5"><i class="fas fa-door-open"></i> Masuk</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
<script>
    $(document).ready(function() {
        var password = document.getElementById('password');
        $('#toggler-password').click(function() {
            if(password.type == "password") {
                password.type = "text"
                $('#icon-eye').addClass('text-warning')
            } else {
                password.type = "password"
                $('#icon-eye').removeClass('text-warning')
            }
        });
    });
</script>
</html>