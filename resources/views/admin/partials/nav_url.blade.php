<div class="menu-profile-admin mb-4">
    <a href="{{ route('alert.index',$token) }}"
        class="<?= $url_active == 'alert' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Kemitraan</a>
    <a href="{{ route('links',$token) }}"
        class="<?= $url_active == 'links' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Lowongan Pekerjaan</a>
</div>
