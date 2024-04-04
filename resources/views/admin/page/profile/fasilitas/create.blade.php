@extends('layouts.main')

@section('title')
    <title>Profile Fasilitas | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 pt-4">
    <a href="{{ route('fasilitas.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('fasilitas.store', ['token' => $token]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="fasilitas_name">Nama Fasilitas</label>
            <input type="text" name="facility_name" id="facility_name" class="form-control @error('facility_name') is-invalid @enderror" placeholder="fasilitas bare..." aria-describedby="nameId" value="{{ old('facility_name') }}">
            <small id="nameId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('facility_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="prodi" class="form-label">Prodi Fasilitas</label>
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
            <label for="facility_text">Deskripsi Fasilitas</label>
            <textarea name="facility_text" id="texteditor" cols="30" rows="10" class="form-control @error('facility_text') is-invalid @enderror" placeholder="Isi dari fasilitas.." aria-describedby="textId">{{ old('facility_text') }}</textarea>
            <small id="textId" class="text-muted d-none"></small>
            @error('facility_text')
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
                    <label for="facility_image">Thumbnail Jurusan</label>
                    <input onchange="loadFile(event)" type="file" name="facility_image" id="image" class="form-control @error('facility_image') is-invalid @enderror" placeholder="Purwosari, Pasuruan" aria-describedby="imageId">
                    <small id="imageId" class="text-muted d-none"></small>
                    @error('facility_image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img class="w-100 rounded" id="preview" src="{{ asset('img/fasilitas/no_image.png') }}" alt="">
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
