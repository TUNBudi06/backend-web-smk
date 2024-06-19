@extends('layouts.main')

@section('title')
    <title>Edit Peserta Didik | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 pt-4">
    <a href="{{ route('pd.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('pd.update', ['token' => $token, 'pd' => $pd->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="nisn">NISN</label>
            <input type="number" name="nisn" id="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ $pd->nisn }}" placeholder="Masukkan NISN..." aria-describedby="namaId">
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('nisn')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="nis">NIS</label>
            <input type="number" name="nis" id="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ $pd->nis }}" placeholder="Masukkan NIS..." aria-describedby="namaId">
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('nis')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $pd->nama }}" placeholder="Masukkan Nama..." aria-describedby="namaId">
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('nama')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="kelas">Kelas</label>
            <input type="text" name="kelas" id="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ $pd->kelas }}" placeholder="Masukkan Kelas..." aria-describedby="namaId">
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('kelas')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="tipe">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ $pd->tempat_lahir }}" placeholder="Masukkan Tempat Lahir" aria-describedby="tipeId">
            <small id="tipeId" class="text-muted d-none"></small>
            @error('tempat_lahir')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="tanggal">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ $pd->tanggal_lahir }}" aria-describedby="tanggalId">
                    <small id="tanggalId" class="text-muted d-none"></small>
                    @error('tanggal_lahir')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-6">
    <div class="form-group">
        <label for="agama">Agama</label>
        <select name="agama" id="agama" class="form-control @error('agama') is-invalid @enderror">
            <option value="">Pilih Agama</option>
            <option value="Islam" {{ $pd->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
            <option value="Kristen" {{ $pd->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
            <option value="Katolik" {{ $pd->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
            <option value="Hindu" {{ $pd->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
            <option value="Buddha" {{ $pd->agama == 'Buddha' ? 'selected' : '' }}>Buddha</option>
            <option value="Konghucu" {{ $pd->agama == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
        </select>
        @error('agama')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
</div>

        </div>
        <div class="form-group">
    <label for="gender" class="form-label">Gender</label>
    <select class="form-control @error('gender') is-invalid @enderror" name="gender">
        <option value="L" {{ $pd->gender == 'L' ? 'selected' : '' }}>Laki - laki</option>
        <option value="P" {{ $pd->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
    </select>
    @error('gender')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

        <div class="form-group">
            <label for="telp">Telp</label>
            <input type="number" name="telp" id="telp" class="form-control @error('telp') is-invalid @enderror" value="{{ $pd->telp }}" placeholder="Masukkan No Telp..." aria-describedby="namaId">
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('telp')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="text">Alamat</label>
            <textarea required name="alamat" cols="30" rows="10" class="form-control @error('alamat') is-invalid @enderror" placeholder="Isi Alamat Dengan Lengkap" aria-describedby="textId">{{ $pd->alamat }}</textarea>
            <small id="textId" class="text-muted d-none"></small>
            @error('alamat')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

      
        <div class="text-right mb-4">
            <button type="submit" class="btn btn-warning mt-2 px-5 rounded-pill shadow-warning"><i class="fas fa-paper-plane"></i> Submit</button>
        </div>
    </form>
</div>
<script>
     CKEDITOR.replace('texteditor');
    function loadFile(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('preview');
            preview.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
