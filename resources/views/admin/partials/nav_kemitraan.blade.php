<div class="menu-profile-admin mb-4">
    <a href="{{ route('kemitraan.index',$token) }}"
        class="<?= $mitra_active == 'kemitraan' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Kemitraan</a>
    <a href="#"
        class="<?= $mitra_active == '' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Lowongan Pekerjaan</a>
</div>
