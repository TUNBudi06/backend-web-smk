@extends('layouts.main')

@section('title')
    <title>Edit Loker | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
    <div class="col-md-8 offset-md-2 mt-5">
        <a href="{{ route('loker.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <form action="{{ route('loker.update', ['token' => $token, 'loker' => $loker->id_loker]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="loker_description">Deskripsi Loker</label>
                <textarea name="loker_description" id="texteditor" cols="10"
                    class="form-control @error('loker_description') is-invalid @enderror"
                    rows="8">{{ old('loker_description', $loker->loker_description) }}</textarea>
                @error('loker_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <script>
                CKEDITOR.replace('texteditor');
            </script>

            <div class="form-group">
                <label for="loker_for">Target Pelamar</label>
                <input value="{{ $loker->loker_for }}" type="text" name="loker_for" id="loker_for" class="form-control @error('loker_for') is-invalid @enderror" placeholder="Siswa Alumni / Umum, dsb">
                @error('loker_for')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="position_id">Posisi Pekerjaan</label>
                <select name="position_id" id="position_id" class="form-control @error('position_id') is-invalid @enderror">
                    <option disabled value="">Pilih Posisi</option>
                    @foreach ($positions as $position)
                        <option value="{{ $position->id_position }}"
                            {{ old('position_id', $loker->position_id) == $position->id_position ? 'selected' : '' }}>
                            {{ $position->position_name }}
                        </option>
                    @endforeach
                </select>
                @error('position_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="kemitraan_id">Nama Kemitraan</label>
                <select name="kemitraan_id" id="kemitraan_id"
                    class="form-control @error('kemitraan_id') is-invalid @enderror">
                    <option disabled value="">Pilih Kemitraan</option>
                    @foreach ($kemitraans as $kemitraan)
                        <option value="{{ $kemitraan->id_kemitraan }}"
                            {{ old('kemitraan_id', $loker->kemitraan_id) == $kemitraan->id_kemitraan ? 'selected' : '' }}>
                            {{ $kemitraan->kemitraan_name }}
                        </option>
                    @endforeach
                </select>
                @error('kemitraan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Ketersediaan Loker</label>
                <div class="form-check">
                    <input type="radio" name="loker_available" id="loker_available_yes" value="1"
                        class="form-check-input"
                        {{ old('loker_available', $loker->loker_available) == '1' ? 'checked' : '' }}>
                    <label for="loker_available_yes" class="form-check-label">Tersedia</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="loker_available" id="loker_available_no" value="0"
                        class="form-check-input"
                        {{ old('loker_available', $loker->loker_available) == '0' ? 'checked' : '' }}>
                    <label for="loker_available_no" class="form-check-label">Tidak Tersedia</label>
                </div>
                @error('loker_available')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-4">
                <div class="col-md-6 py-md-5 py-3">
                    <div class="form-group">
                        <label for="loker_thumbnail">Thumbnail loker</label>
                        <input onchange="loadFile(event, 'cover_preview')" type="file" name="loker_thumbnail"
                            id="loker_thumbnail" class="form-control @error('loker_thumbnail') is-invalid @enderror">
                        @error('loker_thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img class="w-100 rounded" id="cover_preview"
                        src="{{ $loker->loker_thumbnail ? asset('img/loker/' . $loker->loker_thumbnail) : asset('img/no_image.png') }}"
                        alt="Cover Preview">
                </div>
            </div>

            <div class="form-group">
                <label for="loker_pdf">PDF Loker</label>
                <input type="file" name="loker_pdf" id="loker_pdf"
                    class="form-control @error('loker_pdf') is-invalid @enderror">
                @error('loker_pdf')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-right mb-4">
                <button type="submit" class="btn btn-warning mt-5 px-5 rounded-pill shadow-warning">
                    <i class="fas fa-paper-plane"></i> Update
                </button>
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
