<div class="menu-profile-admin mb-4">
    <a href="{{ route('kemitraan.index',$token) }}"
        class="<?= $mitra_active == 'kemitraan' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Kemitraan</a>
    <a href="{{ route('loker.index',$token) }}"
        class="<?= $mitra_active == 'loker' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Lowongan Pekerjaan</a>
</div>
