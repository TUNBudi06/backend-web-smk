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
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown">
                                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0"
                                                style="padding: 10px;">
                                                <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="{{ route('kemitraan.edit', ['kemitraan' => $data->id_kemitraan, 'token' => $token]) }}"
                                                    class="dropdown-item text-warning"
                                                    onclick="event.stopPropagation(); onEdit('${full.bin_id}'); return false;"
                                                    style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                    <i class='fas fa-pen-alt mx-1 text-warning'></i> Edit
                                                </a>
                                                <form
                                                    action="{{ route('kemitraan.destroy', ['kemitraan' => $data->id_kemitraan, 'token' => $token]) }}"
                                                    method="post" class="d-inline"
                                                    onclick="event.stopPropagation(); return confirm('Data akan dihapus ?')">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" value="{{ $data->id_gallery }}"
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
                <div class="row px-3">
                    <div class="col-md-6">
                        <div class="pb-3">
                            @if ($count > 10)
                                <form method="GET" id="show-form" name="showForm" action="{{ url()->current() }}">
                                    <div class="form-group d-inline-block">
                                        <input type="hidden" name="page" value="{{ request('page', 1) }}">
                                        <select id="show-select" name="show" onchange="this.form.submit()"
                                            class="form-control form-control-sm d-inline-block"
                                            style="width:70px; font-size: .7rem;">
                                            <option value="10" {{ request('show') == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="20" {{ request('show') == 20 ? 'selected' : '' }}>20
                                            </option>
                                            <option value="30" {{ request('show') == 30 ? 'selected' : '' }}>30
                                            </option>
                                            <option value="40" {{ request('show') == 40 ? 'selected' : '' }}>40
                                            </option>
                                        </select>
                                    </div>
                                    <p class="montserrat d-inline" style="font-size: .7rem;">Data per halaman</p>
                                </form>
                            @endif
                        </div>
                    </div>
                    @if ($count > request('show') && $count > 10)
                        <div class="col-md-6 text-right">
                            <p class="montserrat d-inline" style="font-size: .7rem;">{{ $kemitraan->firstItem() }} dari
                                {{ $kemitraan->lastItem() }}</p>
                            <a href="{{ $kemitraan->appends(['show' => request('show')])->previousPageUrl() }}"
                                class="btn btn-sm p-0 px-2 btn-white {{ $kemitraan->onFirstPage() ? 'disabled' : 'active' }}">
                                <i class="fas fa-caret-left text-warning"></i>
                            </a>
                            <a href="{{ $kemitraan->appends(['show' => request('show')])->nextPageUrl() }}"
                                class="btn btn-sm p-0 px-2 btn-white {{ $kemitraan->hasMorePages() ? 'active' : 'disabled' }}">
                                <i class="fas fa-caret-right text-warning"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#show-select').change(() => {
            $('input[name="page"]').val(1);
            $('#show-form').submit();
        });
    </script>
@endsection
