{{--@dd($user)--}}
@extends('layouts.main')

@section('title')
    <title>User Management | Admin Panel</title>
@endsection

@section('container')
    <div class="col-md-8 offset-md-2 mt-5">
        <a href="{{ route('user.index',['token'=>$token]) }}" class="btn btn-light border-warning px-4 mb-4"><i
                class="fas fa-arrow-left"></i> Kembali</a>
        <form action="{{ $method == 'insert' ? route('user.store', ['token' => $token]):route('user.update', ['token' => $token, 'user' => $user->id_admin]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($method == 'edit')
                @method('PATCH')
            @endif
            <div class="form-group">
                <label for="nama">Nama User</label>
                <input type="text" name="nama" id="nama" value="{{ optional($user)->name ?? old('nama') }}"
                       class="form-control @error('nama') is-invalid @enderror" placeholder="Nama User"
                       aria-describedby="namaId">
                @error('nama')
                <p class="text-danger">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email User</label>
                <input type="text" name="email" id="email" value="{{ optional($user)->email ?? old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="Email User" aria-describedby="emailId">
                @error('email')
                <p class="text-danger">
                    {{ $message }}
                </p>
                @enderror
                <small id="targetId" class="text-muted">Contoh: xyz@gmail.com</small>
            </div>
            <div class="form-group">
                <label for="password">Password User</label>
                <input type="password" name="password" id="password"
                       value="{{ old('password') }}"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Password User" aria-describedby="passwordId">
                @error('password')
                <p class="text-danger">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="form-group">
                <label for="username">Username User</label>
                <input type="text" name="username" id="username"
                       value="{{ optional($user)->username ?? old('username') }}"
                       class="form-control @error('username') is-invalid @enderror"
                       placeholder="Username User" aria-describedby="usernameId">
                @error('username')
                <p class="text-danger">
                    {{ $message }}
                </p>
                @enderror
            </div>
            @if($method == 'insert')
                <div class="form-group">
                    <label for="token">Token User</label>
                    <input type="text" name="token" id="token"
                           value="{{ optional($user)->token ?? old('username') }}"
                           class="form-control @error('token') is-invalid @enderror"
                           placeholder="Token User" aria-describedby="usernameId">
                    @error('token')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            @endif
            <div class="form-group">
                <label for="role">Role User</label>
                <select class="form-control @error('role') is-invalid @enderror"
                        name="role">
                    <option value="1" {{ (optional($user)->role ?? old('role')) == '1' ? 'selected': '' }}>Superadmin
                    </option>
                    <option value="2" {{ (optional($user)->role ?? old('role')) == '2' ? 'selected': '' }}>Admin
                    </option>
                </select>
                @error('role')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-6 py-md-5 py-3">
                    <div class="form-group">
                        <label for="image">Foto User</label>
                        <input onchange="loadFile(event)" type="file" name="image" id="image"
                               class="form-control @error('image') is-invalid @enderror"
                               placeholder="Purwosari, Pasuruan"
                               aria-describedby="imageId">
                        <small id="imageId" class="text-muted d-none"></small>
                        @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img class="w-100 rounded" id="preview"
                         src="{{ $method == 'edit' ? asset('img/users/' . $user->image):asset('img/no_image.png') }}"
                         alt="">
                </div>
            </div>
            <div class="text-right mb-4">
                <button type="submit" class="btn btn-warning mt-5 px-5 rounded-pill shadow-warning"><i
                            class="fas fa-paper-plane"></i> Submit
                </button>
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
