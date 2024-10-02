@extends('layouts.main')

@section('title')
    <title>Videos | Admin Panel</title>
@endsection

@section('container')
    <div class="container-fluid">
        @if(Session::get('success'))
        <div class="position-fixed w-100 alert alert-success alert-dismissible fade show" style="top: 0px; left: 0px; z-index: 1000 !important;" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>{{ Session::get('success') }}</strong>
        </div>
        @endif
        <div class="row">
            @if ($action == "update")
            <div class="col-md-4 offset-md-1 mt-4 p-2">
                <div class="w-100 rad bg-white position-relative shadow py-3 px-4">
                    <h5 class="poppins mb-0">Update Video</h5>
                    <form action="{{ route('video.update', ['token' => $token, 'video' => $video->id_link]) }}" method="post">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="nama" class="mt-3 mb-2">Nama Video(Opsional)</label>
                            <input type="text" required value="{{ $video->title }}" name="video_title" id="video_title" class="form-control" placeholder="Judul Video">
                        </div>
                        <div class="form-group">
                            <label for="tipe" class="my-2">URL Video</label>
                            <input type="text" required value="{{ $video->url }}" name="video_url" id="video_url" class="form-control" placeholder="https://...">
                        </div>
{{--                        atambahkan untuk field description--}}
                        <div class="form-group">
                            <label for="description" class="my-2">Deskripsi Video</label>
                            <textarea name="video_description" id="video_description" class="form-control" placeholder="Deskripsi Video">{{ $video->description }}</textarea>
                        </div>
                        <div class="text-right w-100 position-absolute" style="right: 10px;">
                            <button class="btn btn-warning px-4 rounded-pill shadow-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 mt-4 p-2">
            @else
            <div class="col-md-11 offset-md-1 mt-4 p-2">
            @endif
                @include('admin.partials.nav_profile')
                <div class="w-100 table-parent bg-white">
                    <div class="row p-4">
                        <div class="col-md-8">
                            <h4 class="poppins mb-0">Video</h4>
                            <p class="montserrat" style="font-size: .85rem;">Daftar Video untuk Jumbotron
                            </p>
                        </div>
                    </div>
                    <div class="row">
                            @foreach($videos as $index => $data)
                                <div class="col-4">
                                    <div class="card" style="width: 18rem;">
                                        <iframe class="card-img-top" src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::after($data->url, 'youtu.be/') }}?autoplay=1&mute=1&loop=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                        <div class="card-body">
                                            <h5 class="card-title">{{$data->title}}</h5>
                                            <p class="card-text">{{ $data->description }}</p>
                                            <a href="{{route('video.edit',[$token,$data->id_link])}}" class="btn btn-warning">Edit</a>
                                            @if($data->is_used == 1)
                                                <div class="btn btn-gray">Telah Digunakan</div>
                                            @else
                                                <a href="{{route('video.show',['token'=>$token,'video'=>$data->id_link])}}" class="btn btn-primary">Gunakan Ini</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-4">
                                <div class="card" style="width: 18rem;">
                                    <iframe class="card-img-top" src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::after($kemitraan->url, 'youtu.be/') }}?autoplay=1&mute=1&loop=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    <div class="card-body">
                                        <h5 class="card-title">{{$kemitraan->title}}</h5>
                                        <p class="card-text">{{ $kemitraan->description }}</p>
                                        <a href="{{route('video.edit',[$token,$kemitraan->id_link])}}" class="btn btn-warning">Edit</a>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
