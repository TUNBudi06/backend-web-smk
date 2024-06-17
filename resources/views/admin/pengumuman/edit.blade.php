@extends('layouts.main')

@section('title')
    <title>Pengumuman | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 pt-4">
    <a href="{{ route('pengumuman.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('pengumuman.update', ['token' => $token, 'pengumuman' => $pengumuman->id_pemberitahuan]) }}" method="post" enctype="multipart/form-data">
        @method('patch')
        @csrf
        <div class="form-group">
            <label for="nama">Pengumuman</label>
            <input type="text" name="nama" id="nama" value="{{ $pengumuman->nama }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Besok ada sesuatu..." aria-describedby="namaId">
            @error('nama')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
        </div>
        <div class="form-group">
            <label for="target">Target Pengumuman</label>
            <input type="text" name="target" id="target" value="{{ $pengumuman->target }}" class="form-control @error('target') is-invalid @enderror" placeholder="Seluruh Jurusan / Hanya 1 Jurusan" aria-describedby="targetId">
            @error('target')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="targetId" class="text-muted d-none"></small>
        </div>
        <div class="form-group">
            <label for="pengumuman" class="form-label">Kategori Pengumuman</label>
            <select class="form-control @error('id_pemberitahuan_category') is-invalid @enderror" name="id_pemberitahuan_category">
                @foreach ($categories as $category)
                    <option value="{{ $category->id_pemberitahuan_category }}" {{ $pengumuman->category == $category->id_pemberitahuan_category ? 'selected' : '' }}>
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
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="date">Tanggal</label>
                    <input type="date" name="date" id="date" value="{{ $pengumuman->date }}" class="form-control @error('date') is-invalid @enderror" aria-describedby="tanggalId">
                    @error('date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <small id="tanggalId" class="text-muted d-none"></small>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="time">Waktu</label>
                    <input type="time" name="time" id="time" value="{{ $pengumuman->time }}" class="form-control @error('time') is-invalid @enderror" aria-describedby="waktuId">
                    @error('time')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <small id="waktuId" class="text-muted d-none"></small>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="text">Deskripsi Pengumuman</label>
            <textarea required name="text" id="texteditor" cols="30" rows="10" class="form-control @error('text') is-invalid @enderror" placeholder="Isi dari pengumuman.." aria-describedby="textId">{{ $pengumuman->text }}</textarea>
            @error('text')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="textId" class="text-muted d-none"></small>
        </div>
        <script>
            CKEDITOR.replace('texteditor');
        </script>
        <div class="row">
            <div class="col-md-6 py-md-5 py-3">
                <div class="form-group">
                    <label for="thumbnail">Thumbnail Pengumuman</label>
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
                src="{{ asset('img/announcement/'.$pengumuman->thumbnail) }}"
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
