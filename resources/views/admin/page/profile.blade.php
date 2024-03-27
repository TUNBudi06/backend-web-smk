@extends('layouts.main')

@section('title')
    <title>Profil | Admin Panel</title>
@endsection

@section('container')
<div class="row mt-5">
    <div class="col-md-4 offset-md-1 py-3">
        <div class="w-100 rad bg-white overflow-hidden shadow-sm profile-card">
            <div class="profile-cover position-relative" style="background-image: url({{ asset('img/smk.png') }}">
                <div class="overlay-warning"></div>
            </div>
            <div class="profile-body bg-white px-3">
                <div class="position-relative" style="top: -50px;">
                    <div class="avatar-profile d-inline-block overflow-hidden">
                        <img src="{{ asset('img/illust/male.svg') }}" class="w-100" alt="">
                    </div>
                    <div class="name-profile ml-2 position-absolute d-inline-block" style="top: 20px;">
                        <h4 class="text-white poppins"> {{$nama}}</h4>
                        <p class="text-dark montserrat" style="font-size: .8rem;"><i class="fas fa-envelope text-warning"></i> {{$email}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 py-3">
        <form action="{{route("profile.admin", $token)}}" method="post">
            @csrf
            @method("put")
            <h3 class="poppins">Form administrator</h3>
            <div class="form-group">
                <label for="nama">Nama administrator</label>
                <input required type="text" value="{{$nama ?? ""}}" name="nama" id="nama" class="form-control border-0" placeholder="Pak Luthfi" aria-describedby="namaId">
                <small id="namaId" class="text-muted d-none">Nama</small>
            </div>
            <div class="form-group">
                <label for="email">Email administrator</label>
                <input required type="email" value="{{$email ?? ""}}" name="email" id="email" class="form-control border-0" placeholder="Pak Luthfi" aria-describedby="emailId">
                <small id="emailId" class="text-muted d-none">Nama</small>
            </div>
            <div class="form-group">
                <label for="password">Password administrator yang lama</label>
                <input  type="password" name="password" id="password" class="form-control border-0" aria-describedby="passwordId">
                <small id="passwordId" class="text-muted d-none">Nama</small>
            </div>
            <div class="form-group">
                <label for="password_new">Password administrator yang baru</label>
                <input  type="password" name="password_new" id="password_new" class="form-control border-0" aria-describedby="passwordnewId">
                <small id="passwordnewId" class="text-muted d-none">Nama</small>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-warning px-5 shadow-warning rounded-pill">Simpan</button>
            </div>
        </form>
        <h3 class="poppins mt-3">Form Token</h3>
        <form action="{{route("profile.token",$token)}}" method="post">
            @csrf
            @method("put")
            <div class="form-group">
                <label for="token">Token baru</label>
                <input required value="{{$token}}" type="text" name="token" id="token" class="form-control border-0" aria-describedby="generate">
                <small id="generate" class="text-muted d-none">Nama</small>
            </div>
            <div class="text-right">
                <button type="button" id="generateToken" class="btn btn-light border-warning px-5 rounded-pill">Generate Token</button>
                <button type="submit" class="btn btn-warning border-warning shadow-warning px-5 rounded-pill">Submit</button>
            </div>
        </form>
        <script>
            $('#generateToken').click(function() {
                let r = Math.random().toString(36).substring(2);
                $('#token').val(r);
            });
        </script>
    </div>
</div>
@endsection
