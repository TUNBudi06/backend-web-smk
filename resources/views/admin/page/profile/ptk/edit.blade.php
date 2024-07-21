@extends('layouts.main')

@section('title')
    <title>PTK | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 pt-4">
    <a href="{{ route('ptk.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('ptk.update', ['token' => $token, 'ptk' => $ptk->id]) }}" method="post" enctype="multipart/form-data">
        @method('patch')
        @csrf
        <div class="form-group">
            <label for="nip">NIP</label>
            <input value="{{$ptk->nip}}" type="number" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror" placeholder="Besok ada sesuatu..." aria-describedby="namaId">
            @error('nip')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="nuptk">NUPTK</label>
            <input value="{{$ptk->nuptk}}" type="number" name="nuptk" id="nuptk" class="form-control @error('nuptk') is-invalid @enderror" aria-describedby="tanggalId">
            @error('nuptk')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="tanggalId" class="text-muted d-none"></small>
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input value="{{$ptk->nama}}" type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" aria-describedby="tanggalId">
            @error('nama')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="tanggalId" class="text-muted d-none"></small>
        </div>
        <div class="form-group">
            <label for="mata_pelajaran">Mata Pelajaran</label>
            <input value="{{$ptk->mata_pelajaran}}" type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control @error('mata_pelajaran') is-invalid @enderror">
            @error('mata_pelajaran')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="tanggal">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ $ptk->tempat_lahir }}" aria-describedby="tanggalId">
                    <small id="tanggalId" class="text-muted d-none"></small>
                    @error('tempat_lahir')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="target">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ $ptk->tanggal_lahir }}" placeholder="Tempat lahir.." aria-describedby="lokasiId">
                    <small id="lokasiId" class="text-muted d-none"></small>
                    @error('tanggal_lahir')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="jenis_kelamin" class="form-label">Status</label>
            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                <option value="L" {{ $ptk->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                <option value="P" {{ $ptk->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control @error('alamat') is-invalid @enderror" aria-describedby="textId">{{$ptk->alamat}}</textarea>
            @error('alamat')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="textId" class="text-muted d-none"></small>
        </div>
        <div class="row">
            <div class="col-md-6 py-md-5 py-3">
                <div class="form-group">
                    <label for="foto">Foto PTK</label>
                    <input onchange="loadFile(event)" type="file" name="foto" id="image" class="form-control @error('foto') is-invalid @enderror" placeholder="Purwosari, Pasuruan" aria-describedby="imageId">
                    <small id="imageId" class="text-muted d-none"></small>
                    @error('foto')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img class="w-100 rounded" id="preview"
                src="{{ asset('img/guru/'.$ptk->foto) }}"
                alt="">
            </div>
        </div>
        <div class="text-right mb-4">
            <button type="submit" class="btn btn-warning mt-2 px-5 rounded-pill shadow-warning"><i class="fas fa-paper-plane"></i> Submit</button>
        </div>
    </form>
</div>
<script>
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
