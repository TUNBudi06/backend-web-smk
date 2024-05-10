@extends('layouts.main')

@section('title')
    <title>Detail Berita | Admin Panel</title>
@endsection

@section('container')
    <div class="col-md-8 offset-md-2 pt-4">
        <a href="{{ route('berita.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i
                class="fas fa-arrow-left"></i> Kembali</a>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Detail Berita</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="news_title">Judul Berita</label>
                    <input type="text" class="form-control" value="{{ $news->nama }}" readonly>
                </div>
                <div class="form-group">
                    <label for="news_level" class="form-label">Status</label>
                    <input type="text" class="form-control" value="{{ $news->level == 1 ? 'Biasa' : 'Penting' }}" readonly>
                </div>
                <div class="form-group">
                    <label for="news" class="form-label">Kategori Berita</label>
                    <input type="text" class="form-control" value="{{ $news->category ? $news->pemberitahuan_category_name : 'Tidak ada kategori' }}" readonly>
                </div>
                <div class="form-group">
                    <label for="news_location">Lokasi</label>
                    <input type="text" class="form-control" value="{{ $news->location }}" readonly>
                </div>
                <div class="form-group">
                    <label for="news_content">Deskripsi Berita</label>
                    <textarea class="form-control" readonly>{{ $news->text }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="news_image">Thumbnail Berita</label>
                            <img class="w-100 rounded" src="{{ asset('img/berita/'.$news->thumbnail) }}" alt="">
                        </div>
            </div>
        </div>
    </div>
@endsection
