<div class="menu-profile-admin mb-4">
    <a href="{{ route('profile.jurusan') }}" 
        class="<?= $profile_active == 'jurusan' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Jurusan</a>
    <a href="{{ route('profile.extra') }}" 
        class="<?= $profile_active == 'extra' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Extrakurikuler</a>
    <a href="{{ route('profile.fasilitas') }}" 
        class="<?= $profile_active == 'fasilitas' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Fasilitas</a>
    <a href="{{ route('profile.kemitraan') }}" 
        class="<?= $profile_active == 'kemitraan' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Kemitraan</a>
    <a href="{{ route('profile.pd') }}" 
        class="<?= $profile_active == 'pd' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">PD</a>
    <a href="{{ route('profile.ptk') }}" 
        class="<?= $profile_active == 'ptk' ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">PTK</a>
</div>