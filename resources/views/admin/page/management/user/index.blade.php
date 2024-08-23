@extends('layouts.main')

@section('title')
    <title>User Management | Admin Panel</title>
@endsection

@section('container')
    <div class="row">
        <div class="col-md-11 offset-md-1 mt-4 p-2">
            <div class="menu-profile-admin mb-4">
                <a href="{{ route('user.index',$token) }}"
                   class="<?= \Illuminate\Support\Facades\Route::is('user.index')  ? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">User</a>
                <a href="{{ route('pengumuman.index',$token) }}"
                   class="<?= \Illuminate\Support\Facades\Route::is('')? 'btn my-1 btn-warning px-4 shadow-warning' : 'btn my-1 btn-light px-4 border-warning'?>">Log</a>
            </div>
            <div class="w-100 table-parent bg-white">
                <div class="row p-4">
                    <div class="col-md-8">
                        <h4 class="poppins mb-0">User</h4>
                        <p class="montserrat" style="font-size: .85rem;">Daftar User SMKN 1 Purwosari
                        </p>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('user.create', ['token' => $token]) }}"
                            class="btn-print btn btn-warning shadow-warning px-5 rounded-pill"><i class="fas fa-plus"></i>
                            User Baru</a>
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
                <table id="userTable">
                    <thead>
                    <tr>
                        <th class="pl-4">Gambar</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $index => $userd)
                            <tr>
                                <td><img src="" width="100px" class="rounded" alt=""></td>
                                <td>{{$userd->name}}</td>
                                <td>{{$userd->email}}</td>
                                <td>{{$userd->role == 1 ? 'SuperAdmin':'Admin'}}</td>
                                <td>
                                    <a href="{{route('user.show',[$token,$userd->id_admin])}}" class="btn btn-success p-2"><i class="fas fa-pen-alt"></i></a>
                                    <form action="{{route('user.destroy',['token'=>$token,'user'=>$userd->id_admin])}}" onclick="return confirm('Data akan dihapus ?')" method="post" class="d-inline">
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
                    $(document).ready(function () {
                        $('#userTable').DataTable({
                            "createdRow": function (row) {
                                $('td', row).css('border', '1px solid #000');
                            }
                        });
                    });
                </script>
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
            </div>
        </div>
    </div>
@endsection
