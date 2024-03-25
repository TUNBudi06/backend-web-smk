@extends('layouts.main')

@section('title')
    <title>event | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 pt-4">
    <a href="{{ route('event.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('event.update', ['token' => $token, 'event' => $event->id_event]) }}" method="post">
        @method('put')
        @csrf
        <div class="form-group">
            <label for="event_name">Agenda</label>
            <input type="text" name="event_name" id="event_name" value="{{ $event->event_name }}" class="form-control" placeholder="Besok ada sesuatu..." aria-describedby="nameId">
            <small id="nameId" class="text-muted">Hindari penggunaan slash (/,\)</small>
        </div>
        <div class="form-group">
            <label for="event_target">event Target</label>
            <input type="text" name="event_target" id="event_target" value="{{ $event->event_target }}" class="form-control" placeholder="Seluruh Jurusan / Hanya 1 Jurusan" aria-describedby="targetId">
            <small id="targetId" class="text-muted d-none"></small>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="event_date">Tanggal</label>
                    <input type="date" name="event_date" id="event_date" value="{{ $event->event_date }}" class="form-control" aria-describedby="tanggalId">
                    <small id="tanggalId" class="text-muted d-none"></small>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="event_time">Waktu</label>
                    <input type="time" name="event_time" id="event_time" value="{{ $event->event_time }}" class="form-control" aria-describedby="waktuId">
                    <small id="waktuId" class="text-muted d-none"></small>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="event_text">Deskripsi event</label>
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