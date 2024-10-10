@extends('layouts.main')

@section('title')
    <title>Alerts | Admin Panel</title>
@endsection

@section('container')
    <div class="container-fluid">
        @if (Session::get('success'))
            <div class="position-fixed w-100 alert alert-success alert-dismissible fade show"
                style="top: 0px; left: 0px; z-index: 1000 !important;" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif
        <div class="row">
            @if ($action == 'update' && session('alerts'))
                <div class="col-md-4 offset-md-1 mt-4 p-2">
                    <div class="w-100 rad bg-white position-relative shadow py-3 px-4">
                        <h5 class="poppins mb-0">Update Alert</h5>
                        <form
                            action="{{ route('alert.update', ['token' => $token, 'alert' => session('alerts')->id_alert]) }}"
                            method="post">
                            @method('put')
                            @csrf
                            <div class="form-group">
                                <label for="nama" class="mt-3 mb-2">Nama Alert</label>
                                <input type="text" required value="{{ session('alerts')->alert_title }}"
                                    name="alert_title" id="alert_title" class="form-control" placeholder="Isi Alert">
                            </div>
                            <div class="form-group">
                                <label for="tipe" class="my-2">Button URL</label>
                                <input type="text" required value="{{ session('alerts')->alert_url }}" name="alert_url"
                                    id="alert_url" class="form-control" placeholder="https://...">
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
            @include('admin.partials.nav_link')
            <div class="w-100 table-parent bg-white">
                <div class="row p-4">
                    <div class="col-md-8">
                        <h4 class="poppins mb-0">Alert</h4>
                        <p class="montserrat" style="font-size: .85rem;">Daftar Alert untuk Tombol
                        </p>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Alert</th>
                            <th>URL</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alerts as $data)
                            <tr>
                                <td style="word-wrap: break-word; max-width: 120px;">{{ $data->alert_title }}</td>
                                <td style="word-wrap: break-word; max-width: 120px;">
                                    <a href="{{ $data->alert_url }}" target="_blank">{{ $data->alert_url }}</a>
                                </td>
                                <td>
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown">
                                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0"
                                                style="padding: 10px;">
                                                <i class="fas fa-ellipsis-h" aria-hidden="true"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="{{ route('alert.edit', ['alert' => $data->id_alert, 'token' => $token]) }}"
                                                    class="dropdown-item text-warning"
                                                    onclick="event.stopPropagation(); onEdit('${full.bin_id}'); return false;"
                                                    style="padding-bottom: 10px; text-align: center; font-weight: 600;">
                                                    <i class='fas fa-pen-alt mx-1 text-warning'></i> Edit
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <script>
                    $('.check-toggle').change(function() {
                        if (this.checked) {
                            $('.btn-print').removeAttr('disabled').removeClass('disabled')
                            $('.check-respond').prop('checked', true);
                        } else {
                            $('.btn-print').addClass('disabled').attr('disabled')
                            $('.check-respond').prop('checked', false);
                        }
                    });
                    $('input[name="checkPrint[]"]').change(function() {
                        var atLeastOneIsChecked = $('input[name="checkPrint[]"]:checked').length > 0;
                        if (atLeastOneIsChecked) {
                            $('.btn-print').removeAttr('disabled').removeClass('disabled')
                        } else {
                            $('.btn-print').addClass('disabled').attr('disabled')
                        }
                    });
                </script>
                <div class="row px-3">
                    <div class="col-md-6">
                        <div class="pb-3">
                            <form method="GET" id="show-form" name="showForm" action="">
                                <div class="form-group d-inline-block">
                                    <input type="hidden" name="page" value="">
                                    <input type="hidden" name="id_category" value="">
                                    <input type="hidden" name="action" value="">
                                    <select id="show-select" name="show" onchange="showData()"
                                        class="form-control form-control-sm d-inline-block"
                                        style="width:70px; font-size: .7rem;">
                                        <option value="10" selected>10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                    </select>
                                </div>
                                <p class="montserrat d-inline" style="font-size: .7rem;">Data per halaman</p>
                                <script>
                                    function showData() {
                                        $('#show-select').change(function() {
                                            var value = $(this).val();
                                            $('#show-form').submit()
                                        });
                                    }
                                </script>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <p class="montserrat d-inline" style="font-size: .7rem;">
                            {{ $alerts->count() }} dari {{ $alerts->count() }} data</p>
                        <a href="#" class="btn btn-sm p-0 px-2 btn-white disabled"><i
                                class="fas fa-caret-left text-warning"></i></a>
                        <a href="#" class="btn btn-sm p-0 px-2 btn-white active">
                            <i class="fas fa-caret-right text-warning"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
