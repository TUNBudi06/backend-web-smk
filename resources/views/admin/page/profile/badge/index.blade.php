@extends('layouts.main')

@section('title')
    <title>Badge | Admin Panel</title>
@endsection

@push('styles')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0;
            right: 0; bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px; width: 26px;
            left: 4px; bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #00cc66;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }
    </style>
@endpush

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
                        <h5 class="poppins mb-0">Update Badge</h5>
                        <form
                            action="{{ route('badge.update', ['token' => $token, 'badge' => $category->id]) }}"
                            method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <input type="hidden" value="{{ $category->id }}" name="idCategory"
                                    id="idCategory" class="form-control" placeholder="Nama Badge">
                            </div>
                            <div class="form-group">
                                <label for="label" class="mt-3 mb-2">Nama Badge</label>
                                <input type="text" value="{{ $category->label }}"
                                    name="label" id="label" class="form-control"
                                    placeholder="Nama Badge">
                            </div>
                            <div class="form-group">
                                <label for="icon" class="mt-3 mb-2">Icon Badge</label>
                                <input type="file" value="{{ $category->icon }}"
                                    name="icon" id="icon" class="form-control" accept=".png, .jpg, .jpeg">
                            </div>
                            <div class="text-right w-100 position-absolute" style="right: 10px;">
                                <button class="btn btn-warning px-4 rounded-pill shadow-warning">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="col-md-4 offset-md-1 mt-4 p-2">
                    <div class="w-100 rad bg-white position-relative shadow py-3 px-4">
                        <h5 class="poppins mb-0">Tambah Badge</h5>
                        <form action="{{ route('badge.store', ['token' => $token]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="label" class="mt-3 mb-2">Nama Badge</label>
                                <input type="text" name="label" id="label" class="form-control"
                                    placeholder="Nama Badge">
                            </div>
                            <div class="form-group">
                                <label for="icon" class="mt-3 mb-2">Icon Badge</label>
                                <input type="file" name="icon" id="icon" class="form-control" accept=".png, .jpg, .jpeg">
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
                            <h4 class="poppins mb-0">Badge</h4>
                            <p class="montserrat" style="font-size: .85rem;">Daftar Badge SMKN 1 Purwosari</p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('elearning.index', ['token' => $token]) }}"
                               class="btn-print btn btn-white border-warning px-3 rounded-pill">
                                <i class="fas fa-newspaper"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Badge</th>
                                <th>Icon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($badge as $data)
                                <tr>
                                    <td>{{ $data->label }}</td>
                                    <td>
                                        <img src="{{ asset(file_exists(public_path('img/badge/' . $data->icon)) ? 'img/badge/' . $data->icon : 'img/no_image.png') }}" width="60px" height="60px" class="rounded">
                                    </td>
                                    <td>
                                        <ul class="navbar-nav">
                                            <li class="nav-item dropdown">
                                                <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0"
                                                    style="padding: 10px;">
                                                    <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="{{ route('badge.edit', ['badge' => $data->id, 'token' => $token]) }}"
                                                        class="dropdown-item text-warning"
                                                        onclick="event.stopPropagation(); onEdit('${full.bin_id}'); return false;"
                                                        style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                        <i class='fas fa-pen-alt mx-1 text-warning'></i> Edit
                                                    </a>
                                                    <form
                                                        action="{{ route('badge.destroy', ['badge' => $data->id, 'token' => $token]) }}"
                                                        method="post" class="d-inline"
                                                        onclick="event.stopPropagation(); return confirm('Data akan dihapus ?')">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" value="{{ $data->id }}"
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
                                <p class="montserrat d-inline" style="font-size: .7rem;">{{ $badge->firstItem() }} dari {{ $badge->lastItem() }}</p>
                                <a href="{{ $badge->appends(['show' => request('show')])->previousPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $badge->onFirstPage() ? 'disabled' : 'active' }}">
                                    <i class="fas fa-caret-left text-warning"></i>
                                </a>
                                <a href="{{ $badge->appends(['show' => request('show')])->nextPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $badge->hasMorePages() ? 'active' : 'disabled' }}">
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
