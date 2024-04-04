@extends('layouts.main')

@section('title')
    <title>Peserta Didik | Admin Panel</title>
@endsection

@section('container')
    <div class="col-md-8 offset-md-2 pt-4">
        <a href="{{ route('pd.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i
                class="fas fa-arrow-left"></i> Kembali</a>
        <!-- <div class="form-group">
            <label for="nama">Agenda</label>
            <input required value="{{ $pd->nama }}" type="text" name="nama" id="nama"
                class="form-control" placeholder="Besok ada sesuatu..." aria-describedby="namaId">
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
        </div> -->

        <div class="form-group">
            <label for="nisn">NISN</label>
            <input required value="{{ $pd->nisn }}" type="text" name="nisn" id="nisn"
                class="form-control" placeholder="Besok ada sesuatu..." aria-describedby="namaId" readonly>
        </div>
        <div class="form-group">
            <label for="nis">NIS</label>
            <input required value="{{ $pd->nis }}" type="text" name="nis" id="nis"
                class="form-control" placeholder="Besok ada sesuatu..." aria-describedby="namaId" readonly>
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input required value="{{ $pd->nama }}" type="text" name="nama" id="nama"
                class="form-control" placeholder="Besok ada sesuatu..." aria-describedby="namaId" readonly>
        </div>
        <div class="form-group">
            <label for="kelas">Kelas</label>
            <input required value="{{ $pd->kelas }}" type="text" name="kelas" id="kelas"
                class="form-control" placeholder="Besok ada sesuatu..." aria-describedby="namaId" readonly>
        </div>
        <div class="form-group">
            <label for="tipe">Tempat Lahir</label>
            <input required value="{{ $pd->tempat_lahir }}" type="text" name="tempat_lahir" id="tempat_lahir"
                class="form-control" placeholder="Besok ada sesuatu..." aria-describedby="namaId" readonly>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="tanggal">Tanggal Lahir</label>
                    <input required value="{{ $pd->tanggal_lahir }}" type="date" name="tanggal_lahir" id="tanggal_lahir"
                        class="form-control" placeholder="Besok ada sesuatu..." aria-describedby="namaId" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="agama">Agama</label>
                    <input required value="{{ $pd->agama }}" type="text" name="agama" id="agama"
                        class="form-control" placeholder="Besok ada sesuatu..." aria-describedby="namaId" readonly>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="gender" class="form-label">Gender</label>
            <input required value="{{ $pd->gender }}" type="text" name="gender" id="gender"
                class="form-control" placeholder="Besok ada sesuatu..." aria-describedby="namaId" readonly>
        </div>
        <div class="form-group">
            <label for="telp">Telp</label>
            <input required value="{{ $pd->telp }}" type="text" name="telp" id="telp"
                class="form-control" placeholder="Besok ada sesuatu..." aria-describedby="namaId" readonly>
        </div>
        <div class="form-group">
            <label for="text">Alamat</label>
            <input required value="{{ $pd->alamat }}" type="text" name="alamat" id="alamat"
                class="form-control" placeholder="Besok ada sesuatu..." aria-describedby="namaId" readonly>
        </div>
    </div>
@endsection
