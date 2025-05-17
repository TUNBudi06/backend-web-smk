@extends('layouts.main')

@section('title')
    <title>Edit Profile Ekstrakurikuler | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 mt-5">
    <a href="{{ route('extra.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('extra.update', ['token' => $token, 'extra' => $extra->id_extra]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="extra_name">Nama Ekstrakurikuler</label>
            <input type="text" name="extra_name" id="extra_name" class="form-control @error('extra_name') is-invalid @enderror" placeholder="Ekstrakurikuler bare..." aria-describedby="nameId" value="{{ old('extra_name', $extra->extra_name) }}">
            <small id="nameId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('extra_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="extra_type">Type Ekstrakurikuler</label>
            <input type="text" name="extra_type" id="extra_type" class="form-control @error('extra_type') is-invalid @enderror" placeholder="Ekstrakurikuler type" aria-describedby="typeId" value="{{ old('extra_type', $extra->extra_type) }}">
            <small id="typeId" class="text-muted"></small>
            @error('extra_type')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="extra_hari">Jadwal Ekstrakurikuler</label>
            <input type="text" name="extra_hari" id="extra_hari" class="form-control @error('extra_hari') is-invalid @enderror" placeholder="Jadwal Ekstrakurikuler" aria-describedby="hariId" value="{{ old('extra_hari', $extra->extra_hari) }}">
            <small id="hariId" class="text-muted"></small>
            @error('extra_hari')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="instagram">Instagram</label>
            <input type="text" name="instagram" id="instagram" class="form-control @error('instagram') is-invalid @enderror" placeholder="Ekstrakurikuler Instagram" aria-describedby="instagramId" value="{{ old('instagram', $extra->instagram) }}">
            <small id="instagramId" class="text-muted"></small>
            @error('instagram')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="telegram">Telegram</label>
            <input type="text" name="telegram" id="telegram" class="form-control @error('telegram') is-invalid @enderror" placeholder="Ekstrakurikuler Telegram" aria-describedby="telegramId" value="{{ old('telegram', $extra->telegram) }}">
            <small id="telegramId" class="text-muted"></small>
            @error('telegram')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="extra_text">Deskripsi Ekstrakurikuler</label>
            <textarea name="extra_text" id="texteditor" cols="30" rows="10" class="form-control @error('extra_text') is-invalid @enderror" placeholder="Isi dari extra.." aria-describedby="textId">{{ old('extra_text', $extra->extra_text) }}</textarea>
            <small id="textId" class="text-muted d-none"></small>
            @error('extra_text')
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
                    <label for="extra_image">Cover Ekstrakurikuler</label>
                    <input onchange="loadFile(event, 'cover_preview')" type="file" name="extra_image" id="extra_image" class="form-control @error('extra_image') is-invalid @enderror">
                    <small id="imageId" class="text-muted d-none"></small>
                    @error('extra_image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img class="w-100 rounded" id="cover_preview" src="{{ $extra->extra_image ? asset('img/extrakurikuler/cover/' . $extra->extra_image) : asset('img/no_image.png') }}" alt="Cover Preview">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 py-md-5 py-3">
                <div class="form-group">
                    <label for="extra_logo">Logo Ekstrakurikuler</label>
                    <input onchange="loadFile(event, 'logo_preview')" type="file" name="extra_logo" id="extra_logo" class="form-control @error('extra_logo') is-invalid @enderror">
                    <small id="logoId" class="text-muted d-none"></small>
                    @error('extra_logo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img class="w-100 rounded" id="logo_preview" src="{{ $extra->extra_logo ? asset('img/extrakurikuler/logo/' . $extra->extra_logo) : asset('img/no_image.png') }}" alt="Logo Preview">
            </div>
        </div>
        <div class="text-right mb-4">
            <button type="submit" class="btn btn-warning mt-5 px-5 rounded-pill shadow-warning"><i class="fas fa-paper-plane"></i> Update</button>
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
