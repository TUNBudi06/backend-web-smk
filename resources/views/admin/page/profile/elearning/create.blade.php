@extends('layouts.main')

@section('title')
    <title>E-Learning | Admin Panel</title>
    {{-- <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('container')
<div class="col-md-8 offset-md-2 mt-5">
    <a href="{{ route('elearning.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('elearning.store', ['token' => $token]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Judul E-Learning</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Microsoft Office..." aria-describedby="nameId" value="{{ old('title') }}">
            @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="desc">Deskripsi Utama</label>
            <textarea name="desc" id="desc" class="form-control" placeholder="Deskripsi..." aria-describedby="jurnalById" rows="5">{{ old('desc') }}</textarea>
            @error('desc')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
            @enderror
        </div>
        <h6 class="my-2 font-weight-normal">Tombol Utama</h6>
        <div class="row mb-4 mt-2">
            <div class="col-md-4">
                <label for="btn_label">Label</label>
                <input type="text" name="btn_label" id="btn_label" class="form-control" placeholder="Microsoft Office..." aria-describedby="nameId" value="{{ old('btn_label') }}">
                @error('btn_label')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="btn_url">URL</label>
                <input type="text" name="btn_url" id="btn_url" class="form-control" placeholder="url.com" aria-describedby="nameId" value="{{ old('btn_url') }}">
                @error('btn_url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="btn_icon">Icon</label>
                <input type="file" name="btn_icon" id="btn_icon" class="form-control" aria-describedby="nameId">
                @error('btn_icon')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                @enderror
            </div>
        </div>
        <h6 class="my-2 font-weight-normal">Tombol Utama 2</h6>
        <div class="row mb-4 mt-2">
            <div class="col-md-4">
                <label for="btn_label_2">Label 2</label>
                <input type="text" name="btn_label_2" id="btn_label_2" class="form-control" placeholder="Microsoft Office..." aria-describedby="nameId" value="{{ old('btn_label_2') }}">
                @error('btn_label_2')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="btn_url_2">URL 2</label>
                <input type="text" name="btn_url_2" id="btn_url_2" class="form-control" placeholder="url.com" aria-describedby="nameId" value="{{ old('btn_url_2') }}">
                @error('btn_url_2')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="btn_icon_2">Icon 2</label>
                <input type="file" name="btn_icon_2" id="btn_icon_2" class="form-control" aria-describedby="nameId">
                @error('btn_icon_2')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="subtitle">Subjudul E-Learning</label>
            <input type="text" name="subtitle" id="subtitle" class="form-control" placeholder="Subjudul..." aria-describedby="nameId" value="{{ old('subtitle') }}">
            @error('subtitle')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="body_desc">Deskripsi Konten</label>
            <textarea name="body_desc" id="body_desc" class="form-control" placeholder="Deskripsi konten..." aria-describedby="jurnalById" rows="5">{{ old('body_desc') }}</textarea>
            @error('body_desc')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="body_url">Tombol Tautan pada Konten</label>
            <input type="text" name="body_url" id="body_url" class="form-control" placeholder="Konten URL..." aria-describedby="nameId" value="{{ old('body_url') }}">
            @error('body_url')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="elearning" class="form-label">Multiple Badge</label>
                    <select id="badgeSelect" multiple class="form-control @error('id_badge') is-invalid @enderror" name="id_badge[]">
                        @foreach ($badges as $badge)
                            <option value="{{ $badge->id }}" data-icon="{{ asset('img/badge/' . $badge->icon) }}">
                                {{ $badge->label }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_badge')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 py-md-5 mt-3 py-3">
                <div class="form-group">
                    <label for="thumbnail">Thumbnail E-Learning</label>
                    <input onchange="loadFile(event)" type="file" name="thumbnail" id="image" class="form-control" placeholder="Purwosari, Pasuruan" aria-describedby="imageId">
                    <small id="imageId" class="text-muted d-none"></small>
                @error('thumbnail')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3 text-center">
                <img class="w-100 rounded" id="preview"
                src="{{ asset('img/no_image.png') }}"
                alt="">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 py-md-5 mt-3 py-3">
                <div class="form-group">
                    <label for="body_thumbnail">Thumbnail Konten</label>
                    <input onchange="loadFileKonten(event)" type="file" name="body_thumbnail" id="image" class="form-control" placeholder="Purwosari, Pasuruan" aria-describedby="imageId">
                    <small id="imageId" class="text-muted d-none"></small>
                @error('body_thumbnail')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3 text-center">
                <img class="w-100 rounded" id="preview-konten"
                src="{{ asset('img/no_image.png') }}"
                alt="">
            </div>
        </div>
        <div class="text-right mb-4">
            <button type="submit" class="btn btn-warning mt-5 px-5 rounded-pill shadow-warning"><i class="fas fa-paper-plane"></i> Submit</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#badgeSelect').select2({
            templateResult: formatBadge,
            templateSelection: formatBadge
        });

        function formatBadge(badge) {
            if (!badge.id) return badge.text;
            const iconUrl = $(badge.element).data('icon');
            return $(
                `<span><img src="${iconUrl}" style="width: 20px; height: 20px; margin-right: 5px;" />${badge.text}</span>`
            );
        }
    });

    function loadFile(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('preview');
            preview.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    function loadFileKonten(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('preview-konten');
            preview.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
