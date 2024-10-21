@extends('layouts.main')

@section('title')
    <title>Detail Pengumuman | Admin Panel</title>
@endsection

@section('container')
    <div class="col-md-8 offset-md-2 mt-5">
        <a href="{{ route('pengumuman.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i
                class="fas fa-arrow-left"></i> Kembali</a>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Detail Pengumuman</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="pengumuman_nama">Pengumuman</label>
                    <input type="text" name="pengumuman_nama" id="pengumuman_nama" value="{{ $pengumuman->nama }}" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="pengumuman_target">Pengumuman Target</label>
                    <input type="text" name="pengumuman_target" id="pengumuman_target" value="{{ $pengumuman->target }}" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="pengumuman_date">Tanggal</label>
                    <input type="text" name="pengumuman_date" id="pengumuman_date" value="{{ $pengumuman->date }}" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="pengumuman_time">Waktu</label>
                    <input type="text" name="pengumuman_time" id="pengumuman_time" value="{{ $pengumuman->time }}" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="pengumuman_text">Deskripsi Pengumuman</label>
                    <textarea name="pengumuman_text" id="pengumuman_text" cols="30" rows="10" class="form-control" readonly>{{ $pengumuman->text }}</textarea>
                </div>
            </div>
        </div>
    </div>
@endsection
