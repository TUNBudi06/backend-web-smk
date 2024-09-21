<div class="menu-profile-admin mb-4">
    <a href="{{ route('jurusan.index',$token) }}"
        class="<?= $profile_active == 'jurusan' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Jurusan</a>
    <a href="{{ route('extra.index',$token) }}"
        class="<?= $profile_active == 'extra' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Extrakurikuler</a>
    <a href="{{ route('pd.index',$token) }}"
        class="<?= $profile_active == 'pd' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">PD</a>
    <a href="{{ route('ptk.index',$token) }}"
        class="<?= $profile_active == 'ptk' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">PTK</a>
    <a href="{{ route('tools.index',$token) }}"
        class="<?= $profile_active == 'tools' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Perangkat Ajar</a>
</div>
