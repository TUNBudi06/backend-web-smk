@extends('layouts.main')

@section('title')
    <title>Peserta Didik | Admin Panel</title>
@endsection

@section('container')
    <div class="row">
        <div class="col-md-11 offset-md-1">
            @include('admin.partials.nav_academic')
            <div class="w-100 table-parent bg-white">
                <div class="row p-4">
                    <div class="col-md-8">
                        <h4 class="poppins mb-0">Peserta Didik</h4>
                        <p class="montserrat" style="font-size: .85rem;">Daftar Peserta Didik SMKN 1 Purwosari
                        </p>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('pd.create', ['token' => $token]) }}"
                            class="btn-print btn btn-warning shadow-warning px-5 rounded-pill"><i class="fas fa-plus"></i>
                            Peserta Baru</a>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-warning rounded-pill px-4" data-toggle="modal"
                            data-target="#modelId">
                            import CSV
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <form action="" method="POST">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Import CSV</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-left">
                                            <div class="form-group">
                                                <label for="csv">File CSV</label>
                                                <input type="file" name="csv" id="csv" class="form-control"
                                                    aria-describedby="csvId">
                                                <small id="csvId" class="text-muted"><a href="">Contoh file
                                                        csv</a></small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- <button type="submit" class="btn btn-warning rad">Save</button> -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Agama</th>
                            <th>Gender</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pd as $key => $data)
                            <tr>
                                <!-- <td>{{ $data->nisn }}</td>
                    <td>{{ $data->nis }}</td> -->
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->kelas }}</td>
                                <td>{{ $data->tempat_lahir }}</td>
                                <td>{{ $data->tanggal_lahir }}</td>
                                <td>{{ $data->agama }}</td>
                                <td>{{ $data->gender }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td>
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown">
                                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0"
                                                style="padding: 10px;">
                                                <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="{{ route('pd.show', ['pd' => $data->id, 'token' => $token]) }}"
                                                    class="dropdown-item text-info"
                                                    onclick="event.stopPropagation(); onShow('${full.bin_id}'); return false;"
                                                    style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                    <i class='fas fa-eye mx-1 text-info'></i> Show
                                                </a>
                                                <a href="{{ route('pd.edit', ['pd' => $data->id, 'token' => $token]) }}"
                                                    class="dropdown-item text-warning"
                                                    onclick="event.stopPropagation(); onEdit('${full.bin_id}'); return false;"
                                                    style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                    <i class='fas fa-pen-alt mx-1 text-warning'></i> Edit
                                                </a>
                                                <form
                                                    action="{{ route('pd.destroy', ['pd' => $data->id, 'token' => $token]) }}"
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
                            <p class="montserrat d-inline" style="font-size: .7rem;">{{ $pd->firstItem() }} dari {{ $pd->lastItem() }}</p>
                            <a href="{{ $pd->appends(['show' => request('show')])->previousPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $pd->onFirstPage() ? 'disabled' : 'active' }}">
                                <i class="fas fa-caret-left text-warning"></i>
                            </a>
                            <a href="{{ $pd->appends(['show' => request('show')])->nextPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $pd->hasMorePages() ? 'active' : 'disabled' }}">
                                <i class="fas fa-caret-right text-warning"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
