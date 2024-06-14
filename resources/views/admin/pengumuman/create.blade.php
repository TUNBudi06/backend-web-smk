@extends('layouts.main')

@section('title')
    <title>Pengumuman | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
    <div class="col-md-8 offset-md-2 pt-4">
        <a href="{{ route('pengumuman.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i
                class="fas fa-arrow-left"></i> Kembali</a>
        <form action="{{ route('pengumuman.store', ['token' => $token]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama">Pengumuman</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                    class="form-control @error('nama') is-invalid @enderror" placeholder="Besok ada sesuatu..."
                    aria-describedby="namaId">
                @error('nama')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
                <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            </div>
            <div class="form-group">
                <label for="target">Target Pengumuman</label>
                <input type="text" name="target" id="target" value="{{ old('target') }}"
                    class="form-control @error('target') is-invalid @enderror"
                    placeholder="Seluruh Jurusan / Hanya 1 Jurusan" aria-describedby="targetId">
                @error('target')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
                <small id="targetId" class="text-muted">Contoh: Seluruh Jurusan / Hanya 1 Jurusan</small>
            </div>
            <div class="form-group">
                <label for="pengumuman" class="form-label">Kategori Pengumuman</label>
                <select class="form-control @error('id_pemberitahuan_category') is-invalid @enderror"
                    name="id_pemberitahuan_category">
                    @foreach ($pengumuman as $p)
                        @if (old('id_pemberitahuan_category') == $p->id_pemberitahuan_category)
                            <option value="{{ $p->id_pemberitahuan_category }}" selected>{{ $p->pemberitahuan_category_name }}</option>
                        @else
                            <option value="{{ $p->id_pemberitahuan_category }}">{{ $p->pemberitahuan_category_name }}</option>
                        @endif
                    @endforeach
                </select>
                @error('id_pemberitahuan_category')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input type="date" name="date" id="date"
                            value="{{ old('date') }}"
                            class="form-control @error('date') is-invalid @enderror"
                            aria-describedby="tanggalId">
                        @error('date')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                        <small id="tanggalId" class="text-muted">Pilih tanggal pengumuman.</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="time">Waktu</label>
                        <input type="time" name="time" id="time"
                            value="{{ old('time') }}"
                            class="form-control @error('time') is-invalid @enderror" aria-describedby="waktuId">
                        @error('time')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                        <small id="waktuId" class="text-muted">Pilih waktu pengumuman.</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="text">Deskripsi Pengumuman</label>
                <textarea required name="text" id="texteditor" cols="30" rows="10"
                    class="form-control @error('text') is-invalid @enderror" placeholder="Isi dari pengumuman.."
                    aria-describedby="textId">{{ old('text') }}</textarea>
                @error('text')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
                <small id="textId" class="text-muted">Deskripsi atau isi dari pengumuman.</small>
            </div>
            <script>
                CKEDITOR.replace('texteditor');
            </script>
            <div class="row">
                <div class="col-md-6 py-md-5 py-3">
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail Pengumuman</label>
                        <input onchange="loadFile(event)" type="file" name="thumbnail" id="thumbnail"
                            class="form-control @error('thumbnail') is-invalid @enderror" placeholder="Purwosari, Pasuruan"
                            aria-describedby="imageId">
                        <small id="imageId" class="text-muted d-none"></small>
                        @error('thumbnail')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img class="w-100 rounded" id="preview" src="{{ asset('img/no_image.png') }}" alt="">
                </div>
            </div>
            <div class="text-right mb-4">
                <button type="submit" class="btn btn-warning mt-2 px-5 rounded-pill shadow-warning"><i
                        class="fas fa-paper-plane"></i> Submit</button>
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
