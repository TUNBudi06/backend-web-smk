@extends('layouts.main')

@section('title')
    <title>Show Navbar | Admin Panel</title>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 mt-5">
    <a href="{{ route('navbar.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Nama Navbar</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $navbar->title) }}" placeholder="Dashboard/Home" aria-describedby="namaId" disabled>
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('title')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group" id="route-group">
            <label for="route">URL Navbar</label>
            <input type="text" name="route" id="route-navbar" class="form-control @error('route') is-invalid @enderror" value="{{ old('route', $navbar->route) }}" placeholder="https://..." aria-describedby="tipeId" disabled>
            @error('route')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <h4 id="routeNote" class="text-muted my-2 d-none">Bagian URL disembunyikan karena navbar memiliki Sub Navbar.</small>
        </div>
        <div class="row">
            <div class="col col-md-12">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_dropdown" value="0">
                    <input class="form-check-input" type="checkbox" role="switch" name="is_dropdown" id="is_dropdown" value="{{ old('is_dropdown', $navbar->is_dropdown) }}" onchange="this.value=this.checked ? 1 : 0" {{ old('is_dropdown', 0) == 1 ? 'checked' : '' }} disabled />
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
                    <button type="button" class="btn btn-sm btn-success my-2 d-none" id="add-sub-navbar">
                        + Tambah Sub Navbar
                    </button>
                </div>
            </div>
        </div>
        <div class="text-right mb-4 d-none">
            <button type="submit" class="btn btn-warning mt-5 px-5 rounded-pill shadow-warning"><i class="fas fa-paper-plane"></i> Submit</button>
        </div>
    </form>
</div>
<script>
    const isDropdown = {{ $navbar->is_dropdown ? 'true' : 'false' }};
    const existingSubNavbars = @json($sub_navbar);

    $(document).ready(function () {
        let index = 0;

        toggleRouteField(isDropdown);

        if (isDropdown && existingSubNavbars.length > 0) {
            existingSubNavbars.forEach(function (sub, i) {
                const template = `
                    <div class="row mb-2 sub-navbar-item">
                        <div class="col-md-4">
                            <input type="text" name="sub_navbars[${i}][title]" class="form-control" placeholder="Nama Sub Navbar" value="${sub.title}" required disabled>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="sub_navbars[${i}][route]" class="form-control" placeholder="/sub-navbar" value="${sub.route}" required disabled>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="sub_navbars[${i}][icon]" class="form-control" placeholder="Icon" value="${sub.icon}" required disabled>
                        </div>
                    </div>
                `;
                $('#sub-navbar-container').append(template);
                index++;
            });
        }

        $('#is_dropdown').prop('checked', isDropdown);

        $('#is_dropdown').on('change', function () {
            const checked = $(this).is(':checked');
            toggleRouteField(checked);

            if (!checked) {
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
            const template = `
                <div class="row mb-2 sub-navbar-item">
                    <div class="col-md-4">
                        <input type="text" name="sub_navbars[${index}][title]" class="form-control" placeholder="Nama Sub Navbar" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="sub_navbars[${index}][route]" class="form-control" placeholder="/sub-navbar" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="sub_navbars[${index}][icon]" class="form-control" placeholder="Icon" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger remove-sub-navbar">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            `;
            $('#sub-navbar-container').append(template);
            index++;
        });

        $('#sub-navbar-container').on('click', '.remove-sub-navbar', function () {
            $(this).closest('.sub-navbar-item').remove();
            reindexSubNavbars();
        });

        function reindexSubNavbars() {
            $('#sub-navbar-container .sub-navbar-item').each(function (i, el) {
                $(el).find('input[name^="sub_navbars"]').each(function () {
                    const field = $(this);
                    let newName = '';

                    if (field.attr('placeholder') === 'Nama Sub Navbar') {
                        newName = `sub_navbars[${i}][title]`;
                    } else if (field.attr('placeholder') === '/sub-navbar') {
                        newName = `sub_navbars[${i}][route]`;
                    } else if (field.attr('placeholder') === 'Icon') {
                        newName = `sub_navbars[${i}][icon]`;
                    }

                    field.attr('name', newName);
                });
            });
        }
    });
</script>
@endsection
