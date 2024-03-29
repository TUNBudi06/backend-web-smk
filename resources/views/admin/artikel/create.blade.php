@extends('layouts.main')

@section('title')
    <title>Artikel | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 pt-4">
    <a href="{{ route('artikel.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('artikel.store', ['token' => $token]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="artikel_title">Judul Artikel</label>
            <input type="text" name="artikel_title" id="artikel_title" class="form-control @error('artikel_title') is-invalid @enderror" value="{{ old('artikel_title') }}" placeholder="Besok ada sesuatu..." aria-describedby="nameId">
            <small id="nameId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('artikel_title')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="artikel_level" class="form-label">Status</label>
            <select class="form-control @error('artikel_level') is-invalid @enderror" id="artikel_level" name="artikel_level">
                    <option value="1" {{ old('artikel_level') == '1' ? 'selected' : '' }}>Biasa</option>
                    <option value="0" {{ old('artikel_level') == '0' ? 'selected' : '' }}>Penting</option>
            </select>
            @error('artikel_level')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="id_category" class="form-label">Kategori Artikel</label>
            <select class="form-control @error('id_category') is-invalid @enderror" name="id_category">
                @foreach ($artikel as $n)
                    <option value="{{ $n->id_category }}" {{ old('id_category') == $n->id_category ? 'selected' : '' }}>{{ $n->category_name }}</option>
                @endforeach
            </select>
            @error('id_category')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <input type="hidden" name="artikel_viewer" id="artikel_viewer" class="form-control" value="0" aria-describedby="viewId">
                <small id="viewId" class="text-muted d-none"></small>
        </div>
        <div class="form-group">
            <label for="artikel_text">Deskripsi Artikel</label>
            <textarea name="artikel_text" id="texteditor" cols="30" rows="10" class="form-control @error('artikel_text') is-invalid @enderror" placeholder="Isi dari artikel.." aria-describedby="textId">{{ old('artikel_text') }}</textarea>
            <small id="textId" class="text-muted d-none"></small>
            @error('artikel_text')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <script>
            CKEDITOR.replace('texteditor');
        </script>
        <div class="row">
            <div class="col-md-6 py-md-5 py-3">
                <div class="form-group">
                    <label for="artikel_thumbnail">Thumbnail Artikel</label>
                    <input onchange="loadFile(event)" type="file" name="artikel_thumbnail" id="image" class="form-control @error('artikel_thumbnail') is-invalid @enderror" placeholder="Purwosari, Pasuruan" aria-describedby="imageId">
                    <small id="imageId" class="text-muted d-none"></small>
                    @error('artikel_thumbnail')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img class="w-100 rounded" id="preview" src="{{ asset('img/artikel/no_image.png') }}" alt="">
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
