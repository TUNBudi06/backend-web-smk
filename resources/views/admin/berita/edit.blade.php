@extends('layouts.main')

@section('title')
    <title>Edit Berita | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 pt-4">
    <a href="{{ route('berita.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('berita.update', ['token' => $token, 'berita' => $news->id_news]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="news_title">Judul Berita</label>
            <input type="text" name="news_title" id="news_title" class="form-control @error('news_title') is-invalid @enderror" placeholder="Besok ada sesuatu..." aria-describedby="nameId" value="{{ $news->news_title }}">
            <small id="nameId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('news_title')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="form-group">
            <label for="news_level" class="form-label">Status</label>
            <select class="form-control @error('news_level') is-invalid @enderror" id="news_level" name="news_level">
                <option value="1" {{ $news->news_level == 1 ? 'selected' : '' }}>Biasa</option>
                <option value="0" {{ $news->news_level == 0 ? 'selected' : '' }}>Penting</option>
            </select>
            @error('news_level')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="form-group">
            <label for="news" class="form-label">Kategori Berita</label>
            <select class="form-control @error('id_category') is-invalid @enderror" name="id_category">
                @foreach ($categories as $category)
                    <option value="{{ $category->id_category }}" {{ $news->id_category == $category->id_category ? 'selected' : '' }}>
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
            <label for="news_location">Lokasi</label>
            <input type="text" name="news_location" id="news_location" class="form-control @error('news_location') is-invalid @enderror" aria-describedby="waktuId" value="{{ $news->news_location }}">
            <small id="waktuId" class="text-muted d-none"></small>
            @error('news_location')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="form-group">
            <input type="hidden" name="news_viewer" id="news_viewer" class="form-control" aria-describedby="viewId" value="{{ $news->news_viewer }}">
            <small id="viewId" class="text-muted d-none"></small>
        </div>
        <div class="form-group">
            <label for="news_content">Deskripsi Berita</label>
            <textarea name="news_content" id="texteditor" cols="30" rows="10" class="form-control @error('news_content') is-invalid @enderror" placeholder="Isi dari news.." aria-describedby="textId">{{ $news->news_content }}</textarea>
            <small id="textId" class="text-muted d-none"></small>
            @error('news_content')
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
                    <label for="news_image">Thumbnail Berita</label>
                    <input onchange="loadFile(event)" type="file" name="news_image" id="image" class="form-control @error('news_image') is-invalid @enderror" placeholder="Purwosari, Pasuruan" aria-describedby="imageId">
                    <small id="imageId" class="text-muted d-none"></small>
                    @error('news_image')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img class="w-100 rounded" id="preview" 
                src="{{ asset('img/berita/'.$news->news_image) }}"  
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
