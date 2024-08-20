@extends('layouts.main')

@section('title')
    <title>Kemitraan | Admin Panel</title>
@endsection

@section('container')
    <div class="row">
        <div class="col-md-11 offset-md-1">
            @include('admin.partials.nav_kemitraan')
            <div class="w-100 table-parent bg-white">
                <div class="row p-4">
                    <div class="col-md-8">
                        <h4 class="poppins mb-0">Kemitraan</h4>
                        <p class="montserrat" style="font-size: .85rem;">Daftar Kemitraan SMKN 1 Purwosari</p>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('kemitraan.create', ['token' => $token]) }}" class="btn-print btn btn-warning shadow-warning px-4 rounded-pill"><i class="fas fa-plus"></i> Tambah Kemitraan</a>
                        <a href="{{ route('posisi.index',$token) }}" class="btn-print btn btn-white border-warning px-3 rounded-pill"><i class="fas fa-list"></i> Posisi Baru</a>
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
                            <th>Logo</th>
                            <th>Nama Perusahaan</th>
                            <th>Deskripsi</th>
                            <th>Lokasi Perusahaan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kemitraan as $key => $data)
                            <tr>
                                <td><img src="{{ asset(file_exists(public_path('img/kemitraan/cover/' . $data->kemitraan_thumbnail)) ? 'img/kemitraan/cover/' . $data->kemitraan_thumbnail : 'img/no_image.png') }}" width="100px" class="rounded" alt=""></td>
                                <td><img src="{{ asset(file_exists(public_path('img/kemitraan/logo/' . $data->kemitraan_logo)) ? 'img/kemitraan/logo/' . $data->kemitraan_logo : 'img/no_image.png') }}" width="100px" class="rounded" alt=""></td>
                                <td>{{ $data->kemitraan_name }}</td>
                                <td>{{ Str::limit(strip_tags(str_replace(["\r", "\n"], '', $data->kemitraan_description)), 30, '...') }}</td>
                                <td>{{ $data->kemitraan_city }}</td>
                                <td>
                                    <a href="#" target="_blank" class="btn btn-warning p-2"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('kemitraan.edit', ['kemitraan' => $data->id_kemitraan, 'token' => $token]) }}" class="btn btn-success p-2"><i class="fas fa-pen-alt"></i></a>
                                    <form action="{{ route('kemitraan.destroy', ['kemitraan' => $data->id_kemitraan, 'token' => $token]) }}" method="post" class="d-inline" onclick="return confirm('Kemitraan akan dihapus?')">
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
                        if (this.checked) {
                            $('.btn-print').removeAttr('disabled').removeClass('disabled')
                            $('.check-respond').prop('checked', true);
                        } else {
                            $('.btn-print').addClass('disabled').attr('disabled')
                            $('.check-respond').prop('checked', false);
                        }
                    });
                    $('input[name="checkPrint[]"]').change(function() {
                        var atLeastOneIsChecked = $('input[name="checkPrint[]"]:checked').length > 0;
                        if (atLeastOneIsChecked) {
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
                                    <input type="hidden" name="#">
                                    <select id="show-select" name="show" onchange="showData()" class="form-control form-control-sm d-inline-block" style="width:70px; font-size: .7rem;" name="" id="">
                                        <option value="10">10</option>
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
                        <p class="montserrat d-inline" style="font-size: .7rem;">{{ $kemitraan->firstItem() }} dari {{ $kemitraan->lastItem() }}</p>
                        <a href="{{ $kemitraan->previousPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $kemitraan->onFirstPage() ? 'disabled' : 'active' }}">
                            <i class="fas fa-caret-left text-warning"></i>
                        </a>
                        <a href="{{ $kemitraan->nextPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $kemitraan->hasMorePages() ? 'active' : 'disabled' }}">
                            <i class="fas fa-caret-right text-warning"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection