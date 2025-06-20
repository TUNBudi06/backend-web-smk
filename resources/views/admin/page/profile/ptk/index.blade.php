@extends('layouts.main')

@section('title')
    <title>Pendidik | Admin Panel</title>
@endsection

@section('container')
    <div class="row">
        <div class="col-md-11 offset-md-1">
            @include('admin.partials.nav_academic')
            <div class="w-100 table-parent bg-white">
                <div class="row p-4">
                    <div class="col-md-8">
                        <h4 class="poppins mb-0">Pendidik dan Tenaga Kependidikan</h4>
                        <p class="montserrat" style="font-size: .85rem;">Daftar Pendidik dan Tenaga Kependidikan SMKN 1
                            Purwosari
                        </p>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('ptk.create', ['token' => $token]) }}"
                            class="btn-print btn btn-warning shadow-warning px-5 rounded-pill"><i class="fas fa-plus"></i>
                            PTK Baru</a>
                        <!-- Button trigger modal -->
                        <button type="button" class="mx-2 btn btn-outline btn-warning shadow-warning px-4 rounded-pill"
                            data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-file-import"></i> Import
                        </button>
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
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Mapel</th>
                            {{-- <th>TTL</th> --}}
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ptk as $key => $data)
                            <tr>
                                <td>
                                    <img src="{{ asset($data->foto && file_exists(public_path('img/guru/' . $data->foto)) ? 'img/guru/' . $data->foto : 'img/illust/male.png') }}"
                                        width="100px" class="rounded" alt="">
                                </td>
                                <td style="word-wrap: break-word; max-width: 160px;">{{ $data->nama }}</td>
                                <td style="word-wrap: break-word; max-width: 150px;">{{ $data->nip }}</td>
                                <td style="word-wrap: break-word; max-width: 150px;">{{ $data->mata_pelajaran }}</td>
                                {{-- <td style="word-wrap: break-word; max-width: 175px;">{{ $data->tempat_lahir }}, {{ $data->tanggal_lahir }}</td> --}}
                                {{-- <td>{{ $data->jenis_kelamin }}</td> --}}
                                <td style="word-wrap: break-word; max-width: 175px;">{{ $data->alamat }}</td>
                                <td>
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown">
                                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0"
                                                style="padding: 10px;">
                                                <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="{{ route('ptk.edit', ['ptk' => $data->id, 'token' => $token]) }}"
                                                    class="dropdown-item text-warning"
                                                    onclick="event.stopPropagation(); onEdit('${full.bin_id}'); return false;"
                                                    style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                    <i class='fas fa-pen-alt mx-1 text-warning'></i> Edit
                                                </a>
                                                <form
                                                    action="{{ route('ptk.destroy', ['ptk' => $data->id, 'token' => $token]) }}"
                                                    method="post" class="d-inline"
                                                    onclick="event.stopPropagation(); return confirm('Data akan dihapus ?')">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" value="{{ $data->id_gallery }}" name="idName">
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
                            <p class="montserrat d-inline" style="font-size: .7rem;">{{ $ptk->firstItem() }} dari
                                {{ $ptk->lastItem() }}</p>
                            <a href="{{ $ptk->appends(['show' => request('show')])->previousPageUrl() }}"
                                class="btn btn-sm p-0 px-2 btn-white {{ $ptk->onFirstPage() ? 'disabled' : 'active' }}">
                                <i class="fas fa-caret-left text-warning"></i>
                            </a>
                            <a href="{{ $ptk->appends(['show' => request('show')])->nextPageUrl() }}"
                                class="btn btn-sm p-0 px-2 btn-white {{ $ptk->hasMorePages() ? 'active' : 'disabled' }}">
                                <i class="fas fa-caret-right text-warning"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import Excel -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="importModalLabel">Import Excel</h5>
                    <button type="button" class="border-0 bg-transparent text-dark fs-5" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="importExcelForm" action="{{ route('ptk.import', ['token' => $token]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="excelFile" class="form-label">Pilih file Excel (.xls, .xlsx)</label>
                            <input class="form-control" type="file" id="excelFile" name="excel_file"
                                accept=".xls,.xlsx" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Atau tarik file ke sini:</label>
                            <div id="dropzone" class="border border-dashed p-4 rounded text-center bg-light">
                                <i class="fas fa-upload fa-2x mb-2 text-warning"></i>
                                <p class="text-muted">Drop file Excel di sini</p>
                            </div>
                            <div id="fileError" class="text-danger mt-2" style="display: none;"></div>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ asset('template/template-ptk.xlsx') }}" class="btn btn-outline-secondary btn-sm"
                                download>
                                <i class="fas fa-download"></i> Download Template
                            </a>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="submit" form="importExcelForm"
                        class="btn btn-warning px-4 rounded-pill">Import</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const isExcelFile = (file) => {
            const allowedExtensions = ['xls', 'xlsx'];
            const fileExtension = file.name.split('.').pop().toLowerCase();
            return allowedExtensions.includes(fileExtension);
        };

        $("#dropzone").on("dragover", function(e) {
            e.preventDefault();
            $(this).addClass("border-warning");
        });

        $("#dropzone").on("dragleave", function(e) {
            $(this).removeClass("border-warning");
        });

        $("#dropzone").on("drop", function(e) {
            e.preventDefault();
            $(this).removeClass("border-warning");

            const files = e.originalEvent.dataTransfer.files;
            const file = files[0];

            if (file && isExcelFile(file)) {
                $("#excelFile").prop("files", files);
                $("#fileError").hide().text('');
            } else {
                $("#excelFile").val("");
                $("#fileError").text("Jenis file tidak sesuai. Hanya .xls dan .xlsx yang diperbolehkan.").show();
            }
        });

        $("#excelFile").on("change", function() {
            const file = this.files[0];
            if (file && !isExcelFile(file)) {
                $(this).val("");
                $("#fileError").text("Jenis file tidak sesuai. Hanya .xls dan .xlsx yang diperbolehkan.").show();
            } else {
                $("#fileError").hide().text('');
            }
        });

        $('#show-select').change(() => {
            $('input[name="page"]').val(1);
            $('#show-form').submit();
        });
    </script>
@endsection
