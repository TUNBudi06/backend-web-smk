@extends('layouts.main')

@section('title')
    <title>Artikel | Admin Panel</title>
@endsection

@section('container')
        <div class="row">
            <div class="col-md-11 offset-md-1 mt-4 p-2">
                <div class="w-100 table-parent bg-white">
                    <div class="row p-4">
                        <div class="col-md-8">
                            <h4 class="poppins mb-0">Artikel</h4>
                            <p class="montserrat" style="font-size: .85rem;">Daftar Artikel SMKN 1 Purwosari
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('artikel.create', ['token' => $token]) }}" class="btn-print btn btn-warning shadow-warning px-5 rounded-pill"><i class="fas fa-plus"></i> Artikel Baru</a>
                            <a href="{{ route('artikel.category.index',$token) }}" class="btn-print btn btn-white border-warning px-3 rounded-pill"><i class="fas fa-list"></i> Kategori</a>
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
                                <th class="pl-4">Thumbnail</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Tanggal upload</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tr>
                            @foreach($artikel as $key => $data)
{{--                                @dd($data)--}}
                            <tr>
                                <td><img src="{{ asset('img/artikel/'.$data->thumbnail) }}" width="100px" class="rounded" alt=""></td>
                                <td style="word-wrap: break-word; max-width: 230px;">{{ $data->nama }}</td>
                                <td>{{ $data->kategori ? $data->kategori->pemberitahuan_category_name : 'No Category' }}</td>
                                <td style="word-wrap: break-word; max-width: 150px;">{{ $data->created_at }}</td>
                                <td>
                                    <a href="{{ route('artikel.show', ['artikel' => $data->id_pemberitahuan, 'token' => $token]) }}" class="btn btn-warning p-2"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('artikel.edit', ['artikel' => $data->id_pemberitahuan, 'token' => $token]) }}" class="btn btn-success p-2"><i class="fas fa-pen-alt"></i></a>
                                    <form action="{{ route('artikel.destroy', ['artikel' => $data->id_pemberitahuan, 'token' => $token]) }}" onclick="return confirm('Data akan dihapus ?')" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger p-2"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tr>
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
                        <div class="col-md-6 text-right">
                            <p class="montserrat d-inline" style="font-size: .7rem;">{{ $artikel->firstItem() }} dari {{ $artikel->lastItem() }}</p>
                            <a href="{{ $artikel->appends(['show' => request('show')])->previousPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $artikel->onFirstPage() ? 'disabled' : 'active' }}">
                                <i class="fas fa-caret-left text-warning"></i>
                            </a>
                            <a href="{{ $artikel->appends(['show' => request('show')])->nextPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $artikel->hasMorePages() ? 'active' : 'disabled' }}">
                                <i class="fas fa-caret-right text-warning"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
