@extends('layouts.main')

@section('title')
    <title>E-Learning | Admin Panel</title>
@endsection

@section('container')
    <div class="row">
        <div class="col-md-11 offset-md-1">
            @include('admin.partials.nav_academic')
            <div class="w-100 table-parent bg-white">
                <div class="row p-4">
                    <div class="col-md-8">
                        <h4 class="poppins mb-0">E-Learning</h4>
                        <p class="montserrat" style="font-size: .85rem;">E-Learning SMKN 1 Purwosari
                        </p>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('elearning.create', ['token' => $token]) }}" class="btn-print btn btn-warning shadow-warning px-4 rounded-pill"><i class="fas fa-plus"></i> E-Learning Baru</a>
                        <a href="{{ route('badge.index',$token) }}" class="btn-print btn btn-white border-warning px-3 rounded-pill"><i class="fas fa-columns mr-1"></i> Badges</a>
                    </div>
                </div>
                @if (Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>{{ Session::get('success') }}</strong>
                    </div>
                @endif
                <table class="table">
                    <thead>
                        <tr>
                            <th class="pl-4">Thumbnail</th>
                            <th>Judul</th>
                            <th>Deskripsi Utama</th>
                            <th>Subjudul</th>
                            <th>Deskripsi Konten</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($elearning as $key => $data)
                            <tr>
                                <td><img src="{{ asset(file_exists(public_path('img/e-learning/' . $data->thumbnail)) ? 'img/e-learning/' . $data->thumbnail : 'img/no_image.png') }}" width="100px"
                                        class="rounded" alt=""></td>
                                <td>{{ $data->title }}</td>
                                <td>{{ Str::limit($data->desc, 50, '...') }}</td>
                                <td>{{ $data->subtitle }}</td>
                                <td>{{ Str::limit($data->body_desc, 50, '...') }}</td>
                                <td>
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown">
                                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0"
                                                style="padding: 10px;">
                                                <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="{{ route('elearning.show', ['elearning' => $data->id, 'token' => $token]) }}"
                                                    class="dropdown-item text-info"
                                                    style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                    <i class='fas fa-eye mx-1 text-info'></i> Show
                                                </a>
                                                <a href="{{ route('elearning.edit', ['elearning' => $data->id, 'token' => $token]) }}"
                                                    class="dropdown-item text-warning"
                                                    onclick="event.stopPropagation(); onEdit('${full.bin_id}'); return false;"
                                                    style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                    <i class='fas fa-pen-alt mx-1 text-warning'></i> Edit
                                                </a>
                                                <form
                                                    action="{{ route('elearning.destroy', ['elearning' => $data->id, 'token' => $token]) }}"
                                                    method="post" class="d-inline"
                                                    onclick="event.stopPropagation(); return confirm('Data akan dihapus ?')">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" value="{{ $data->id }}"
                                                        name="idName">
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        style="padding-bottom: 10px; padding-top: 10px; text-align: center; font-weight: 600;">
                                                        <i class='fas fa-trash mx-1 text-danger'></i> Delete
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
