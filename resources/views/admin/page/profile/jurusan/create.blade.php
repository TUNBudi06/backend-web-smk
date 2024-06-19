@extends('layouts.main')

@section('title')
    <title>Profile Jurusan | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 pt-4">
    <a href="{{ route('jurusan.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('jurusan.store', ['token' => $token]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="jurusan_nama">Nama Jurusan</label>
            <input type="text" name="jurusan_nama" id="jurusan_nama" class="form-control @error('jurusan_nama') is-invalid @enderror" placeholder="Jurusan baru..." aria-describedby="nameId" value="{{ old('jurusan_nama') }}">
            <small id="nameId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('jurusan_nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="prodi" class="form-label">Prodi Jurusan</label>
            <select class="form-control @error('id_prodi') is-invalid @enderror" name="id_prodi">
                @foreach ($prodi as $p)
                    <option value="{{ $p->id_prodi }}" {{ old('id_prodi') == $p->id_prodi ? 'selected' : '' }}>{{ $p->prodi_name }}</option>
                @endforeach
            </select>
            @error('id_prodi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="jurusan_short">Kode Jurusan</label>
            <input type="text" name="jurusan_short" id="jurusan_short" class="form-control @error('jurusan_short') is-invalid @enderror" value="{{ old('jurusan_short') }}" aria-describedby="waktuId" placeholder="Singkatan Jurusan...">
            <small id="waktuId" class="text-muted d-none"></small>
            @error('jurusan_short')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="jurusan_text">Deskripsi Jurusan</label>
            <textarea name="jurusan_text" id="texteditor" cols="30" rows="10" class="form-control @error('jurusan_text') is-invalid @enderror" placeholder="Isi dari jurusan.." aria-describedby="textId">{{ old('jurusan_text') }}</textarea>
            <small id="textId" class="text-muted d-none"></small>
            @error('jurusan_text')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
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
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img class="w-100 rounded" id="preview" src="{{ asset('img/no_image.png') }}" alt="">
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
