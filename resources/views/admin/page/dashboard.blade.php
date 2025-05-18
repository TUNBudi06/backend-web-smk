@extends('layouts.main')

@section('title')
    <title>Dashboard | Admin Panel</title>
@endsection

@section('container')
    <div class="row mt-5">
        <div class="col-md-11 offset-md-1">
            <div class="row gy-4">
                <div class="col-md-3 mb-2"onclick="window.location.href='{{ route('pengumuman.index', ['token' => $token]) }}';">
                    <div class="count-card rounded px-4 py-3">
                        <p class="poppins mb-2"><i class="fas mr-2 fa-tachometer-alt"></i> Pengumuman</p>
                        <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{$pengumuman}}</span> Item</p>
                    </div>
                </div>
                <div class="col-md-3 mb-2" onclick="window.location.href='{{ route('event.index', ['token' => $token]) }}';" >
                    <div class="count-card rounded px-4 py-3">
                        <p class="poppins mb-2"><i class="fas mr-2 fa-bullhorn"></i>Agenda</p>
                        <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{$event}}</span> Item</p>
                    </div>
                </div>
                <div class="col-md-3 mb-2" onclick="window.location.href='{{ route('berita.index', ['token' => $token]) }}';">
                    <div class="count-card rounded px-4 py-3">
                        <p class="poppins mb-2"><i class="fas mr-2 fa-newspaper"></i>Berita</p>
                        <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{$berita}}</span> Item</p>
                    </div>
                </div>
                <div class="col-md-3 mb-2" onclick="window.location.href='{{ route('artikel.index', ['token' => $token]) }}';">
                    <div class="count-card rounded px-4 py-3">
                        <p class="poppins mb-2"><i class="fas mr-2 fa-book"></i>Artikel</p>
                        <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{$artikel}}</span> Item</p>
                    </div>
                </div>
                @if(session()->get('user')->role == 2)
                    <div class="col-md-12 mb-2">
                        <div class="{{session()->get('user')->role == 1 ? 'count-card' : ' count-comment bg-gray'}} rounded px-4 py-3 text-center">
                            <p class="poppins mb-0"><i class="fas mr-2 fa-user"></i>Tidak Tersedia Saat Ini</p>
                        </div>
                    </div>
                @endif
                <div class="col-md-3 mb-2"
                        @if(session()->get('user')->role == 1) onclick="window.location.href='{{ route('jurusan.index', ['token' => $token]) }}';" @endif>
                    <div class="{{session()->get('user')->role == 1 ? 'count-card' : ' count-comment bg-gray'}} rounded px-4 py-3">
                        <p class="poppins mb-2"><i class="fas mr-2 fa-pen-nib"></i>Jurusan</p>
                        <p class="montserrat mb-0" style="font-size: .8rem;">{{ $jurusan }}<span class="font-weight-bold"></span> Item</p>
                    </div>
                </div>
                <div class="col-md-3 mb-2"
                        @if(session()->get('user')->role == 1) onclick="window.location.href='{{ route('extra.index', ['token' => $token]) }}';" @endif>
                    <div class="{{session()->get('user')->role == 1 ? 'count-card' : ' count-comment bg-gray'}} rounded px-4 py-3">
                        <p class="poppins mb-2"><i class="fas mr-2 fa-school"></i>Ekstrakurikuler</p>
                        <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{$extra}}</span> Item</p>
                    </div>
                </div>
                <div class="col-md-3 mb-2"
                        @if(session()->get('user')->role == 1) onclick="window.location.href='{{ route('fasilitas.index', ['token' => $token]) }}';" @endif>
                    <div class="{{session()->get('user')->role == 1 ? 'count-card' : ' count-comment bg-gray'}} rounded px-4 py-3">
                        <p class="poppins mb-2"><i class="fas mr-2 fa-laptop"></i>Fasilitas</p>
                        <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{ $fasilitas }}</span> Item</p>
                    </div>
                </div>
                <div class="col-md-3 mb-2"
                        @if(session()->get('user')->role == 1) onclick="window.location.href='{{ route('pd.index', ['token' => $token]) }}';" @endif>
                    <div class="{{session()->get('user')->role == 1 ? 'count-card' : ' count-comment bg-gray'}} rounded px-4 py-3">
                        <p class="poppins mb-2"><i class="fas mr-2 fa-users"></i>Peserta didik</p>
                        <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{ $pd }}</span> Item</p>
                    </div>
                </div>
                <div class="col-md-3 mb-2"
                        @if(session()->get('user')->role == 1) onclick="window.location.href='{{ route('ptk.index', ['token' => $token]) }}';" @endif>
                    <div class="{{session()->get('user')->role == 1 ? 'count-card' : ' count-comment bg-gray'}} rounded px-4 py-3">
                        <p class="poppins mb-2"><i class="fas mr-2 fa-user-tie"></i>PTK</p>
                        <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{ $ptk }}</span> Item</p>
                    </div>
                </div>
                <div class="col-md-3 mb-2"
                        @if(session()->get('user')->role == 1) onclick="window.location.href='{{ route('gallery.index', ['token' => $token]) }}';" @endif>
                    <div class="{{session()->get('user')->role == 1 ? 'count-card' : ' count-comment bg-gray'}} rounded px-4 py-3">
                        <p class="poppins mb-2"><i class="fas mr-2 fa-images"></i>Galeri</p>
                        <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{$gallery}}</span> Item</p>
                    </div>
                </div>
                <div class="col-md-3 mb-2"
                        @if(session()->get('user')->role == 1) onclick="window.location.href='{{ route('aproved-user-log.index', ['token' => $token]) }}';" @endif>
                    <div class="{{session()->get('user')->role == 1 ? 'count-card' : ' count-comment bg-gray'}} rounded px-4 py-3">
                        <p class="poppins mb-2"><i class="fas mr-2 fa-clock"></i>Log Tertunda</p>
                        <p class="montserrat mb-0" style="font-size: .8rem;"><span class="font-weight-bold">{{$data_pending}}</span> Item</p>
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-md-8">
                    <h4 class="poppins mb-0">Log Tertunda</h4>
                    <p class="montserrat" style="font-size: .85rem;">Daftar Informasi Yang Tertunda
                    </p>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nama</th>
                            <th>level</th>
                            <th>Published By</th>
                            <th>Jurnal By</th>
                            <th>Category</th>
                            <th>Event</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_pending as $index => $data)
                            <tr>
                                @if ($data->tipe->id_pemberitahuan_type == 1)
                                    <td>
                                        <img src="{{ file_exists('img/artikel/' . $data->thumbnail) ? asset('img/artikel/' . $data->thumbnail) : asset('img/no_image.png') }}"
                                            width="150px" height="100px" class="rounded" alt="">
                                    </td>
                                @elseif ($data->tipe->id_pemberitahuan_type == 2)
                                    <td>
                                        <img src="{{ file_exists('img/announcement/' . $data->thumbnail) ? asset('img/announcement/' . $data->thumbnail) : asset('img/no_image.png') }}"
                                            width="150px" height="100px" class="rounded" alt="">
                                    </td>
                                @elseif ($data->tipe->id_pemberitahuan_type == 3)
                                    <td>
                                        <img src="{{ file_exists('img/berita/' . $data->thumbnail) ? asset('img/berita/' . $data->thumbnail) : asset('img/no_image.png') }}"
                                            width="150px" height="100px" class="rounded" alt="">
                                    </td>
                                @elseif ($data->tipe->id_pemberitahuan_type == 4)
                                    <td>
                                        <img src="{{ file_exists('img/event/' . $data->thumbnail) ? asset('img/event/' . $data->thumbnail) : asset('img/no_image.png') }}"
                                            width="150px" height="100px" class="rounded" alt="">
                                    </td>
                                @endif
                                <td>{{ $data->nama }}</td>
                                <td>
                                    <div class="{{ $data->level ? 'badge-danger' : 'badge-info' }}">
                                        {{ $data->level ? 'Penting' : 'Normal' }}</div>
                                </td>
                                <td>{{ $data->published_by ? $data->published_by : 'SuperAdmin' }}</td>
                                <td>{{ $data->jurnal_by ? $data->jurnal_by : '' }}</td>
                                <td>{{ $data->tipe->pemberitahuan_type_name }}</td>
                                <td>{{ $data->kategori->pemberitahuan_category_name }}</td>
                                <td>
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown">
                                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0"
                                                style="padding: 10px;">
                                                <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                @if ($data->tipe->id_pemberitahuan_type == 1)
                                                    <a href="{{ route('artikel.show', ['artikel' => $data->id_pemberitahuan, 'token' => $token]) }}"
                                                        class="dropdown-item text-info"
                                                        style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                        <i class="fas fa-eye mx-1 text-info"></i> View
                                                    </a>
                                                @elseif($data->tipe->id_pemberitahuan_type == 2)
                                                    <a href="{{ route('pengumuman.show', ['pengumuman' => $data->id_pemberitahuan, 'token' => $token]) }}"
                                                        class="dropdown-item text-info"
                                                        style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                        <i class="fas fa-eye mx-1 text-info"></i> Viewman
                                                    </a>
                                                @elseif($data->tipe->id_pemberitahuan_type == 3)
                                                    <a href="{{ route('berita.show', ['berita' => $data->id_pemberitahuan, 'token' => $token]) }}"
                                                        class="dropdown-item text-info"
                                                        style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                        <i class="fas fa-eye mx-1 text-info"></i> View </a>
                                                @else
                                                    <a href="{{ route('event.show', ['event' => $data->id_pemberitahuan, 'token' => $token]) }}"
                                                        class="dropdown-item text-info"
                                                        style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                        <i class="fas fa-eye mx-1 text-info"></i> View </a>
                                                @endif

                                                <a href="{{ route('aproved-user-log.approved', ['id' => $data->id_pemberitahuan, 'token' => $token]) }}"
                                                    class="dropdown-item text-success"
                                                    style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                    <i class="fas fa-check-square mx-1 text-success"></i> Approve
                                                </a>

                                                <form
                                                    action="{{ route('aproved-user-log.deleted', ['id' => $data->id_pemberitahuan, 'token' => $token]) }}"
                                                    method="post" class="d-inline"
                                                    onclick="return confirm('Data akan dihapus?')">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        style="padding-bottom: 10px; padding-top: 10px; text-align: center; font-weight: 600;">
                                                        <i class="fas fa-trash mx-1 text-danger"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
