@extends('layouts.main')

@section('title')
    <title>Agenda | Admin Panel</title>
@endsection

@section('container')
    <div class="col-md-8 offset-md-2 pt-4">
        <a href="{{ route('event.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i
                class="fas fa-arrow-left"></i> Kembali</a>
        <div class="form-group">
            <label for="nama">Agenda</label>
            <input required value="{{ $event->event_name }}" type="text" name="event_name" id="event_name"
                class="form-control" placeholder="Besok ada sesuatu..." aria-describedby="namaId">
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input required value="{{ $event->event_date }}" type="date" name="event_date" id="event_date"
                class="form-control" aria-describedby="tanggalId">
            <small id="tanggalId" class="text-muted d-none"></small>
        </div>
        <div class="form-group">
            <label for="tipe">Kategori Agenda</label>
            <input required value="{{ $event->event_type }}" name="event_type" id="event_type"
                placeholder="Perayaan / Upacara / Classmeet / Istighosah" type="text" class="form-control"
                aria-describedby="tipeId">
            <small id="tipeId" class="text-muted d-none"></small>
        </div>
        <div class="form-group">
            <label for="target">Lokasi</label>
            <input required value="{{ $event->event_location }}" name="event_location" id="event_location" type="text"
                class="form-control" placeholder="Lap Indoor / Masjid / Luar sekolah.." aria-describedby="targetId">
            <small id="targetId" class="text-muted d-none"></small>
        </div>
        <div class="form-group">
            <label for="text">Deskripsi Agenda</label>
            <textarea required name="event_text" id="event_text" cols="30" rows="10" class="form-control"
                placeholder="Isi dari event.." aria-describedby="textId">{{ $event->event_text }}</textarea>
            <small id="textId" class="text-muted d-none"></small>
        </div>
    </div>
@endsection