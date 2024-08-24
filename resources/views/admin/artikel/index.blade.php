@extends('layouts.main')

@section('title')
    <title>Artikel | Admin Panel</title>
@endsection

@section('container')
        <div class="row">
            <div class="col-md-11 offset-md-1 mt-4 p-2">
                @include('admin.partials.nav_information')
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
                    <table id="table">
                        <thead>
                            <tr>
                                <th class="pl-4">Thumbnail</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Tanggal upload</th>
                                <th>Dilihat</th>
                                <th>disutujui oleh</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($artikel as $key => $data)
{{--                                @dd($data)--}}
                            <tr>
                                <td><img src="{{ asset('img/artikel/'.$data->thumbnail) }}" width="100px" class="rounded" alt=""></td>
                                <td style="word-wrap: break-word; max-width: 230px;">{{ $data->nama }}</td>
                                <td>{{ $data->kategori ? $data->kategori->pemberitahuan_category_name : 'No Category' }}</td>
                                <td style="word-wrap: break-word; max-width: 150px;">{{ $data->created_at }}</td>
                                <td> <div class="{{ $data->approved ? "badge-success" : 'badge-warning' }}">{{ $data->approved ? "Publik" : 'Pending' }}</div></td>
                                <td>{{$data->approved ? $data->Approved_by ? $data->Approved_by : "SuperAdmin" : 'Belum Disetujui'}}</td>
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
                        </tbody>
                    </table>
                    <script>
                        $('#table').dataTable()
                    </script>
                </div>
            </div>
        </div>
@endsection
