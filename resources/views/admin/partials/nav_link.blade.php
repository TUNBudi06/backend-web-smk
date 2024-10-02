<div class="menu-profile-admin mb-4">
    <a href="{{ route('alert.index',$token) }}"
        class="<?= $navlink_active == 'alert' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Alert</a>
    <a href="{{ route('footer',$token) }}"
        class="<?= $navlink_active == 'footer' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Footer</a>
    {{-- <a href="{{ route('komite.index',$token) }}"
        class="<?= $navlink_active == 'komite' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Komite</a>
    <a href="{{ route('struktur.index',$token) }}"
        class="<?= $navlink_active == 'struktur' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Struktur Organisasi</a> --}}
{{--    <a href="{{ route('lainnya.index',['token'=>$token]) }}"--}}
{{--        class="<?= $navlink_active == 'other' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Lainnya</a>--}}
</div>
