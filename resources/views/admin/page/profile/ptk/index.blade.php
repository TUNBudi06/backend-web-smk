@extends('layouts.main')

@section('title')
    <title>PTK | Admin Panel</title>
@endsection

@section('container')
    <div class="row">
        <div class="col-md-11 offset-md-1">
            @include('admin.partials.nav_profile')
            <div class="w-100 table-parent bg-white">
                <div class="row p-4">
                    <div class="col-md-8">
                        <h4 class="poppins mb-0">PTK</h4>
                        <p class="montserrat" style="font-size: .85rem;">Daftar PTK SMKN 1 Purwosari
                        </p>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('ptk.create', ['token' => $token]) }}" class="btn-print btn btn-warning shadow-warning px-5 rounded-pill"><i class="fas fa-plus"></i> PTK Baru</a>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-warning rounded-pill px-4" data-toggle="modal" data-target="#modelId">
                            import CSV
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                                            <input type="file" name="csv" id="csv" class="form-control" aria-describedby="csvId">
                                            <small id="csvId" class="text-muted"><a href="">Contoh file csv</a></small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-second rad text-warning" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-warning rad">Save</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>TTL</th>
                            <th>Gender</th>
                            <th>Alamat</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ptk as $key => $data)
                        <tr>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->nip }}</td>
                            <td>{{ $data->tempat_lahir }}, {{ $data->tanggal_lahir }}</td>
                            <td>{{ $data->jenis_kelamin }}</td>
                            <td>{{ $data->alamat }}</td>
                            <td>
                                <a href="#" target="_blank" class="btn btn-warning p-2"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('ptk.edit', ['ptk' => $data->id, 'token' => $token]) }}" class="btn btn-success p-2"><i class="fas fa-pen-alt"></i></a>
                                    <form action="{{ route('ptk.destroy', ['ptk' => $data->id, 'token' => $token]) }}" method="post" class="d-inline">
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
                                    <input type="hidden" name="#">
                                    <select id="show-select" name="show" onchange="showData()" class="form-control form-control-sm d-inline-block"
                                        style="width:70px; font-size: .7rem;" name="" id="">
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
                        <p class="montserrat d-inline" style="font-size: .7rem;">{{ $ptk->firstItem() }} dari {{ $ptk->lastItem() }}</p>
                        <a href="{{ $ptk->previousPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $ptk->onFirstPage() ? 'disabled' : 'active' }}">
                            <i class="fas fa-caret-left text-warning"></i>
                        </a>
                        <a href="{{ $ptk->nextPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $ptk->hasMorePages() ? 'active' : 'disabled' }}">
                            <i class="fas fa-caret-right text-warning"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection