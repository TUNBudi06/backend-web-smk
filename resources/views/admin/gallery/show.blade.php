@extends('layouts.main')

@section('title')
    <title>Detail Gallery | Admin Panel</title>
@endsection

@section('container')
    <div class="col-md-8 offset-md-2 pt-4">
        <a href="{{ route('gallery.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i
                class="fas fa-arrow-left"></i> Kembali</a>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Detail Gallery</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="gallery_title">Judul Gallery</label>
                    <input type="text" class="form-control" value="{{ $gallery->gallery_title }}" readonly>
                </div>
                <div class="form-group">
                    <label for="gallery" class="form-label">Kategori Gallery</label>
                    <input type="text" class="form-control" value="{{ $gallery->category ? $gallery->category->category_name : 'Tidak Ada Kategori' }}" readonly>
                </div>
                <div class="form-group">
                    <label for="gallery_location">Lokasi</label>
                    <input type="text" class="form-control" value="{{ $gallery->gallery_location }}" readonly>
                </div>
                <div class="form-group">
                    <label for="gallery_text">Deskripsi Gallery</label>
                    <textarea class="form-control" readonly>{{ $gallery->gallery_text }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="gallery_file">Thumbnail Gallery</label>
                            <img class="w-100 rounded" src="{{ asset('img/gallery/'.$gallery->gallery_file) }}" alt="">
                        </div>
                    </div>
                    <div class="col-md-6 ">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
