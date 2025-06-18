@extends('layouts.main')

@section('title')
    <title>Navbar | Admin Panel</title>
@endsection

@section('container')
    <div class="row">
        <div class="col-md-11 offset-md-1 mt-4 p-2">
            @include('admin.partials.nav_link')
            <div class="w-100 table-parent bg-white">
                <div class="row p-4">
                    <div class="col-md-8">
                        <h4 class="poppins mb-0">Navbar</h4>
                        <p class="montserrat" style="font-size: .85rem;">Daftar Navbar SMKN 1 Purwosari ({{$dataCount}})
                        </p>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('navbar.create', ['token' => $token]) }}" class="btn btn-warning shadow-warning px-4 rounded-pill"><i class="fas fa-plus"></i> Navbar Baru</a>
                        {{-- <a href="{{ route('badge.index',$token) }}" class="btn-print btn btn-white border-warning px-3 rounded-pill"><i class="fas fa-columns mx-2"></i> Icon</a> --}}
                    </div>
                </div>
                @if(Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>{{ Session::get('success') }}</strong>
                </div>
                @endif
                <table class="table ">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Dropdown</th>
                            <th>URL</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @foreach ($navbar as $key => $data)
                        <tr>
                            <td style="word-wrap: break-word; max-width: 230px;">{{ $loop->iteration }}</td>
                            <td style="word-wrap: break-word; max-width: 230px;">{{ $data->title }}</td>
                            <td style="word-wrap: break-word; max-width: 230px;">{{ $data->is_dropdown == 1 ? 'Yes' : 'No' }}</td>
                            <td><a href="{{ $data->route }}" target="_blank">{{ $data->route }}</a></td>
                            <td>
                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown">
                                        <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0"
                                            style="padding: 10px;">
                                            <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('navbar.show', ['navbar' => $data->id, 'token' => $token]) }}"
                                                class="dropdown-item text-info"
                                                style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                <i class='fas fa-eye mx-1 text-info'></i> Show
                                            </a>
                                            <a href="{{ route('navbar.edit', ['navbar' => $data->id, 'token' => $token]) }}"
                                                class="dropdown-item text-warning"
                                                style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                <i class='fas fa-pen-alt mx-1 text-warning'></i> Edit
                                            </a>
                                            <form
                                                action="{{ route('navbar.destroy', ['navbar' => $data->id, 'token' => $token]) }}"
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
                </table>
                <div class="row px-3">
                    <div class="col-md-6">
                        <div class="pb-3">
                            @if($dataCount)
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
                    @if($dataCount > request('show') && $dataCount > 10)
                        <div class="col-md-6 text-right">
                            <p class="montserrat d-inline" style="font-size: .7rem;">{{ $navbar->firstItem() }} dari {{ $navbar->lastItem() }}</p>
                            <a href="{{ $navbar->appends(['show' => request('show')])->previousPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $navbar->onFirstPage() ? 'disabled' : 'active' }}">
                                <i class="fas fa-caret-left text-warning"></i>
                            </a>
                            <a href="{{ $navbar->appends(['show' => request('show')])->nextPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $navbar->hasMorePages() ? 'active' : 'disabled' }}">
                                <i class="fas fa-caret-right text-warning"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
