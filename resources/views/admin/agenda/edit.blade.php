@extends('layouts.main')

@section('title')
    <title>Agenda | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 pt-4">
    <a href="{{ route('event.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('event.update', ['token' => $token, 'event' => $event->id_event]) }}" method="post">
        @method('put')
        @csrf
        <div class="form-group">
            <label for="nama">event</label>
            <input value="{{$event->event_name}}" type="text" name="event_name" id="event_name" class="form-control @error('event_name') is-invalid @enderror" placeholder="Besok ada sesuatu..." aria-describedby="namaId">
            @error('event_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input value="{{$event->event_date}}" type="date" name="event_date" id="event_date" class="form-control @error('event_date') is-invalid @enderror" aria-describedby="tanggalId">
            @error('event_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="tanggalId" class="text-muted d-none"></small>
        </div>
        <div class="form-group">
            <label for="tipe">Kategori Agenda</label>
            <input value="{{$event->event_type}}" name="event_type" id="event_type" placeholder="Perayaan / Upacara / Classmeet / Istighosah" type="text" class="form-control @error('event_type') is-invalid @enderror" aria-describedby="tipeId">
            @error('event_type')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="tipeId" class="text-muted d-none"></small>
        </div>
        <div class="form-group">
            <label for="target">Lokasi</label>
            <input value="{{$event->event_location}}" name="event_location" id="event_location" type="text" class="form-control @error('event_location') is-invalid @enderror" placeholder="Lap Indoor / Masjid / Luar sekolah.." aria-describedby="targetId">
            @error('event_location')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <small id="targetId" class="text-muted d-none"></small>
        </div>
        <div class="form-group">
            <label for="text">Deskripsi Agenda</label>
            <textarea name="event_text" id="event_text" cols="30" rows="10" class="form-control @error('event_text') is-invalid @enderror" placeholder="Isi dari event.." aria-describedby="textId">{{$event->event_text}}</textarea>
            @error('event_text')
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
