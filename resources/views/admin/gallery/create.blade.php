@extends('layouts.main')

@section('title')
    <title>Galeri | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 mt-5">
    <a href="{{ route('gallery.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('gallery.store', ['token' => $token]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="gallery_title">Judul Galeri</label>
            <input type="text" name="gallery_title" id="gallery_title" class="form-control @error('gallery_title') is-invalid @enderror" value="{{ old('gallery_title') }}" placeholder="Besok ada sesuatu..." aria-describedby="nameId">
            <small id="nameId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('gallery_title')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="id_category" class="form-label">Kategori Galeri</label>
            <select class="form-control @error('id_category') is-invalid @enderror" name="id_category">
                @foreach ($gallery as $n)
                    <option value="{{ $n->id_category }}" {{ old('id_category') == $n->id_category ? 'selected' : '' }}>{{ $n->category_name }}</option>
                @endforeach
            </select>
            @error('id_category')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="gallery_location">Lokasi</label>
            <input type="text" name="gallery_location" id="gallery_location" class="form-control @error('gallery_location') is-invalid @enderror" value="{{ old('gallery_location') }}" placeholder="Purwosari, Pasuruan">
            @error('gallery_location')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="gallery_text">Deskripsi Galeri</label>
            <textarea name="gallery_text" id="texteditor" cols="30" rows="10" class="form-control @error('gallery_text') is-invalid @enderror" placeholder="Isi dari gallery.." aria-describedby="textId">{{ old('gallery_text') }}</textarea>
            <small id="textId" class="text-muted d-none"></small>
            @error('gallery_text')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <script>
            CKEDITOR.replace('texteditor');
        </script>
        <div class="row">
            <div class="col-md-6 py-md-5 py-3">
                <div class="form-group">
                    <label for="gallery_file">Gambar Galeri</label>
                    <input onchange="loadFile(event)" type="file" name="gallery_file" id="image" class="form-control @error('gallery_file') is-invalid @enderror" placeholder="Purwosari, Pasuruan" aria-describedby="imageId">
                    <small id="imageId" class="text-muted d-none"></small>
                    @error('gallery_file')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img class="w-100 rounded" id="preview" src="{{ asset('img/no_image.png') }}" alt="">
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
</script>
@endsection
