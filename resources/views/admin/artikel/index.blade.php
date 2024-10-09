@extends('layouts.main')

@section('title')
    <title>Artikel | Admin Panel</title>
@endsection

@section('container')
    <div class="row">
        <div class="col-md-11 offset-md-1 mt-4 p-2">
            @include('admin.partials.nav_information')
            <div class="w-100 table-parent bg-white">
                <div class="row p-4">
                    <div class="col-md-8">
                        <h4 class="poppins mb-0">Artikel</h4>
                        <p class="montserrat" style="font-size: .85rem;">Daftar Artikel SMKN 1 Purwosari
                        </p>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('artikel.create', ['token' => $token]) }}"
                            class="btn-print btn btn-warning shadow-warning px-5 rounded-pill"><i class="fas fa-plus"></i>
                            Artikel Baru</a>
                        <a href="{{ route('artikel.category.index', $token) }}"
                            class="btn-print btn btn-white border-warning px-3 rounded-pill"><i class="fas fa-list"></i>
                            Kategori</a>
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
                <div class="table-responsive w-100">
                    <table id="table" class="table table-row-bordered gy-5 w-100">
                        <thead>
                            <tr>
                                <th>Thumbnail</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Tanggal upload</th>
                                <th>Dilihat</th>
                                <th>disutujui oleh</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($artikel as $key => $data)
                                <tr>
                                    <td><img src="{{ asset('img/artikel/' . $data->thumbnail) }}" width="120px"
                                            height="60px" class="rounded" alt=""></td>
                                    <td style="word-wrap: break-word; max-width: 230px;">{{ $data->nama }}</td>
                                    <td>{{ $data->kategori ? $data->kategori->pemberitahuan_category_name : 'No Category' }}
                                    </td>
                                    <td style="word-wrap: break-word; max-width: 150px;">{{ $data->created_at }}</td>
                                    <td>
                                        <div class="{{ $data->approved ? 'badge-success' : 'badge-warning' }}">
                                            {{ $data->approved ? 'Publik' : 'Pending' }}</div>
                                    </td>
                                    <td>{{ $data->approved ? ($data->Approved_by ? $data->Approved_by : 'SuperAdmin') : 'Belum Disetujui' }}
                                    </td>
                                    <td>
                                        <ul class="navbar-nav">
                                            <li class="nav-item dropdown">
                                                <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0"
                                                    style="padding: 10px;">
                                                    <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="{{ route('artikel.show', ['artikel' => $data->id_pemberitahuan, 'token' => $token]) }}"
                                                        class="dropdown-item text-info"
                                                        onclick="event.stopPropagation(); onEdit('${full.bin_id}'); return false;"
                                                        style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                        <i class='fas fa-eye mx-1 text-info'></i> Show
                                                    </a>
                                                    <a href="{{ route('artikel.edit', ['artikel' => $data->id_pemberitahuan, 'token' => $token]) }}"
                                                        class="dropdown-item text-warning"
                                                        onclick="event.stopPropagation(); onEdit('${full.bin_id}'); return false;"
                                                        style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                        <i class='fas fa-pen-alt mx-1 text-warning'></i> Edit
                                                    </a>
                                                    <form
                                                        action="{{ route('artikel.destroy', ['artikel' => $data->id_pemberitahuan, 'token' => $token]) }}"
                                                        method="post" class="d-inline"
                                                        onclick="event.stopPropagation(); return confirm('Data akan dihapus ?')">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" value="{{ $data->id_pemberitahuan }}"
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
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#table').DataTable()
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            @if (Session::get('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ Session::get('success') }}',
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif
        });
    </script>
@endsection
