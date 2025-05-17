<div class="menu-profile-admin mb-4">
    <a href="{{ route('video.index',$token) }}"
        class="<?= $profile_active == 'video' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Video Jumbotron</a>
    <a href="{{ route('slider.index',$token) }}"
        class="<?= $profile_active == 'slider' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Slider Keunggulan</a>
    <a href="{{ route('fasilitas.index',$token) }}"
        class="<?= $profile_active == 'fasilitas' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Fasilitas</a>
    {{--
    <a href="{{ route('struktur.index',$token) }}"
        class="<?= $profile_active == 'struktur' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Struktur Organisasi</a>
    --}}
    <a href="{{ route('lainnya.index',['token'=>$token]) }}"
        class="<?= $profile_active == 'other' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Lainnya</a>
</div>
