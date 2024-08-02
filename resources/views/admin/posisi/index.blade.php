@extends('layouts.main')

@section('title')
    <title>Posisi | Admin Panel</title>
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
            @if ($action == "update" && session('positions'))
            <div class="col-md-4 offset-md-1 mt-4 p-2">
                <div class="w-100 rad bg-white position-relative shadow py-3 px-4">
                    <h5 class="poppins mb-0">Update Posisi</h5>
                    <form action="{{ route('posisi.update', ['token' => $token, 'posisi' => session('positions')->id_position]) }}" method="post">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="nama" class="mt-3 mb-2">Nama Posisi</label>
                            <input type="text" required value="{{ session('positions')->position_name }}" name="position_name" id="position_name" class="form-control" placeholder="Operator, dsb">
                        </div>
                        <div class="form-group">
                            <label for="tipe" class="my-2">Tipe Posisi</label>
                            <input type="text" required value="{{ session('positions')->position_type }}" name="position_type" id="position_type" class="form-control" placeholder="Full Time, dsb">
                        </div>
                        <div class="text-right w-100 position-absolute" style="right: 10px;">
                            <a href="{{ route('posisi.create', ['token' => $token]) }}" class="btn btn-white px-4 rounded-pill border-warning">Tambah</a>
                            <button class="btn btn-warning px-4 rounded-pill shadow-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="col-md-4 offset-md-1 mt-4 p-2">
                <div class="w-100 rad bg-white position-relative shadow py-3 px-4">
                    <h5 class="poppins mb-0">Tambah Posisi</h5>
                    <form action="{{ route('posisi.store', ['token' => $token]) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama" class="mt-3 mb-2">Nama Posisi</label>
                            <input type="text" required name="position_name" id="position_name" class="form-control" placeholder="Operator, dsb">
                        </div>
                        <div class="form-group">
                            <label for="tipe" class="mt-3 mb-2">Tipe Posisi</label>
                            <input type="text" required name="position_type" id="position_type" class="form-control" placeholder="Full Time, dsb">
                        </div>
                        <div class="text-right w-100">
                            <button class="btn btn-warning px-4 rounded-pill shadow-warning position-absolute" style="right: 10px;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            <div class="col-md-6 mt-4 p-2">
                <div class="w-100 table-parent bg-white">
                    <div class="row p-4">
                        <div class="col-md-8">
                            <h4 class="poppins mb-0">Posisi</h4>
                            <p class="montserrat" style="font-size: .85rem;">Daftar Posisi Kerja untuk Kemitraan
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('kemitraan.index', ['token' => $token]) }}" class="btn-print btn btn-white border-warning px-3 rounded-pill"><i class="fas fa-newspaper"></i> Kembali</a>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Posisi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($positions as $data)
                            <tr>
                                <td>{{ $data->position_name }}</td>
                                <td>
                                    <a href="{{ route('posisi.edit', ['posisi' => $data->id_position, 'token' => $token]) }}" class="btn btn-success p-2"><i class="fas fa-pen-alt"></i></a>
                                    <form action="{{ route('posisi.destroy', ['posisi' => $data->id_position, 'token' => $token]) }}" method="post" class="d-inline" onclick="return confirm('Posisi akan dihapus?')">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger p-2"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <script>
                        $('.check-toggle').change(function() {
                            if(this.checked) {
                                $('.btn-print').removeAttr('disabled').removeClass('disabled')
                                $('.check-respond').prop('checked', true);
                            } else {
                                $('.btn-print').addClass('disabled').attr('disabled')
                                $('.check-respond').prop('checked', false);
                            }
                        });
                        $('input[name="checkPrint[]"]').change(function() {
                            var atLeastOneIsChecked = $('input[name="checkPrint[]"]:checked').length > 0;
                            if(atLeastOneIsChecked) {
                                $('.btn-print').removeAttr('disabled').removeClass('disabled')
                            } else {
                                $('.btn-print').addClass('disabled').attr('disabled')
                            }
                        });
                    </script>
                    <div class="row px-3">
                        <div class="col-md-6">
                            <div class="pb-3">
                                <form method="GET" id="show-form" name="showForm" action="">
                                    <div class="form-group d-inline-block">
                                        <input type="hidden" name="page" value="">
                                        <input type="hidden" name="id_category" value="">
                                        <input type="hidden" name="action" value="">
                                        <select id="show-select" name="show" onchange="showData()" class="form-control form-control-sm d-inline-block"
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
                                {{ $positions->count() }} dari {{ $positions->count() }} data</p>
                            <a href="#" class="btn btn-sm p-0 px-2 btn-white disabled"><i class="fas fa-caret-left text-warning"></i></a>
                            <a href="#" class="btn btn-sm p-0 px-2 btn-white active">
                                <i class="fas fa-caret-right text-warning"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection