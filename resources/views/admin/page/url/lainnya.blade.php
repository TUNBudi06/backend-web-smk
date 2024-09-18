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
            <div class="col-md-8 offset-md-2 mt-4 p-2">
                @include('admin.partials.nav_profile')
                <div class="w-100 table-parent bg-white">
                    <div class="row p-4">
                        <div class="col-md-8">
                            <h4 class="poppins mb-0">Komite</h4>
                            <p class="montserrat" style="font-size: .85rem;">Daftar Komite untuk URL
                            </p>
                        </div>
                    </div>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>no</th>
                                <th>id_link</th>
                                <th>title</th>
                                <th>description</th>
                                <th>jenis</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($other as $index => $data)
                            <tr>
                                <td>{{ $index }}</td>
                                <td>{{ $data->id_link }}</td>
                                <td>{{$data->title}}</td>
                                @if($data->type == 'text')
                                    <td>Text</td>
                                @elseif($data->type == 'file')
                                    <td>{{$data->description}}</td>
                                @else
                                    <td>Link</td>
                                @endif
                                <td>
                                    {{$data->type}}
                                </td>
                                <td>
                                    <a href="{{ route('lainnya.show', ['token' => $token, 'id' => $data->id_link]) }}"
                                       class="btn btn-info px-4 shadow-info">Detail</a>
                                    <a href="{{ route('lainnya.edit', ['token' => $token, 'id' => $data->id_link]) }}"
                                       class="btn btn-warning px-4 shadow-warning">Edit</a>
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
