@extends('layouts.main')

@section('title')
    <title>Dashboard | Admin Panel</title>
@endsection

@section('container')
        <div class="row pb-3">
            <div class="col-md-11 offset-md-1">
                <div class="row gy-4">
                    <div class="col-md-6 mb-2" onclick="window.location.href='{{ route('pengumuman.index', ['token' => $token]) }}';">
                        <div class="count-card rounded p-3">
                            <p class="poppins mb-0"><i class="fas mr-2 fa-tachometer-alt"></i> Pengumuman</p>
                            <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{$pengumuman}}</span> Item</p>
                        </div>
                    </div>
                    <div class="col-md-6" onclick="window.location.href='{{ route('event.index', ['token' => $token]) }}';">
                        <div class="count-card rounded p-3">
                            <p class="poppins mb-0"><i class="fas mr-2 fa-bullhorn"></i>Agenda</p>
                            <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{$event}}</span> Item</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2" onclick="window.location.href='{{ route('berita.index', ['token' => $token]) }}';">
                        <div class="count-card rounded p-3">
                            <p class="poppins mb-0"><i class="fas mr-2 fa-newspaper"></i>Berita</p>
                            <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{$berita}}</span> Item</p>
                        </div>
                    </div>
                    <div class="col-md-6" onclick="window.location.href='{{ route('artikel.index', ['token' => $token]) }}';">
                        <div class="count-card rounded p-3">
                            <p class="poppins mb-0"><i class="fas mr-2 fa-book"></i>Artikel</p>
                            <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{$artikel}}</span> Item</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2" onclick="window.location.href='{{ route('gallery.index', ['token' => $token]) }}';">
                        <div class="count-card rounded p-3">
                            <p class="poppins mb-0"><i class="fas mr-2 fa-images"></i>Gallery</p>
                            <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{$gallery}}</span> Item</p>
                        </div>
                    </div>
                    <div class="col-md-6" onclick="window.location.href='{{ route('extra.index', ['token' => $token]) }}';">
                        <div class="count-card rounded p-3">
                            <p class="poppins mb-0"><i class="fas mr-2 fa-school"></i>Extrakurikuler</p>
                            <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{$extra}}</span> Item</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2" onclick="window.location.href='{{ route('fasilitas.index', ['token' => $token]) }}';">
                        <div class="count-card rounded p-3">
                            <p class="poppins mb-0"><i class="fas mr-2 fa-laptop"></i>Fasilitas</p>
                            <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{ $fasilitas }}</span> Item</p>
                        </div>
                    </div>
                    <div class="col-md-6" onclick="window.location.href='{{ route('pd.index', ['token' => $token]) }}';">
                        <div class="count-card rounded p-3">
                            <p class="poppins mb-0"><i class="fas mr-2 fa-users"></i>Peserta didik</p>
                            <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{ $pd }}</span> Item</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2" onclick="window.location.href='{{ route('ptk.index', ['token' => $token]) }}';">
                        <div class="count-card rounded p-3">
                            <p class="poppins mb-0"><i class="fas mr-2 fa-user-tie"></i>PTK</p>
                            <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{ $ptk }}</span> Item</p>
                        </div>
                    </div>
                    <div class="col-md-6" onclick="window.location.href='{{ route('links', ['token' => $token]) }}';">
                        <div class="count-card rounded p-3">
                            <p class="poppins mb-0"><i class="fas mr-2 fa-link"></i>Links</p>
                            <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold"></span> Item</p>
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
        </div>
@endsection
