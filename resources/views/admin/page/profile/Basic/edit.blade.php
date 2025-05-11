@extends('layouts.main')

@section('title')
    <title>Edit  | Admin Panel</title>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 mt-5">
    <a href="{{ route('basic.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{route('basic.update',['token'=> $token,'id' => $data->id])}}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-12">
                <div class="bg-white shadow-sm p-2 row">
                    <div class="form-group col-8">
                        <label for="name" class="my-2">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ $data->name }}" @if($type === "show") disabled @endif>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group col-4">
                        <label for="alias_name" class="my-2">alias_name</label>
                        <input type="text" name="alias_name" id="alias_name" class="form-control @error('$this->alias_name') is-invalid @enderror" placeholder="alias_name" value="{{ $data->alias_name }}"  disabled>
                        <small class="text-muted">Alias name is used for URL slug (developer only)</small>
                        @error('$this->alias_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group col-12">
                        <label for="url" class="my-2">url</label>
                        <input type="text" name="url" id="url" class="form-control @error('url') is-invalid @enderror" placeholder="url" value="{{ $data->url }}" @if($type === "show") disabled @endif>
                        @error('url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row col-12">
                        @if($type == 'edit')
                            <div class="col-md-6 py-md-5 py-3">
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input onchange="loadFile(event)" type="file" name="logo" id="logo" class="form-control @error('thumbnail') is-invalid @enderror" placeholder="Purwosari, Pasuruan" aria-describedby="imageId">
                                    <small id="imageId" class="text-muted d-none"></small>
                                    @error('thumbnail')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <img class="w-400 rounded" id="preview"
                                     src="{{ asset($data->logo) }}"
                                     alt="Logo">
                                <script type="text/javascript">
                                    function loadFile(event) {
                                        var reader = new FileReader();
                                        reader.onload = function() {
                                            var preview = document.getElementById('preview');
                                            preview.src = reader.result;
                                        }
                                        reader.readAsDataURL(event.target.files[0]);
                                    }
                                </script>
                            </div>
                        @else
                            <div class="col-md-12 text-center">
                                <img class="w-100 rounded" id="preview"
                                     src="{{ asset($data->logo) }}"
                                     alt="Logo">
                            </div>
                        @endif
                    </div>
                </div>
                @if($type == 'edit')
                    <button class="btn btn-warning px-4 mb-4 rounded-pill shadow-warning">Update</button>
                @endif
            </div>
        </div>
    </form>

</div>
@endsection

