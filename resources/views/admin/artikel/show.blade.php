@extends('layouts.main')

@section('title')
    <title>Detail Artikel | Admin Panel</title>
@endsection

@section('container')

    <div class="col-md-8 offset-md-2 mt-5">
        <a href="{{ route('artikel.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Detail Artikel</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="artikel_title">Judul Artikel</label>
                    <input type="text" class="form-control" value="{{ $artikel->nama }}" readonly>
                </div>
                <div class="form-group">
                    <label for="artikel_level">Status</label>
                    <input type="text" class="form-control" value="{{ $artikel->level == 1 ? 'Biasa' : 'Penting' }}" readonly>
                </div>
                <div class="form-group">
                    <label for="id_category">Kategori Artikel</label>
                    <input type="text" class="form-control" value="{{ $artikel->pemberitahuan_category_name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="artikel_viewer">Viewer</label>
                    <input type="text" class="form-control" value="{{ $artikel->viewer }}" readonly>
                </div>
                <div class="form-group">
                    <label for="artikel_text">Deskripsi Artikel</label>
                    <textarea class="form-control" rows="6" readonly>{{ $artikel->text }}</textarea>
                </div>
                <div class="form-group">
                    <label for="artikel_thumbnail">Thumbnail Artikel</label>
                    <img class="w-100 rounded" src="{{ asset('img/artikel/'.$artikel->thumbnail) }}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
