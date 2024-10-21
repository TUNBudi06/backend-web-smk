@extends('layouts.main')

@section('title')
    <title>Edit Jurusan | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 mt-5">
    <a href="{{ route('jurusan.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('jurusan.update', ['token' => $token, 'jurusan' => $jurusan->id_jurusan]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="jurusan_nama">Nama Jurusan</label>
            <input type="text" name="jurusan_nama" id="jurusan_nama" class="form-control @error('jurusan_nama') is-invalid @enderror" placeholder="Besok ada sesuatu..." aria-describedby="nameId" value="{{ $jurusan->jurusan_nama }}">
            <small id="nameId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('jurusan_nama')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="form-group">
            <label for="jurusan" class="form-label">Kategori Jurusan</label>
            <select class="form-control @error('id_prodi') is-invalid @enderror" name="id_prodi">
                @foreach ($prodis as $prodi)
                    <option value="{{ $prodi->id_prodi }}" {{ $jurusan->id_prodi == $prodi->id_prodi ? 'selected' : '' }}>
                        {{ $prodi->prodi_name }}
                    </option>
                @endforeach
            </select>
            @error('id_prodi')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="form-group">
            <label for="jurusan_short">Kode Jurusan</label>
            <input type="text" name="jurusan_short" id="jurusan_short" class="form-control @error('jurusan_short') is-invalid @enderror" aria-describedby="waktuId" value="{{ $jurusan->jurusan_short }}">
            <small id="waktuId" class="text-muted d-none"></small>
            @error('jurusan_short')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="form-group">
            <label for="jurusan_text">Deskripsi Jurusan</label>
            <textarea name="jurusan_text" id="texteditor" cols="30" rows="10" class="form-control @error('jurusan_text') is-invalid @enderror" placeholder="Isi dari jurusan.." aria-describedby="textId">{{ $jurusan->jurusan_text }}</textarea>
            <small id="textId" class="text-muted d-none"></small>
            @error('jurusan_text')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <script>
            CKEDITOR.replace('texteditor');
        </script>
        <div class="row">
            <div class="col-md-6 py-md-5 py-3">
                <div class="form-group">
                    <label for="jurusan_thumbnail">Thumbnail Jurusan</label>
                    <input onchange="loadFile(event)" type="file" name="jurusan_thumbnail" id="image" class="form-control @error('jurusan_thumbnail') is-invalid @enderror" placeholder="Purwosari, Pasuruan" aria-describedby="imageId">
                    <small id="imageId" class="text-muted d-none"></small>
                    @error('jurusan_thumbnail')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img class="w-100 rounded" id="preview"
                src="{{ asset('img/jurusan/'.$jurusan->jurusan_thumbnail) }}"
                alt="">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 py-md-5 py-3">
                <div class="form-group">
                    <label for="jurusan_logo">Logo Jurusan</label>
                    <input onchange="loadFile1(event)" type="file" name="jurusan_logo" id="image" class="form-control @error('jurusan_logo') is-invalid @enderror" placeholder="Purwosari, Pasuruan" aria-describedby="imageId">
                    <small id="imageId" class="text-muted d-none"></small>
                    @error('jurusan_logo')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img class="w-100 rounded" id="preview1" src="{{ asset('img/jurusan/logo/'.$jurusan->jurusan_logo) }}" alt="">
            </div>
        </div>
        <div class="text-right mb-4">
            <button type="submit" class="btn btn-warning mt-5 px-5 rounded-pill shadow-warning"><i class="fas fa-paper-plane"></i> Submit</button>
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
    function loadFile1(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('preview1');
            preview.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
