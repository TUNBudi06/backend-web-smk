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
        @if (Session::get('success'))
            <div class="position-fixed w-100 alert alert-success alert-dismissible fade show"
                 style="top: 0px; left: 0px; z-index: 1000 !important;" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif
        <div class="row">
            <div class="col-md-11 offset-md-1 p-2">
                @include('admin.partials.nav_link')
                <div class="w-100 table-parent bg-white">
                    <div class="row p-4">
                        <div class="col-md-8">
                            <h4 class="poppins mb-0">Informasi Dasar</h4>
                            <p class="montserrat" style="font-size: .85rem;">Ubah informasi dasar tentang sekolah
                            </p>
                        </div>
                    </div>

                    <table id="table" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Icon</th>
                                <th>Informasi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($basic as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>{{ $data->name }}</td>
                                    <td>
                                        @if($data->logo)
                                            <img src="{{ asset($data->logo) }}"
                                                 alt="{{ $data->name }}"
                                                 class="img-fluid"
                                                 style="width: 40px; height: 40px; object-fit: contain;">
                                        @else
                                            <span class="text-muted">No icon</span>
                                        @endif
                                    </td>
                                    <td>{{$data->url}}</td>
                                    <td class="text-center">
                                        <a href="{{route('basic.show', ['token' => $token, 'id' => $data->id])}}"
                                           class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                        <a href="{{route('basic.edit', ['token' => $token, 'id' => $data->id])}}"
                                           class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="row px-3">
                        <div class="col-md-6">
                            <div class="pb-3">
                                <form method="GET" id="show-form" name="showForm" action="">
                                    <div class="form-group d-inline-block">
                                        <input type="hidden" name="page" value="">
                                        <input type="hidden" name="id_category" value="">
                                        <input type="hidden" name="action" value="">
                                        <select id="show-select" name="show" onchange="showData()"
                                                class="form-control form-control-sm d-inline-block"
                                                style="width:70px; font-size: .7rem;">
                                            <option value="10" selected>10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="40">40</option>
                                        </select>
                                    </div>
                                    <p class="montserrat d-inline" style="font-size: .7rem;">Data per halaman</p>
                                    <script>
                                        function showData() {
                                            $('#show-select').change(function() {
                                                var value = $(this).val();
                                                $('#show-form').submit()
                                            });
                                        }
                                    </script>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <p class="montserrat d-inline" style="font-size: .7rem;">
                                {{ $basic->count() }} dari {{ $basic->count() }} data</p>
                            <a href="#" class="btn btn-sm p-0 px-2 btn-white disabled"><i
                                    class="fas fa-caret-left text-warning"></i></a>
                            <a href="#" class="btn btn-sm p-0 px-2 btn-white active"><i
                                    class="fas fa-caret-right text-warning"></i></a>
                        </div>
                    </div>
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
