@extends('layouts.main')
{{--@dd($event)--}}
@section('title')
    <title>Agenda | Admin Panel</title>
@endsection

@section('container')
        <div class="row">
            <div class="col-md-11 offset-md-1 mt-4 p-2">
                <div class="w-100 table-parent bg-white">
                    <div class="row p-4">
                        <div class="col-md-8">
                            <h4 class="poppins mb-0">Agenda</h4>
                            <p class="montserrat" style="font-size: .85rem;">Daftar agenda SMKN 1 Purwosari
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('event.create', ['token' => $token]) }}" class="btn-print btn btn-warning shadow-warning px-5 rounded-pill"><i class="fas fa-plus"></i> Agenda Baru</a>
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="pl-4">Agenda</th>
                                <th>Tanggal</th>
                                <th>Tujuan</th>
                                <th>Tanggal upload</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($event as $key => $data)
                            <tr>
                                <td style="word-wrap: break-word; max-width: 300px;">{{ $data->nama }}</td>
                                <td>{{ $data->date }} {{ $data->time }}</td>
                                <td style="word-wrap: break-word; max-width: 200px;">{{ $data->target }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <a href="{{ route('event.show', ['event' => $data->id_pemberitahuan, 'token' => $token]) }}" class="btn btn-warning p-2"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('event.edit', ['event' => $data->id_pemberitahuan, 'token' => $token]) }}" class="btn btn-success p-2"><i class="fas fa-pen-alt"></i></a>
                                    <form action="{{ route('event.destroy', ['event' => $data->id_pemberitahuan , 'token' => $token]) }}" onclick="return confirm('Data akan dihapus ?')" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger p-2"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <script>
                        $('.check-toggle').change(function() {
                            if(this.checked) {
                                $('.btn-print').removeAttr('disabled').removeClass('disabled')
                                $('.check-respond').prop('checked', true);
                            } else {
                                $('.btn-print').addClass('disabled').attr('disabled')
                                $('.check-respond').prop('checked', false);
                            }
                        });
                        $('input[name="checkPrint[]"]').change(function() {
                            var atLeastOneIsChecked = $('input[name="checkPrint[]"]:checked').length > 0;
                            if(atLeastOneIsChecked) {
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
                                        <input type="hidden" name="#">
                                        <select id="show-select" name="show" onchange="showData()" class="form-control form-control-sm d-inline-block"
                                            style="width:70px; font-size: .7rem;" name="" id="">
                                            <option value="10">10</option>
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
                            <p class="montserrat d-inline" style="font-size: .7rem;">{{ $event->firstItem() }} dari {{ $event->lastItem() }}</p>
                            <a href="{{ $event->previousPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $event->onFirstPage() ? 'disabled' : 'active' }}">
                                <i class="fas fa-caret-left text-warning"></i>
                            </a>
                            <a href="{{ $event->nextPageUrl() }}" class="btn btn-sm p-0 px-2 btn-white {{ $event->hasMorePages() ? 'active' : 'disabled' }}">
                                <i class="fas fa-caret-right text-warning"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
