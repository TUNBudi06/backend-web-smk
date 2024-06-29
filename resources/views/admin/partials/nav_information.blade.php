<div class="menu-profile-admin mb-4">
    <a href="{{ route('artikel.index',$token) }}"
        class="<?= $info_active == 'artikel' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Artikel</a>
    <a href="{{ route('pengumuman.index',$token) }}"
        class="<?= $info_active == 'pengumuman' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Pengumuman</a>
    <a href="{{ route('berita.index',$token) }}"
        class="<?= $info_active == 'berita' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Berita</a>
    <a href="{{ route('event.index',$token) }}"
        class="<?= $info_active == 'event' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Agenda</a>
</div>
