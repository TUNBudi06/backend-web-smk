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
                            <th>Tombol</th>
                            <th>Subjudul</th>
                            <th>Deskripsi Konten</th>
                            <th>Multiple Badges</th>
                            <th>Tombol Konten</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($elearning as $key => $data)
                            <tr>
                                <td><img src="{{ asset(file_exists(public_path('img/e-learning/' . $data->thumbnail)) ? 'img/e-learning/' . $data->thumbnail : 'img/no_image.png') }}" width="100px"
                                        class="rounded" alt=""></td>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->desc }}</td>
                                <td>Tampilan button(label, url, icon)</td>
                                <td>{{ $data->subtitle }}</td>
                                <td>{{ $data->body_desc }}</td>
                                <td>Tampilan beberapa badges</td>
                                <td>Tampilan button konten</td>
                                <td>
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown">
                                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0"
                                                style="padding: 10px;">
                                                <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="{{ route('elearning.edit', ['elearning' => $data->id_extra, 'token' => $token]) }}"
                                                    class="dropdown-item text-warning"
                                                    onclick="event.stopPropagation(); onEdit('${full.bin_id}'); return false;"
                                                    style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                    <i class='fas fa-pen-alt mx-1 text-warning'></i> Edit
                                                </a>
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
