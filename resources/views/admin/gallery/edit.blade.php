@extends('layouts.main')

@section('title')
    <title>Gallery | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 pt-4">
    <a href="{{ route('gallery.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('gallery.update', ['token' => $token, 'gallery' => $gallery->id_gallery]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="gallery_title">Judul Gallery</label>
            <input type="text" name="gallery_title" id="gallery_title" class="form-control @error('gallery_title') is-invalid @enderror" placeholder="Besok ada sesuatu..." aria-describedby="nameId" value="{{ $gallery->gallery_title }}">
            <small id="nameId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('gallery_title')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>   
        <div class="form-group">
            <label for="gallery" class="form-label">Kategori Gallery</label>
            <select class="form-control @error('id_category') is-invalid @enderror" name="id_category">
                @foreach ($categories as $category)
                    <option value="{{ $category->id_category }}" {{ $gallery->id_category == $category->id_category ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
            @error('id_category')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="form-group">
            <label for="gallery_location">Lokasi</label>
            <input type="text" name="gallery_location" id="gallery_location" class="form-control @error('gallery_location') is-invalid @enderror" aria-describedby="waktuId" value="{{ $gallery->gallery_location }}">
            <small id="waktuId" class="text-muted d-none"></small>
            @error('gallery_location')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="form-group">
            <label for="gallery_content">Deskripsi Gallery</label>
            <textarea name="gallery_content" id="texteditor" cols="30" rows="10" class="form-control @error('gallery_content') is-invalid @enderror" placeholder="Isi dari gallery.." aria-describedby="textId">{{ $gallery->gallery_content }}</textarea>
            <small id="textId" class="text-muted d-none"></small>
            @error('gallery_content')
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
                    <label for="gallery_file">Thumbnail Gallery</label>
                    <input onchange="loadFile(event)" type="file" name="gallery_file" id="image" class="form-control @error('gallery_image') is-invalid @enderror" placeholder="Purwosari, Pasuruan" aria-describedby="imageId">
                    <small id="imageId" class="text-muted d-none"></small>
                    @error('gallery_file')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img class="w-100 rounded" id="preview" 
                src="{{ asset('img/gallery/'.$gallery->gallery_file) }}"  
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
