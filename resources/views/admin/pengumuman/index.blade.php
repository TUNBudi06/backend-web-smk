{{--@dd($pengumuman)--}}
@extends('layouts.main')

@section('title')
    <title>Pengumuman | Admin Panel</title>
@endsection

@section('container')
        <div class="row">
            <div class="col-md-11 offset-md-1 mt-4 p-2">
                @include('admin.partials.nav_information')
                <div class="w-100 table-parent bg-white">
                    <div class="row p-4">
                        <div class="col-md-8">
                            <h4 class="poppins mb-0">Pengumuman</h4>
                            <p class="montserrat" style="font-size: .85rem;">Daftar Pengumuman SMKN 1 Purwosari
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('pengumuman.create', ['token' => $token]) }}" class="btn-print btn btn-warning shadow-warning px-5 rounded-pill"><i class="fas fa-plus"></i> Pengumuman Baru</a>
                            <a href="{{ route('pengumuman.category.index',['token' => $token]) }}" class="btn-print btn btn-white border-warning px-3 rounded-pill"><i class="fas fa-list"></i> Kategori</a>
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
                    <div class="col-11">
                        <table id="tablePengumuman">
                            <thead>
                            <tr>
                                <th class="pl-4">Thumbnail</th>
                                <th>Pengumuman</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th>Dilihat</th>
                                <th>disutujui oleh</th>
                                <th>Tujuan</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pengumuman as $key => $data)
                                <tr>
                                    <td><img src="{{ asset('img/announcement/'.$data->thumbnail) }}" width="120px" height="60px" class="rounded" alt=""></td>
                                    <td style="word-wrap: break-word; max-width: 230px;">{{ $data->nama }}</td>
                                    <td>{{ $data->kategori ? $data->kategori->pemberitahuan_category_name : 'No Category' }}</td>
                                    <td>{{ $data->date }} {{ $data->time }}</td>
                                    <td> <div class="{{ $data->approved ? "badge-success" : 'badge-warning' }}">{{ $data->approved ? "Publik" : 'Pending' }}</div></td>
                                    <td>{{$data->approved ? $data->Approved_by ? $data->Approved_by : "SuperAdmin" : 'Belum Disetujui'}}</td>
                                    <td style="word-wrap: break-word; max-width: 180px;">{{ $data->target }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('pengumuman.show', ['pengumuman' => $data->id_pemberitahuan , 'token' => $token]) }}" class="btn btn-warning p-2 m-1"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('pengumuman.edit', ['pengumuman' => $data->id_pemberitahuan , 'token' => $token]) }}" class="btn btn-success p-2 m-1"><i class="fas fa-pen-alt"></i></a>
                                            <form action="{{ route('pengumuman.destroy', ['pengumuman' => $data->id_pemberitahuan , 'token' => $token]) }}" onclick="return confirm('Data akan dihapus ?')" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger p-2 m-1"><i class="fas fa-trash"></i></button>
                                            </form>                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <script type="text/javascript" >
                            $('#tablePengumuman').dataTable()
                        </script>
                    </div>
                </div>
            </div>
        </div>
@endsection
