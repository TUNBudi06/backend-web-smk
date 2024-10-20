@extends('layouts.main')

@section('title')
    <title>Kemitraan | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 mt-5">
    <a href="{{ route('kemitraan.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('kemitraan.store', ['token' => $token]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="kemitraan_name">Nama Kemitraan</label>
            <input type="text" name="kemitraan_name" id="kemitraan_name" class="form-control @error('kemitraan_name') is-invalid @enderror" placeholder="Kemitraan baru..." aria-describedby="nameId" value="{{ old('kemitraan_name') }}">
            <small id="nameId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('kemitraan_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="kemitraan_city">Lokasi Kemitraan</label>
            <input type="text" name="kemitraan_city" id="kemitraan_city" class="form-control @error('kemitraan_city') is-invalid @enderror" placeholder="Kota / Kabupaten" aria-describedby="nameId" value="{{ old('kemitraan_city') }}">
            <small id="typeId" class="text-muted"></small>
            @error('kemitraan_city')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="kemitraan_location_detail">Detail Lokasi Kemitraan</label>
            <textarea name="kemitraan_location_detail" id="kemitraan_location_detail" class="form-control @error('kemitraan_location_detail') is-invalid @enderror" placeholder="Provinsi, Kabupaten/Kota, Kecamatan" aria-describedby="hariId" rows="3">{{ old('kemitraan_location_detail') }}</textarea>
            <small id="hariId" class="text-muted"></small>
            @error('kemitraan_location_detail')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="kemitraan_description">Deskripsi Kemitraan</label>
            <textarea name="kemitraan_description" id="texteditor" cols="30" rows="10" class="form-control @error('kemitraan_description') is-invalid @enderror" placeholder="Isi dari kemitraan.." aria-describedby="textId">{{ old('kemitraan_description') }}</textarea>
            <small id="textId" class="text-muted d-none"></small>
            @error('kemitraan_description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <script>
            CKEDITOR.replace('texteditor');
        </script>
        <div class="row mb-4">
            <div class="col-md-6 py-md-5 py-3">
                <div class="form-group">
                    <label for="kemitraan_thumbnail">Thumbnail Kemitraan</label>
                    <input onchange="loadFile(event, 'cover_preview')" type="file" name="kemitraan_thumbnail" id="kemitraan_thumbnail" class="form-control @error('kemitraan_thumbnail') is-invalid @enderror">
                    <small id="imageId" class="text-muted d-none"></small>
                    @error('kemitraan_thumbnail')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img class="w-100 rounded" id="cover_preview" src="{{ asset('img/no_image.png') }}" alt="Cover Preview">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 py-md-5 py-3">
                <div class="form-group">
                    <label for="kemitraan_logo">Logo Kemitraan</label>
                    <input onchange="loadFile(event, 'logo_preview')" type="file" name="kemitraan_logo" id="kemitraan_logo" class="form-control @error('kemitraan_logo') is-invalid @enderror">
                    <small id="logoId" class="text-muted d-none"></small>
                    @error('kemitraan_logo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img class="w-100 rounded" id="logo_preview" src="{{ asset('img/no_image.png') }}" alt="Logo Preview">
            </div>
        </div>
        <div class="text-right mb-4">
            <button type="submit" class="btn btn-warning mt-5 px-5 rounded-pill shadow-warning"><i class="fas fa-paper-plane"></i> Submit</button>
        </div>
    </form>
</div>
<script>
    function loadFile(event, previewId) {
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById(previewId);
            preview.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection