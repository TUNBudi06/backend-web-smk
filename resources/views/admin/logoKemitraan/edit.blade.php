@extends('layouts.main')

@section('title')
    <title>Edit Logo Kemitraan | Admin Panel</title>
@endsection

@section('container')
    <div class="col-md-8 offset-md-2 mt-5">
        <a href="{{ route('logok.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
        <form action="{{ route('logok.update', ['id' => $logo->id_logo_mitra, 'token' => $token]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="nama_mitra">Nama Mitra</label>
                <input type="text" name="nama_mitra" id="nama_mitra" class="form-control @error('nama_mitra') is-invalid @enderror" placeholder="Nama Mitra Logo" aria-describedby="nameId" value="{{ old('nama_mitra', $logo->nama_mitra) }}">
                <small id="nameId" class="text-muted">Hindari penggunaan slash (/,\)</small>
                @error('nama_mitra')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-3 py-md-5 py-3">
                    <div class="form-group">
                        <label for="width_logo">Lebar Logo</label>
                        <div class="input-group flex-nowrap">
                            <input type="number" id="width_logo" name="width_logo" class="form-control @error('width_logo') is-invalid @enderror" placeholder="Width" value="{{ old('width_logo', $logo->width) }}">
                            <span class="input-group-text">px</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 py-md-5 py-3">
                    <div class="form-group">
                        <label for="height_logo">Tinggi Logo</label>
                        <div class="input-group flex-nowrap">
                            <input type="number" id="height_logo" name="height_logo" class="form-control @error('height_logo') is-invalid @enderror" placeholder="Height" value="{{ old('height_logo', $logo->height) }}">
                            <span class="input-group-text">px</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 py-md-5 py-3">
                    <div class="form-group">
                        <label for="kemitraan_thumbnail">Thumbnail Kemitraan</label>
                        <input onchange="loadFile(event, 'cover_preview')" type="file" name="kemitraan_thumbnail" id="kemitraan_thumbnail" class="form-control @error('kemitraan_thumbnail') is-invalid @enderror">
                        @error('kemitraan_thumbnail')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img class="w-100 rounded" id="cover_preview" src="{{ $logo->logo_mitra ? asset('img/mitra/' . $logo->logo_mitra) : asset('img/no_image.png') }}" alt="Cover Preview">
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
