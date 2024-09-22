@extends('layouts.main')

@section('title')
    <title> Slider Keunggulan | Admin Panel</title>
@endsection

@section('container')
    <div class="container-fluid">
        @if(Session::get('success'))
        <div class="position-fixed w-100 alert alert-success alert-dismissible fade show" style="top: 0px; left: 0px; z-index: 1000 !important;" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ Session::get('success') }}</strong>
        </div>
        @endif
        <div class="row">
            <div class="offset-md-1 col-12">
                @include('admin.partials.nav_profile')
            </div>
            @if ($action == "update")
            <div class="col-md-4 offset-md-1 mt-4 p-2">
                <div class="w-100 rad bg-white position-relative shadow py-3 px-4">
                    <h5 class="poppins mb-0">Update Kategori</h5>
                    <form action="{{ route('slider.update', ['token' => $token]) }}" method="post">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <input type="hidden" value="{{$slider->id_sk}}" name="idName" id="idName" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="title" class="mt-3 mb-2">Title</label>
                            <input type="text" name="title" value="{{$slider->title}}" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Kata-Kata">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="mt-3 mb-2">Deskripsi (Optional)</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Just any description">{{$slider->description}}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-right w-100">
                            <button class="btn btn-warning px-4 rounded-pill shadow-warning position-absolute" style="right: 10px;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="col-md-4 offset-md-1 mt-4 p-2">
                <div class="w-100 rad bg-white position-relative shadow py-3 px-4">
                    <h5 class="poppins mb-0">Tambah Kategori</h5>
                    <form action="{{ route('slider.store', ['token' => $token]) }}" method="post">
                        @csrf
                        <div class="form-group">
                          <label for="title" class="mt-3 mb-2">Title</label>
                          <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Kata-Kata">
                          @error('title')
                          <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="mt-3 mb-2">Deskripsi (Optional)</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Just any description"></textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-right w-100">
                            <button class="btn btn-warning px-4 rounded-pill shadow-warning position-absolute" style="right: 10px;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            <div class="col-md-6 mt-4 p-2">
                <div class="w-100 table-parent bg-white">
                    <div class="row p-4">
                        <div class="col-md-8">
                            <h4 class="poppins mb-0">Kategori</h4>
                            <p class="montserrat" style="font-size: .85rem;">Daftar Slider Keunggulan Panel
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('slider.index', ['token' => $token]) }}" class="btn-print btn btn-white border-warning px-3 rounded-pill"><i class="fas fa-newspaper"></i> Slider Keunggulan</a>
                        </div>
                    </div>
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sliders as $data)
                            <tr>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->description ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('slider.edit', ['id' => $data->id_sk, 'token' => $token]) }}" class="btn btn-success p-2"><i class="fas fa-pen-alt"></i></a>
                                    <form action="{{ route('slider.destroy', ['token' => $token]) }}" method="post" class="d-inline" onclick="return confirm('Pengumuman akan dihapus ?')">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" value="{{$data->id_sk}}" name="idName">
                                        <button type="submit" class="btn btn-danger p-2"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endsection
