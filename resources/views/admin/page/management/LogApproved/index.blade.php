@extends('layouts.main')

@section('title')
    <title>User Management | Admin Panel</title>
@endsection

@section('container')
    <div class="row">
        <div class="col-md-11 offset-md-1 mt-4 p-2">
            <div class="menu-profile-admin mb-4">
                <a href="{{ route('user.index', $token) }}"
                    class="<?= \Illuminate\Support\Facades\Route::is('user.index') ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning' ?>">User</a>
                <a href="{{ route('aproved-user-log.index', $token) }}"
                    class="<?= \Illuminate\Support\Facades\Route::is('aproved-user-log.index') ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning' ?>">Log
                    Pending</a>
            </div>
            <div class="w-100 table-parent bg-white">
                <div class="row p-4">
                    <div class="col-md-8">
                        <h4 class="poppins mb-0">Log Pending View</h4>
                        <p class="montserrat" style="font-size: .85rem;">Daftar Informasi Yang Pending View
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
                <div class="col-11">
                    <table id="table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Nama</th>
                                <th>level</th>
                                <th>published By</th>
                                <th>Jurnal By</th>
                                <th>Category</th>
                                <th>Event</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pending as $index => $data)
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
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#table').DataTable();
                            });
                        </script>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
