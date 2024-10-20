@extends('layouts.main')

@section('title')
    <title>Edit Berita | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 mt-5">
    <a href="{{ route('berita.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('berita.update', ['token' => $token, 'berita' => $news->id_pemberitahuan]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="nama">Judul Berita</label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Besok ada sesuatu..." aria-describedby="nameId" value="{{ $news->nama }}">
            <small id="nameId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('nama')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="form-group">
            <label for="level" class="form-label">Status</label>
            <select class="form-control @error('level') is-invalid @enderror" id="level" name="level">
                <option value="1" {{ $news->level == 1 ? 'selected' : '' }}>Biasa</option>
                <option value="0" {{ $news->level == 0 ? 'selected' : '' }}>Penting</option>
            </select>
            @error('level')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="form-group">
            <label for="news" class="form-label">Kategori Berita</label>
            <select class="form-control @error('id_pemberitahuan_category') is-invalid @enderror" name="id_pemberitahuan_category">
                @foreach ($categories as $category)
                    <option value="{{ $category->id_pemberitahuan_category }}" {{ $news->category == $category->id_pemberitahuan_category ? 'selected' : '' }}>
                        {{ $category->pemberitahuan_category_name }}
                    </option>
                @endforeach
            </select>
            @error('id_pemberitahuan_category')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="form-group">
            <label for="location">Lokasi</label>
            <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" aria-describedby="waktuId" value="{{ $news->location }}">
            <small id="waktuId" class="text-muted d-none"></small>
            @error('location')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="form-group">
            <input type="hidden" name="viewer" id="viewer" class="form-control" aria-describedby="viewId" value="{{ $news->viewer }}">
            <small id="viewId" class="text-muted d-none"></small>
        </div>
        <div class="form-group">
            <label for="jurnal_by">Jurnal By</label>
            <input type="text" name="jurnal_by" id="jurnal_by" class="form-control @error('jurnal_by') is-invalid @enderror" value="{{ $news->jurnal_by }}" aria-describedby="jurnalId">
            <small id="jurnalId" class="text-muted d-none"></small>
            @error('jurnal_by')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="text">Deskripsi Berita</label>
            <textarea name="text" id="texteditor" cols="30" rows="10" class="form-control @error('text') is-invalid @enderror" placeholder="Isi dari news.." aria-describedby="textId">{{ $news->text }}</textarea>
            <small id="textId" class="text-muted d-none"></small>
            @error('text')
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
                    <label for="thumbnail">Thumbnail Berita</label>
                    <input onchange="loadFile(event)" type="file" name="thumbnail" id="image" class="form-control @error('thumbnail') is-invalid @enderror" placeholder="Purwosari, Pasuruan" aria-describedby="imageId">
                    <small id="imageId" class="text-muted d-none"></small>
                    @error('thumbnail')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img class="w-100 rounded" id="preview"
                src="{{ asset('img/berita/'.$news->thumbnail) }}"
                alt="">
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
