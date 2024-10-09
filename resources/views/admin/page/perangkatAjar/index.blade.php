@extends('layouts.main')

@section('title')
    <title> Profile Lainnya | Admin Panel</title>
    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js
"></script>
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css
" rel="stylesheet">
@endsection

@section('container')
    <div class="container-fluid">
        @if(Session::get('success'))
        <div class="position-fixed w-100 alert alert-success alert-dismissible fade show" style="top: 0px; left: 0px; z-index: 1000 !important;" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>{{ Session::get('success') }}</strong>
        </div>
        @endif
        <div class="row">
            <div class="col-md-11 offset-md-1 mt-4 p-2">
                @include('admin.partials.nav_academic')
                <div class="w-100 table-parent bg-white">
                    <div class="row p-4">
                        <div class="col-md-8">
                            <h4 class="poppins mb-0">Perangkat Ajar</h4>
                            <p class="montserrat" style="font-size: .85rem;">Daftar Perangkat Ajar SMKN 1 Purwosari
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('tools.create', ['token' => $token]) }}"
                               class="btn  rounded-1 btn-warning px-4 shadow-warning">Tambah</a>
                        </div>
                    </div>
                    <div class="table-responsive w-100">
                        <table id="table" class="table table-row-bordered gy-5 w-100">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>URL</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pa as $index => $data)
                                <tr>
                                    <td style="text-align: start;">{{ $index + 1 }}</td>
                                    <td>{{ $data->title }}</td>
                                    <td>{{ Str::limit($data->description) }}</td>
                                    <td>{{ $data->type }}</td>
                                    <td style="text-align: start;">{{ isset($data->size) ? $data->size . ' MB' : '-' }}</td>
                                    <td>{{ Str::limit($data->url, 50) }}</td>
                                    <td>
                                        <ul class="navbar-nav">
                                            <li class="nav-item dropdown">
                                                <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0" style="padding: 10px;">
                                                    <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="{{ route('tools.edit', ['token' => $token, 'id' => $data->id_pa]) }}" class="dropdown-item text-warning" onclick="event.stopPropagation(); onEdit('${full.bin_id}'); return false;" style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                        <i class='fas fa-pen-alt mx-1 text-warning'></i> Edit
                                                    </a>
                                                    <form action="{{ route('tools.destroy', ['token' => $token]) }}"
                                                          method="post" class="d-inline"
                                                          onclick="event.stopPropagation(); return confirm('Data akan dihapus ?')">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" value="{{$data->id_pa}}" name="idName">
                                                        <button type="submit" class="dropdown-item text-danger" style="padding-bottom: 10px; padding-top: 10px; text-align: center; font-weight: 600;">
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
                            $(document).ready(function () {
                                $('#table').DataTable()
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            @if(Session::get('success'))
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
