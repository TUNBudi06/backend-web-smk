@extends('layouts.main')

@section('title')
    <title>Komite | Admin Panel</title>
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
            @if ($action == "update" && session('komite'))
            <div class="col-md-4 offset-md-1 mt-4 p-2">
                <div class="w-100 rad bg-white position-relative shadow py-3 px-4">
                    <h5 class="poppins mb-0">Update Komite</h5>
                    <form action="{{ route('komite.update', ['token' => $token, 'komite' => session('komite')->id_komite]) }}" method="post">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="tipe" class="my-2">Komite URL</label>
                            <input type="text" required value="{{ session('komite')->komite_url }}" name="komite_url" id="komite_url" class="form-control" placeholder="https://...">
                        </div>
                        <div class="text-right w-100 position-absolute" style="right: 10px;">
                            <button class="btn btn-warning px-4 rounded-pill shadow-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 mt-4 p-2">
            @else
            <div class="col-md-8 offset-md-2 mt-4 p-2">
            @endif
                <div class="w-100 table-parent bg-white">
                    <div class="row p-4">
                        <div class="col-md-8">
                            <h4 class="poppins mb-0">Komite</h4>
                            <p class="montserrat" style="font-size: .85rem;">Daftar Komite untuk URL
                            </p>
                        </div>
                    </div>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>no</th>
                                <th>id_link</th>
                                <th>title</th>
                                <th>URL Komite</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($other as $index => $data)
                            <tr>
                                <td>{{ $index }}</td>
                                <td>{{ $data->id_link }}</td>
                                <td>{{$data->title}}</td>
                                <td style="word-wrap: break-word; max-width: 120px;">
                                    <a href="{{ $data->url }}" target="_blank">{{ $data->url }}</a>
                                </td>
                                <td>
{{--                                    <a href="{{ route('komite.edit', ['komite' => $data->id_komite, 'token' => $token]) }}" class="btn btn-success p-2"><i class="fas fa-pen-alt"></i></a>--}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <script type="text/javascript">
                        $(document).ready(function () {
                           $('#table').DataTable()
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
