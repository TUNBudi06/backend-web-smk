@extends('layouts.main')

@section('title')
    <title>Program Studi | Admin Panel</title>
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
            @if ($action == 'update')
                <div class="col-md-4 offset-md-1 mt-4 p-2">
                    <div class="w-100 rad bg-white position-relative shadow py-3 px-4">
                        <h5 class="poppins mb-0">Update Program Studi</h5>
                        <form
                            action="{{ route('prodi.update', ['token' => $token, 'prodi' => $category->id_prodi]) }}"
                            method="post">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <input type="hidden" value="{{ $category->id_prodi }}" name="idCategory"
                                    id="idCategory" class="form-control" placeholder="Nama Program Studi">
                            </div>
                            <div class="form-group">
                                <label for="prodi_name" class="mt-3 mb-2">Nama Prodi</label>
                                <input type="text" required value="{{ $category->prodi_name }}"
                                    name="prodi_name" id="prodi_name" class="form-control"
                                    placeholder="Nama Program Studi">
                            </div>
                            <div class="form-group">
                                <label for="prodi_short" class="mt-3 mb-2">Singkatan Prodi</label>
                                <input type="text" required value="{{ $category->prodi_short }}"
                                    name="prodi_short" id="prodi_short" class="form-control"
                                    placeholder="TI / Pemesinan, dll">
                            </div>
                            <div class="form-group">
                                <label for="manual_color" class="mt-3 mb-2">Warna Prodi</label>
                                <div class="input-group">
                                    <input type="color" name="manual_color" id="manual_color" class="form-control"
                                        style="width: 70px;">
                                    <input type="text" name="prodi_color" id="prodi_color" required
                                        value="{{ $category->prodi_color }}" class="form-control">
                                </div>
                                <small id="colorID" class="text-muted">Hex Color otomatis terisi saat warna
                                    dipilih</small>
                            </div>
                            <div class="text-right w-100 position-absolute" style="right: 10px;">
                                <a href="{{ route('prodi.create', ['token' => $token]) }}"
                                    class="btn btn-white px-4 rounded-pill border-warning">Tambah</a>
                                <button class="btn btn-warning px-4 rounded-pill shadow-warning">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="col-md-4 offset-md-1 mt-4 p-2">
                    <div class="w-100 rad bg-white position-relative shadow py-3 px-4">
                        <h5 class="poppins mb-0">Tambah Program Studi</h5>
                        <form action="{{ route('prodi.store', ['token' => $token]) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="prodi_name" class="mt-3 mb-2">Nama Prodi</label>
                                <input type="text" name="prodi_name" id="prodi_name" class="form-control"
                                    placeholder="Nama Program Studi">
                            </div>
                            <div class="form-group">
                                <label for="prodi_short" class="mt-3 mb-2">Singkatan Prodi</label>
                                <input type="text" name="prodi_short" id="prodi_short" class="form-control"
                                    placeholder="TI / Pemesinan, dll">
                            </div>
                            <div class="form-group">
                                <label for="manual_color" class="mt-3 mb-2">Warna Prodi</label>
                                <div class="input-group">
                                    <input type="color" name="manual_color" id="manual_color" class="form-control"
                                        style="width: 70px;">
                                    <input type="text" name="prodi_color" id="prodi_color" class="form-control"
                                        value="#">
                                </div>
                                <small id="colorID" class="text-muted">Hex Color otomatis terisi saat warna
                                    dipilih</small>
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
                            <h4 class="poppins mb-0">Program Studi</h4>
                            <p class="montserrat" style="font-size: .85rem;">Daftar Program Studi SMKN 1 Purwosari</p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ url()->previous() }}"
                               class="btn-print btn btn-white border-warning px-3 rounded-pill">
                                <i class="fas fa-newspaper"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Prodi</th>
                                <th>Singkatan</th>
                                <th>Warna</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prodi as $data)
                                <tr>
                                    <td>{{ $data->prodi_name }}</td>
                                    <td>{{ $data->prodi_short }}</td>
                                    <td>{{ $data->prodi_color ?? '-' }}</td>
                                    <td>
                                        <ul class="navbar-nav">
                                            <li class="nav-item dropdown">
                                                <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0"
                                                    style="padding: 10px;">
                                                    <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="{{ route('prodi.edit', ['prodi' => $data->id_prodi, 'token' => $token]) }}"
                                                        class="dropdown-item text-warning"
                                                        onclick="event.stopPropagation(); onEdit('${full.bin_id}'); return false;"
                                                        style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                        <i class='fas fa-pen-alt mx-1 text-warning'></i> Edit
                                                    </a>
                                                    <form
                                                        action="{{ route('prodi.destroy', ['prodi' => $data->id_prodi, 'token' => $token]) }}"
                                                        method="post" class="d-inline"
                                                        onclick="event.stopPropagation(); return confirm('Data akan dihapus ?')">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" value="{{ $data->id_prodi }}"
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
                            </div>
                        </div>
                        @if($count > request('show') && $count > 10)
                            <div class="col-md-6 text-right">
                                <p class="montserrat d-inline" style="font-size: .7rem;">{{ $prodi->firstItem() }} dari {{ $prodi->lastItem() }}</p>
                                <a href="{{ $prodi->appends(['show' => request('show')])->previousPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $prodi->onFirstPage() ? 'disabled' : 'active' }}">
                                    <i class="fas fa-caret-left text-warning"></i>
                                </a>
                                <a href="{{ $prodi->appends(['show' => request('show')])->nextPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $prodi->hasMorePages() ? 'active' : 'disabled' }}">
                                    <i class="fas fa-caret-right text-warning"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const $colorPicker = $('#manual_color');
            const $hexInput = $('#prodi_color');

            if ($hexInput.val() === '') {
                $colorPicker.val('#000000');
            } else {
                $colorPicker.val($hexInput.val().toUpperCase());
            }

            $colorPicker.on('input', function() {
                $hexInput.val($colorPicker.val().toUpperCase());
            });

            $hexInput.on('input', function() {
                if (/^#[0-9A-F]{6}$/i.test($hexInput.val())) {
                    $colorPicker.val($hexInput.val());
                }
            });
        });
    </script>
@endsection
