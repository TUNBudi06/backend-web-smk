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
                        <h4 class="poppins mb-0">Logo Kemitraan</h4>
                        <p class="montserrat" style="font-size: .85rem;">Daftar Logo Kemitraan SMKN 1 Purwosari {{$count}}</p>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{route('logok.create',['token'=>$token])}}" class="btn-print btn btn-warning shadow-warning px-4 rounded-pill"><i class="fas fa-plus"></i> Tambah Logo</a>
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
                            <th>Logo</th>
                            <th>Nama Perusahaan</th>
                            <th>Tinggi Foto</th>
                            <th>Lebar Foto</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logoK as $key => $data)
                            <tr>
                                <td><img src="{{ asset(file_exists(public_path('img/mitra/' . $data->logo_mitra)) ? 'img/mitra/' . $data->logo_mitra : 'img/no_image.png') }}" width="100px" class="rounded" alt=""></td>
                                <td>{{ $data->nama_mitra }}</td>
                                <td>{{ $data->width }} Px</td>
                                <td>{{ $data->height }} Px</td>
                                <td>
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown">
                                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0"
                                                style="padding: 10px;">
                                                <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="{{route('logok.show',['token'=>$token,'id'=>$data->id_logo_mitra])}}"
                                                    class="dropdown-item text-warning"
                                                    onclick="event.stopPropagation(); onEdit('${full.bin_id}'); return false;"
                                                    style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                    <i class='fas fa-pen-alt mx-1 text-warning'></i> Edit
                                                </a>
                                                <form
                                                    action="{{ route('logok.destroy', ['token' => $token]) }}"
                                                    method="post" class="d-inline"
                                                    onclick="event.stopPropagation(); return confirm('Data akan dihapus ?')">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" value="{{ $data->id_logo_mitra }}"
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
                            @if($count > 10)
                                <form method="GET" id="show-form" name="showForm" action="">
                                    <div class="form-group d-inline-block">
                                        <input type="hidden" name="#">
                                        <select id="show-select" name="show" onchange="this.form.submit();" class="form-control form-control-sm d-inline-block" style="width:70px; font-size: .7rem;">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="40">40</option>
                                        </select>
                                    </div>
                                    <p class="montserrat d-inline" style="font-size: .7rem;">Data per halaman</p>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <p class="montserrat d-inline" style="font-size: .7rem;">{{ $logoK->firstItem() }} dari {{ $logoK->lastItem() }}</p>
                        <a href="{{ $logoK->previousPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $logoK->onFirstPage() ? 'disabled' : 'active' }}">
                            <i class="fas fa-caret-left text-warning"></i>
                        </a>
                        <a href="{{ $logoK->nextPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $logoK->hasMorePages() ? 'active' : 'disabled' }}">
                            <i class="fas fa-caret-right text-warning"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
