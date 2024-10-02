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
                    <div class="col-11">
                        <table id="table">
                            <thead>
                            <tr>
                                <th>no</th>
                                <th>id_pa</th>
                                <th>title</th>
                                <th>description</th>
                                <th>type</th>
                                <th>url</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pa as $index => $data)
                                <tr>
                                    <td>{{ $index }}</td>
                                    <td>{{ $data->id_pa }}</td>
                                    <td>{{$data->title}}</td>
                                    <td>{{$data->description}}</td>
                                    <td>{{$data->type}}</td>
                                    <td>
                                        {{$data->url}}
                                    </td>
                                    <td>
                                        <a href="{{ route('tools.edit', ['token' => $token, 'id' => $data->id_pa]) }}"
                                           class="btn btn-warning px-4 shadow-warning">Edit</a>
                                        <form action="{{ route('tools.destroy', ['token' => $token]) }}"
                                              method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" value="{{$data->id_pa}}" name="'idName">
                                            <button type="submit" class="btn btn-danger px-4 shadow-danger">Hapus</button>
                                        </form>
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
