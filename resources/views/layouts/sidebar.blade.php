<aside class="aside-admin px-2" id="aside-admin">
    <div class="aside-logo bg-white pt-2 px-1 pb-0 rad text-center shadow-warning mt-3">
        <div class="d-inline-block">
            <img src="{{ asset('img/fav.png') }}" class="img-logo-aside d-inline-block mb-2" width="40px" height="40px" alt="">
            <div class="label-menu d-none">
                <h6 class="mb-0">SMKNUSA</h6>
                <p class="mb-0" style="font-size: .85rem !important;">Admin Panel</p>
            </div>
        </div>
    </div>
    <div class="menu-aside px-2 w-100 text-center mt-5">
        <div class="my-2 {{ ($menu_active ==="dashboard") ? 'menu-active' : '' }} my-2 px-3" onclick="window.location.href='{{ route('dashboard') }}';">
            <i class="fas fa-tachometer-alt"></i>
            <h6 class="label-menu d-none">Dashboard</h6>
        </div>
        <div class="my-2 my-2 px-3" href="#">
            <i class="fas fa-bullhorn"></i>
            <h6 class="label-menu d-none">Pengumuman</h6>
        </div>
        <div class="my-2 my-2 px-3" href="#">
            <i class="fas fa-calendar-alt mr-1"></i>
            <h6 class="label-menu d-none">Agenda</h6>
        </div>
        <div class="my-2 my-2 px-3" href="#">
            <i class="fas fa-newspaper"></i>
            <h6 class="label-menu d-none">Berita</h6>
        </div>
        <div class="my-2 my-2 px-3" href="#">
            <i class="fas fa-book mr-1"></i>
            <h6 class="label-menu d-none">Artikel</h6>
        </div>
        <div class="my-2 my-2 px-3" href="#">
            <i class="fas fa-images"></i>
            <h6 class="label-menu d-none">Galeri</h6>
        </div>
        <div class="my-2 my-2 px-3" href="#">
            <i class="fas fa-school"></i>
            <h6 class="label-menu d-none">Profil Sekolah</h6>
        </div>
        <div class="my-2 my-2 px-3" href="#">
            <i class="fas fa-link"></i>
            <h6 class="label-menu d-none">Links</h6>
        </div>

    </div>
    <div class="w-100 bg-white exit-menu" style="left: 0;">
        <a class="a-dark-default bg-white" href="#">
            <div class="text-center">
                <div class="">
                    <i class="fas fa-door-open"></i>
                    <h6 class="label-menu d-none">Keluar</h6>
                </div>
            </div>
        </a>
    </div>
</aside>

<div id="toggler" class="bg-light" style="z-index: 500;">
    <div class="toggler-nav-small bg-light text-warning text-center" id="toggler-icon">
        <i id="icon-toggler" class="fas fa-bars position-relative" style="top: 6px; left: -1px;"></i>
    </div>
    <div class="toggler-nav-small"></div>
    <div class="toggler-nav-small"></div>    
</div>
<div class="container mt-3" id="label-small">
    <div class="row">
        <div class="col-md-8 offset-md-2 text-center">
            <h4 class="poppins mb-0">SMKNUSA</h4>
            <p class="montserrat">Admin Panel</p>
        </div>
    </div>
</div>
<div class="position-fixed w-100 h-100 overlay-black-admin d-none" style="z-index: 100; top: 0;"></div>

<script>
    $(document).ready(function() {
        var ww = $(window).width();
        if(ww >= 767) {
            $('.aside-admin').mouseover(function() {
                $('.label-menu').removeClass('d-none').addClass('d-inline-block')
                $('.menu-aside').removeClass('text-center').addClass('text-left')
                $('.img-logo-aside').addClass('top-img').removeClass('mb-2')
                $('.overlay-black-admin').removeClass('d-none')
            });
            $('.aside-admin').mouseleave(function() {
                $('.label-menu').addClass('d-none').removeClass('d-inline-block')
                $('.menu-aside').addClass('text-center').removeClass('text-left')
                $('.img-logo-aside').removeClass('top-img').addClass('mb-2')
                $('.overlay-black-admin').addClass('d-none')
            });
        } else {
            $('#toggler').click(function() {
                $('#aside-admin').toggleClass('aside-admin-show');
                if($('#aside-admin').hasClass('aside-admin-show')) {
                    $('.overlay-black-admin').removeClass('d-none')
                    $('#icon-toggler').removeClass('fa-bars').addClass('fa-times')
                    $('.aside-admin').mouseover(function() {
                        $('.label-menu').removeClass('d-none').addClass('d-inline-block')
                        $('.menu-aside').removeClass('text-center').addClass('text-left')
                        $('.img-logo-aside').addClass('top-img').removeClass('mb-2')
                    });
                    $('.aside-admin').mouseleave(function() {
                        $('.label-menu').addClass('d-none').removeClass('d-inline-block')
                        $('.menu-aside').addClass('text-center').removeClass('text-left')
                        $('.img-logo-aside').removeClass('top-img').addClass('mb-2')
                    });
                } else {
                    $('.overlay-black-admin').addClass('d-none')
                    $('#icon-toggler').removeClass('fa-times').addClass('fa-bars')

                }
            })
        }
    })
</script>
