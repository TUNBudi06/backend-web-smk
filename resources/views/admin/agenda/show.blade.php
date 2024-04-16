@extends('layouts.main')

@section('title')
    <title>Detail Agenda | Admin Panel</title>
@endsection

@section('container')
    <div class="col-md-8 offset-md-2 pt-4">
        <a href="{{ route('event.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i
                class="fas fa-arrow-left"></i> Kembali</a>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Detail Agenda</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Agenda</label>
                    <input value="{{ $event->event_name }}" type="text" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input value="{{ $event->event_date }}" type="text" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="tipe">Kategori Agenda</label>
                    <input value="{{ $event->event_type }}" type="text" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="target">Lokasi</label>
                    <input value="{{ $event->event_location }}" type="text" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="text">Deskripsi Agenda</label>
                    <textarea class="form-control" readonly>{{ $event->event_text }}</textarea>
                </div>
            </div>
        </div>
    </div>
@endsection
