@extends('layouts.main')

@section('title')
    <title>Agenda | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 pt-4">
    <a href="{{ route('event.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('event.update', ['token' => $token, 'event' => $event->id_pemberitahuan]) }}" method="post" enctype="multipart/form-data">
        @method('patch')
        @csrf
        <div class="form-group">
            <label for="nama">Agenda</label>
            <input value="{{$event->nama}}" type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Besok ada sesuatu..." aria-describedby="namaId">
            @error('nama')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
        </div>
        <div class="form-group">
            <label for="tipe">Target Agenda</label>
            <input value="{{$event->target}}" name="target" id="target" placeholder="Perayaan / Upacara / Classmeet / Istighosah" type="text" class="form-control @error('target') is-invalid @enderror" aria-describedby="tipeId">
            @error('target')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="tipeId" class="text-muted d-none"></small>
        </div>
        <div class="form-group">
            <label for="event" class="form-label">Kategori Agenda</label>
            <select class="form-control @error('id_pemberitahuan_category') is-invalid @enderror" name="id_pemberitahuan_category">
                @foreach ($categories as $category)
                    <option value="{{ $category->id_pemberitahuan_category }}" {{ $event->category == $category->id_pemberitahuan_category ? 'selected' : '' }}>
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
                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ $event->date }}" aria-describedby="tanggalId">
                    <small id="tanggalId" class="text-muted d-none"></small>
                    @error('date')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="location">Lokasi</label>
                    <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ $event->location }}" aria-describedby="lokasiId">
                    <small id="lokasiId" class="text-muted d-none"></small>
                    @error('location')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="text">Deskripsi Agenda</label>
            <textarea name="text" id="texteditor" cols="30" rows="10" class="form-control @error('text') is-invalid @enderror" placeholder="Isi dari event.." aria-describedby="textId">{{$event->text}}</textarea>
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
                    <label for="thumbnail">Thumbnail Agenda</label>
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
                src="{{ asset('img/event/'.$event->thumbnail) }}"
                alt="">
            </div>
        </div>
        <div class="form-group">
            <label for="pdf_file">PDF Informasi Pengumuman</label>
            <input type="file" name="pdf_file" id="pdf_file"
                   class="form-control @error('pdf_file') is-invalid @enderror" placeholder="PDF Data"
                   aria-describedby="pdfdata">
            <small id="pdfdata" class="text-muted d-none">pdf untuk mendukung informasi atau file foto</small>
            @error('pdf_file')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
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
