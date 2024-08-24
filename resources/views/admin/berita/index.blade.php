@extends('layouts.main')

@section('title')
    <title>Berita | Admin Panel</title>
@endsection

@section('container')
        <div class="row">
            <div class="col-md-11 offset-md-1">
                @include('admin.partials.nav_information')
                <div class="w-100 table-parent bg-white">
                    <div class="row p-4">
                        <div class="col-md-8">
                            <h4 class="poppins mb-0">Berita</h4>
                            <p class="montserrat" style="font-size: .85rem;">Daftar Berita SMKN 1 Purwosari
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('berita.create', ['token' => $token]) }}" class="btn-print btn btn-warning shadow-warning px-5 rounded-pill"><i class="fas fa-plus"></i> Berita Baru</a>
                            <a href="{{ route('berita.category.index',['token' => $token]) }}" class="btn-print btn btn-white border-warning px-3 rounded-pill"><i class="fas fa-list"></i> Kategori</a>
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
                                <th>Lokasi</th>
                                <th>Tanggal upload</th>
                                <th>Dilihat</th>
                                <th>disutujui oleh</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $key => $data)

                            <tr>
                                <td>
                                    <img src="{{ asset(file_exists(public_path('img/berita/' . $data->thumbnail)) ? 'img/berita/' . $data->thumbnail : 'img/no_image.png') }}" width="100px" class="rounded" alt="">
                                </td>
                                <td style="word-wrap: break-word; max-width: 230px;">{{ $data->nama }}</td>
                                <td>{{ $data->kategori ? $data->kategori->pemberitahuan_category_name : 'No Category' }}</td>
                                <td>{{ $data->location }}</td>
                                <td style="word-wrap: break-word; max-width: 150px;">{{ $data->created_at }}</td>
                                <td> <div class="{{ $data->approved ? "badge-success" : 'badge-warning' }}">{{ $data->approved ? "Publik" : 'Pending' }}</div></td>
                                <td>{{$data->approved ? $data->Approved_by ? $data->Approved_by : "SuperAdmin" : 'Belum Disetujui'}}</td>
                                <td>
                                    <a href="{{ route('berita.show', ['berita' => $data->id_pemberitahuan, 'token' => $token]) }}" class="btn btn-warning p-2"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('berita.edit', ['berita' => $data->id_pemberitahuan, 'token' => $token]) }}" class="btn btn-success p-2"><i class="fas fa-pen-alt"></i></a>
                                    <form action="{{ route('berita.destroy', ['berita' => $data->id_pemberitahuan, 'token' => $token]) }}" onclick="return confirm('Data akan dihapus ?')" method="post" class="d-inline">
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
