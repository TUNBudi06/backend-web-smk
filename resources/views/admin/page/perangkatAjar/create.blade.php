@extends('layouts.main')

@section('title')
    <title>Perangkat Ajar | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 mt-5">
    <a href="{{ route('tools.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('tools.store', ['token' => $token]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title') }}" placeholder="Masukkan judul" aria-describedby="titleHelp">
            <small id="titleHelp" class="text-muted">Judul dari Perangkat Ajar</small>
            @error('title')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea rows="5" name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                      placeholder="Masukkan deskripsi">{{ old('description') }}</textarea>
            @error('description')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="type" class="form-label">Tipe</label>
            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" onchange="showInputBasedOnType()">
                <option value="file" {{ old('type') == 'file' ? 'selected' : '' }}>File</option>
                <option value="url" {{ old('type') == 'url' ? 'selected' : '' }}>URL</option>
            </select>
            @error('type')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group" id="sizeInput" style="display: none;">
            <label for="size">Ukuran (MB)</label>
            <input type="text" name="size" id="size" class="form-control @error('size') is-invalid @enderror"
                   value="{{ old('size') }}" placeholder="Masukkan Ukuran dalam format Mb">
            @error('size')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group" id="fileInput" style="display: none;">
            <label for="file">Upload File</label>
            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">
            @error('file')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group" id="urlInput" style="display: none;">
            <label for="url">URL</label>
            <input type="text" name="url" id="url" class="form-control @error('url') is-invalid @enderror"
                   value="{{ old('url') }}" placeholder="Masukkan URL">
            @error('url')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-right mb-4">
            <button type="submit" class="btn btn-warning mt-5 px-5 rounded-pill shadow-warning"><i class="fas fa-paper-plane"></i> Submit</button>
        </div>
    </form>
</div>
<script>
    function showInputBasedOnType() {
        const type = $('#type').val()
        if (type === 'file') {
            $('#fileInput').show()
            $('#sizeInput').show()
            $('#urlInput').hide()
        } else {
            $('#fileInput').hide()
            $('#sizeInput').hide()
            $('#urlInput').show()
        }
    }

    $(document).ready(function () {
        showInputBasedOnType()
        $('type').on('change', function () {
            showInputBasedOnType()
        })
    });
</script>
@endsection
