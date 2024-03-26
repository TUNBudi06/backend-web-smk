@extends('layouts.main')

@section('title')
    <title>Agenda | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 pt-4">
    <a href="{{ route('event.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('event.store', ['token' => $token]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama">event</label>
            <input type="text" name="event_name" id="event_name" class="form-control" placeholder="Besok ada sesuatu..." aria-describedby="namaId">
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
        </div>
        <div class="form-group">
            <label for="tipe">Kategori Agenda</label>
            <input type="text" name="event_type" id="event_type" class="form-control" placeholder="Perayaan / Upacara / Classmeet / Istighosah" aria-describedby="tipeId">
            <small id="tipeId" class="text-muted d-none"></small>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="event_date" id="event_date" class="form-control" aria-describedby="tanggalId">
                    <small id="tanggalId" class="text-muted d-none"></small>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="target">Lokasi</label>
                    <input type="text" name="event_location" id="event_location" class="form-control" aria-describedby="lokasiId">
                    <small id="lokasiId" class="text-muted d-none"></small>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="text">Deskripsi Agenda</label>
            <textarea required name="event_text" id="texteditor" cols="30" rows="10" class="form-control" placeholder="Isi dari event.." aria-describedby="textId"></textarea>
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