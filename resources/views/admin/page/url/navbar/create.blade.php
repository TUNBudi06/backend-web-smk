@extends('layouts.main')

@section('title')
    <title>Navbar | Admin Panel</title>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 mt-5">
    <a href="{{ route('navbar.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('navbar.store', ['token' => $token]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Nama Navbar</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Dashboard/Home" aria-describedby="namaId">
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('title')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group" id="route-group">
            <label for="route">URL Navbar</label>
            <input type="text" name="route" id="route-navbar" class="form-control @error('route') is-invalid @enderror" value="{{ old('route') }}" placeholder="https://..." aria-describedby="tipeId">
            @error('route')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <h4 id="routeNote" class="text-muted my-2 d-none">Bagian URL disembunyikan karena navbar memiliki Sub Navbar.</small>
        </div>
        <div class="row">
            <div class="col col-md-12">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_dropdown" value="0">
                    <input class="form-check-input" type="checkbox" role="switch" name="is_dropdown" id="is_dropdown" value="{{ old('is_dropdown', 0) }}" onchange="this.value=this.checked ? 1 : 0" {{ old('is_dropdown', 0) == 1 ? 'checked' : '' }}/>
                    <label class="form-check-label" for="is_dropdown">
                        Dropdown (Punya Sub Navbar?)
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-12">
                <div id="sub-navbar-section" class="d-none">
                    <h5 class="mt-4 mb-2">Sub Navbar</h5>
                    <div id="sub-navbar-container"></div>
                    <button type="button" class="btn btn-sm btn-success my-2" id="add-sub-navbar">
                        + Tambah Sub Navbar
                    </button>
                </div>
            </div>
        </div>
        <div class="text-right mb-4">
            <button type="submit" class="btn btn-warning mt-5 px-5 rounded-pill shadow-warning"><i class="fas fa-paper-plane"></i> Submit</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        let index = 0;

        toggleRouteField($('#is_dropdown').is(':checked'));
        $('#is_dropdown').on('change', function () {
            toggleRouteField($(this).is(':checked'));

            if (!$(this).is(':checked')) {
                $('#sub-navbar-container').empty();
                index = 0;
            }
        });

        function toggleRouteField(isChecked) {
            if (isChecked) {
                $('#sub-navbar-section').removeClass('d-none');
                $('#route-group').addClass('d-none');
                $('#route-navbar').val('');
                $('#routeNote').removeClass('d-none');
            } else {
                $('#sub-navbar-section').addClass('d-none');
                $('#route-group').removeClass('d-none');
                $('#routeNote').addClass('d-none');
            }
        }

        $('#add-sub-navbar').on('click', function () {
            const index = $('#sub-navbar-container .sub-navbar-item').length + 1;

            const template = `
                <div class="card mb-3 sub-navbar-item">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Sub Navbar #<span class="sub-navbar-index">${index}</span></span>
                        <button type="button" class="btn btn-sm btn-danger remove-sub-navbar">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-2">
                                <input type="text" name="sub_navbars[][title]" class="form-control" placeholder="Nama Sub Navbar" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" name="sub_navbars[][route]" class="form-control" placeholder="/sub-navbar" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <input type="text" name="sub_navbars[][icon]" class="form-control" placeholder="Icon" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" name="sub_navbars[][description]" class="form-control" placeholder="Deskripsi" required>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $('#sub-navbar-container').append(template);
            reindexSubNavbars();
        });

        $('#sub-navbar-container').on('click', '.remove-sub-navbar', function () {
            $(this).closest('.sub-navbar-item').remove();
            reindexSubNavbars();
        });

        function reindexSubNavbars() {
            $('#sub-navbar-container .sub-navbar-item').each(function (i, el) {
                $(el).find('.sub-navbar-index').text(i + 1);

                $(el).find('input[name^="sub_navbars"]').each(function () {
                    const field = $(this);
                    const placeholder = field.attr('placeholder');
                    let name = '';

                    if (placeholder === 'Nama Sub Navbar') name = `sub_navbars[${i}][title]`;
                    else if (placeholder === '/sub-navbar') name = `sub_navbars[${i}][route]`;
                    else if (placeholder === 'Icon') name = `sub_navbars[${i}][icon]`;
                    else if (placeholder === 'Deskripsi') name = `sub_navbars[${i}][description]`;

                    field.attr('name', name);
                });
            });
        }

    });
</script>
@endsection
