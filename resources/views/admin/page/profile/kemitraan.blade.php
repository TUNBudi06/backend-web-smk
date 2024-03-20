@extends('layouts.main')

@section('title')
    <title>Profile Kemitraan | Admin Panel</title>
@endsection

@section('container')
        <div class="row">
            <div class="col-md-11 offset-md-1">
                @include('admin.partials.nav_profile')
                <div class="row">
                    <div class="col-md-5">
                        <div class="w-100 shadow bg-white rad position-relative p-4">
                            <h5 class="poppins">Masukkan gambar untuk mengganti</h5>
                            <form enctype="multipart/form-data" method="POST" action="">
                                <div class="form-group">
                                    <label for="">Gambar</label>
                                    <input required type="file" name="image" id="image" class="form-control" aria-describedby="helpId">
                                    <small id="helpId" class="text-muted">Harus format jpeg / jpg</small>
                                </div>
                                <button class="btn btn-warning shadow-warnig px-5 rounded-pill position-absolute" style="right: 10px;">Submit</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="w-100 rad bg-white p-4">
                            <h4 class="poppins mb-0">Kemitraan</h4>
                            <p class="montserrat" style="font-size: .85rem;">Kemitraan SMKN 1 Purwosari</p>
                            <div class="text-center">
                                <img src="{{ asset('img/kemitraan.jpg') }}" class="w-100" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection