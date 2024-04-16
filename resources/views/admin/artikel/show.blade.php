@extends('layouts.main')

@section('title')
    <title>Detail Artikel | Admin Panel</title>
@endsection

@section('container')

    <div class="col-md-8 offset-md-2 pt-4">
        <a href="{{ route('artikel.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Detail Artikel</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="artikel_title">Judul Artikel</label>
                    <input type="text" class="form-control" value="{{ $artikel->artikel_title }}" readonly>
                </div>
                <div class="form-group">
                    <label for="artikel_level">Status</label>
                    <input type="text" class="form-control" value="{{ $artikel->artikel_level == 1 ? 'Biasa' : 'Penting' }}" readonly>
                </div>
                <div class="form-group">
                    <label for="id_category">Kategori Artikel</label>
                    <input type="text" class="form-control" value="{{ $artikel->id_category }}" readonly>
                </div>
                <div class="form-group">
                    <label for="artikel_viewer">Viewer</label>
                    <input type="text" class="form-control" value="{{ $artikel->artikel_viewer }}" readonly>
                </div>
                <div class="form-group">
                    <label for="artikel_text">Deskripsi Artikel</label>
                    <textarea class="form-control" rows="6" readonly>{{ $artikel->artikel_text }}</textarea>
                </div>
                <div class="form-group">
                    <label for="artikel_thumbnail">Thumbnail Artikel</label>
                    <img class="w-100 rounded" src="{{ asset('img/artikel/'.$artikel->artikel_thumbnail) }}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
