@extends('layouts.main')

@section('title')
    <title> Footer Navigation | Admin Panel</title>
@endsection

@section('container')
    <div class="container-fluid">
        @if (Session::get('success'))
            <div class="position-fixed w-100 alert alert-success alert-dismissible fade show"
                style="top: 0px; left: 0px; z-index: 1000 !important;" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif
        <div class="row">
            <div class="offset-md-1 col-12">
                @include('admin.partials.nav_link')
            </div>
            @if ($action == 'update')
                <div class="col-md-4 offset-md-1 mt-4 p-2">
                    <div class="w-100 rad bg-white position-relative shadow py-3 px-4">
                        <h5 class="poppins mb-0">Update Footer</h5>
                        <form action="{{ route('footer.update', ['token' => $token]) }}" method="post">
                            @method('PATCH')
                            @csrf
                            <div class="form-group">
                                <input type="hidden" value="{{ $footer->id_footer }}" name="idName" id="idName"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="label" class="mt-3 mb-2">Label</label>
                                <input type="text" name="label" id="label" value="{{ $footer->label }}"
                                    class="form-control @error('Label') is-invalid @enderror"
                                    placeholder="Pelayanan / Berita">
                                @error('Label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="url" class="mt-3 mb-2">URL</label>
                                <input type="url" name="url" id="url" value="{{ $footer->url }}"
                                    class="form-control @error('url') is-invalid @enderror" placeholder="http://...">
                                @error('url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="footer_tipe" class="mt-3 mb-2">Pilih Tipe Footer</label>
                                <select class="form-control @error('footer_tipe') is-invalid @enderror" name="footer_tipe"
                                    id="footer_tipe">
                                    <option value="1" {{ $footer->type == '1' ? 'selected' : '' }}>Unit Produksi
                                        Sekolah
                                    </option>
                                    <option value="2" {{ $footer->type == '2' ? 'selected' : '' }}>Aplikasi & Layanan
                                    </option>
                                    <option value="3" {{ $footer->type == '3' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('footer_tipe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-right w-100">
                                <button class="btn btn-warning px-4 rounded-pill shadow-warning position-absolute"
                                    style="right: 10px;">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="col-md-4 offset-md-1 mt-4 p-2">
                    <div class="w-100 rad bg-white position-relative shadow py-3 px-4">
                        <h5 class="poppins mb-0">Tambah Footer</h5>
                        <form action="{{ route('footer.store', ['token' => $token]) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="label" class="mt-3 mb-2">Label</label>
                                <input type="text" name="label" id="label"
                                    class="form-control @error('Label') is-invalid @enderror"
                                    placeholder="Nama / Link">
                                @error('Label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="url" class="mt-3 mb-2">URL</label>
                                <input type="url" name="url" id="url"
                                    class="form-control @error('url') is-invalid @enderror" placeholder="http://...">
                                @error('url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="footer_tipe" class="mt-3 mb-2">Pilih Tipe Footer</label>
                                <select class="form-control @error('footer_tipe') is-invalid @enderror" name="footer_tipe"
                                    id="footer_tipe">
                                    <option disabled selected hidden>Pilih Tipe</option>
                                    <option value="1">Unit Produksi Sekolah</option>
                                    <option value="2">Aplikasi & Layanan</option>
                                    <option value="3">Lainnya</option>
                                </select>
                                @error('footer_tipe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-right w-100">
                                <button class="btn btn-warning px-4 rounded-pill shadow-warning position-absolute"
                                    style="right: 10px;">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            <div class="col-md-6 mt-4 p-2">
                <div class="w-100 table-parent bg-white">
                    <div class="row p-4">
                        <div class="col-md-8">
                            <h4 class="poppins mb-0">Footer</h4>
                            <p class="montserrat" style="font-size: .85rem;">Daftar Footer SMKN 1 Purwosari
                            </p>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Label</th>
                                <th>URL</th>
                                <th>Tipe</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($footers as $data)
                                <tr>
                                    <td>{{ $data->label }}</td>
                                    <td>{{ $data->url ?? '-' }}</td>
                                    <td>{{ $data->type == '1' ? 'Unit Produksi Sekolah' : ($data->type == '2' ? 'Aplikasi & Layanan' : 'Lainnya') }}
                                    </td>
                                    <td>
                                        <ul class="navbar-nav">
                                            <li class="nav-item dropdown">
                                                <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0"
                                                    style="padding: 10px;">
                                                    <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="{{ route('footer.edit', ['id' => $data->id_footer, 'token' => $token]) }}"
                                                        class="dropdown-item text-warning"
                                                        onclick="event.stopPropagation(); onEdit('${full.bin_id}'); return false;"
                                                        style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                        <i class='fas fa-pen-alt mx-1 text-warning'></i> Edit
                                                    </a>
                                                    <form action="{{ route('footer.destroy', ['token' => $token]) }}"
                                                        method="post" class="d-inline"
                                                        onclick="event.stopPropagation(); return confirm('Data akan dihapus ?')">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" value="{{ $data->id_footer }}"
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
                                    <form method="GET" id="show-form" name="showForm" action="{{ url()->current() }}">
                                        <div class="form-group d-inline-block">
                                            <input type="hidden" name="page" value="{{ request('page', 1) }}">
                                            <select id="show-select" name="show" onchange="this.form.submit()" class="form-control form-control-sm d-inline-block"
                                                    style="width:70px; font-size: .7rem;">
                                                <option value="10" {{ request('show') == 10 ? 'selected' : '' }}>10</option>
                                                <option value="20" {{ request('show') == 20 ? 'selected' : '' }}>20</option>
                                                <option value="30" {{ request('show') == 30 ? 'selected' : '' }}>30</option>
                                                <option value="40" {{ request('show') == 40 ? 'selected' : '' }}>40</option>
                                            </select>
                                        </div>
                                        <p class="montserrat d-inline" style="font-size: .7rem;">Data per halaman</p>
                                    </form>
                                @endif
                            </div>
                        </div>
                        @if($count > request('show') && $count > 10)
                            <div class="col-md-6 text-right">
                                <p class="montserrat d-inline" style="font-size: .7rem;">{{ $footers->firstItem() }} dari {{ $footers->lastItem() }}</p>
                                <a href="{{ $footers->previousPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $footers->onFirstPage() ? 'disabled' : 'active' }}">
                                    <i class="fas fa-caret-left text-warning"></i>
                                </a>
                                <a href="{{ $footers->nextPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $footers->hasMorePages() ? 'active' : 'disabled' }}">
                                    <i class="fas fa-caret-right text-warning"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
