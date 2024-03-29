@extends('layouts.main')

@section('title')
    <title>Pengumuman | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 pt-4">
    <a href="{{ route('pengumuman.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('pengumuman.update', ['token' => $token, 'pengumuman' => $pengumuman->id_pengumuman]) }}" method="post">
        @method('put')
        @csrf
        <div class="form-group">
            <label for="pengumuman_nama">Pengumuman</label>
            <input type="text" name="pengumuman_nama" id="pengumuman_nama" value="{{ $pengumuman->pengumuman_nama }}" class="form-control @error('pengumuman_nama') is-invalid @enderror" placeholder="Besok ada sesuatu..." aria-describedby="namaId">
            @error('pengumuman_nama')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
        </div>
        <div class="form-group">
            <label for="pengumuman_target">Pengumuman Target</label>
            <input type="text" name="pengumuman_target" id="pengumuman_target" value="{{ $pengumuman->pengumuman_target }}" class="form-control @error('pengumuman_target') is-invalid @enderror" placeholder="Seluruh Jurusan / Hanya 1 Jurusan" aria-describedby="targetId">
            @error('pengumuman_target')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="targetId" class="text-muted d-none"></small>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="pengumuman_date">Tanggal</label>
                    <input type="date" name="pengumuman_date" id="pengumuman_date" value="{{ $pengumuman->pengumuman_date }}" class="form-control @error('pengumuman_date') is-invalid @enderror" aria-describedby="tanggalId">
                    @error('pengumuman_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <small id="tanggalId" class="text-muted d-none"></small>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="pengumuman_time">Waktu</label>
                    <input type="time" name="pengumuman_time" id="pengumuman_time" value="{{ $pengumuman->pengumuman_time }}" class="form-control @error('pengumuman_time') is-invalid @enderror" aria-describedby="waktuId">
                    @error('pengumuman_time')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <small id="waktuId" class="text-muted d-none"></small>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="pengumuman_text">Deskripsi Pengumuman</label>
            <textarea required name="pengumuman_text" id="texteditor" cols="30" rows="10" class="form-control @error('pengumuman_text') is-invalid @enderror" placeholder="Isi dari pengumuman.." aria-describedby="textId">{{ $pengumuman->pengumuman_text }}</textarea>
            @error('pengumuman_text')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="textId" class="text-muted d-none"></small>
        </div>
        <script>
            CKEDITOR.replace('texteditor');
        </script>
        <div class="text-right mb-4">
            <button type="submit" class="btn btn-warning mt-2 px-5 rounded-pill shadow-warning"><i class="fas fa-paper-plane"></i> Submit</button>
        </div>
    </form>
</div>
@endsection
