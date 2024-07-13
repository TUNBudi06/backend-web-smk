@extends('layouts.main')

@section('title')
    <title>User Management | Admin Panel</title>
@endsection

@section('container')
    <div class="col-md-8 offset-md-2 pt-4">
        <a href="{{ route('user.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i
                class="fas fa-arrow-left"></i> Kembali</a>
        <form action="{{ route('user.store', ['token' => $token]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama">Nama User</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                    class="form-control @error('nama') is-invalid @enderror" placeholder="Nama User"
                    aria-describedby="namaId">
                @error('nama')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="form-group">
                <label for="target">Email User</label>
                <input type="text" name="target" id="target" value="{{ old('target') }}"
                    class="form-control @error('target') is-invalid @enderror"
                    placeholder="Email User" aria-describedby="targetId">
                @error('target')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
                <small id="targetId" class="text-muted">Contoh: xyz@gmail.com</small>
            </div>
            <div class="form-group">
                <label for="user" class="form-label">Role User</label>
                <select class="form-control @error('id_pemberitahuan_category') is-invalid @enderror"
                    name="id_pemberitahuan_category">
                </select>
                @error('id_pemberitahuan_category')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-6 py-md-5 py-3">
                    <div class="form-group">
                        <label for="thumbnail">Foto User</label>
                        <input onchange="loadFile(event)" type="file" name="thumbnail" id="thumbnail"
                            class="form-control @error('thumbnail') is-invalid @enderror" placeholder="Purwosari, Pasuruan"
                            aria-describedby="imageId">
                        <small id="imageId" class="text-muted d-none"></small>
                        @error('thumbnail')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img class="w-100 rounded" id="preview" src="{{ asset('img/no_image.png') }}" alt="">
                </div>
            </div>
            <div class="text-right mb-4">
                <button type="submit" class="btn btn-warning mt-2 px-5 rounded-pill shadow-warning"><i
                        class="fas fa-paper-plane"></i> Submit</button>
            </div>
        </form>
    </div>
    <script>
        function loadFile(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var preview = document.getElementById('preview');
                preview.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
