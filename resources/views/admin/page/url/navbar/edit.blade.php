@extends('layouts.main')

@section('title')
    <title>Edit Navbar | Admin Panel</title>
@endsection

@section('container')
<div class="col-md-8 offset-md-2 mt-5">
    <a href="{{ route('navbar.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i class="fas fa-arrow-left"></i> Kembali</a>
    <form action="{{ route('navbar.update', ['token' => $token, 'navbar' => $navbar->id]) }}" method="POST" enctype="multipart/form-data">
        @method('patch')
        @csrf
        <div class="form-group">
            <label for="title">Nama Navbar</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $navbar->title) }}" placeholder="Dashboard/Home" aria-describedby="namaId">
            <small id="namaId" class="text-muted">Hindari penggunaan slash (/,\)</small>
            @error('title')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group" id="route-group">
            <label for="route">URL Navbar</label>
            <input type="text" name="route" id="route-navbar" class="form-control @error('route') is-invalid @enderror" value="{{ old('route', $navbar->route) }}" placeholder="https://..." aria-describedby="tipeId">
            @error('route')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <h4 id="routeNote" class="text-muted my-2 d-none">Bagian URL disembunyikan karena navbar memiliki Sub Navbar.</small>
        </div>
        <div class="row">
            <div class="col col-md-12">
                <div class="form-check form-switch">
                    <input type="hidden" name="is_dropdown" value="0">
                    <input class="form-check-input" type="checkbox" role="switch" name="is_dropdown" id="is_dropdown" value="{{ old('is_dropdown', $navbar->is_dropdown) }}" onchange="this.value=this.checked ? 1 : 0" {{ old('is_dropdown', 0) == 1 ? 'checked' : '' }}/>
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
    const isDropdown = {{ $navbar->is_dropdown ? 'true' : 'false' }};
    const existingSubNavbars = @json($sub_navbar);

    $(document).ready(function () {
        let index = existingSubNavbars.length;

        toggleRouteField(isDropdown);

        if (isDropdown && existingSubNavbars.length > 0) {
            existingSubNavbars.forEach(function (sub, i) {
                const template = `
                    <div class="card mb-3 sub-navbar-item" data-id="${sub.id || ''}">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Sub Navbar #<span class="sub-navbar-index">${i + 1}</span></span>
                            <button type="button" class="btn btn-sm btn-danger remove-sub-navbar">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="sub_navbars[${i}][title]" class="form-control" placeholder="Nama Sub Navbar" value="${sub.title}" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="sub_navbars[${i}][route]" class="form-control" placeholder="/sub-navbar" value="${sub.route}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Icon Saat Ini: ${sub.icon}</label>
                                    <input type="hidden" name="sub_navbars[${i}][id]" value="${sub.id || ''}">
                                    <input type="hidden" name="sub_navbars[${i}][old_icon]" value="${sub.icon}">
                                    <input type="file" name="sub_navbars[${i}][icon]" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="sub_navbars[${i}][description]" class="form-control" placeholder="Deskripsi" value="${sub.description ?? ''}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('#sub-navbar-container').append(template);
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
            const newIndex = $('#sub-navbar-container .sub-navbar-item').length;
            const template = `
                <div class="card mb-3 sub-navbar-item">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Sub Navbar #<span class="sub-navbar-index">${newIndex + 1}</span></span>
                        <button type="button" class="btn btn-sm btn-danger remove-sub-navbar">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-2">
                                <input type="text" name="sub_navbars[${newIndex}][title]" class="form-control" placeholder="Nama Sub Navbar" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" name="sub_navbars[${newIndex}][route]" class="form-control" placeholder="/sub-navbar" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <input type="file" name="sub_navbars[${newIndex}][icon]" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" name="sub_navbars[${newIndex}][description]" class="form-control" placeholder="Deskripsi" required>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#sub-navbar-container').append(template);
            reindexSubNavbars();
        });

        $('#sub-navbar-container').on('click', '.remove-sub-navbar', function() {
            const item = $(this).closest('.sub-navbar-item');
            const id = item.data('id');

            if (id) {
                item.append(`<input type="hidden" name="deleted_sub_navbars[]" value="${id}">`);
                item.remove();
            } else {
                item.remove();
            }

            reindexSubNavbars();
        });

        function reindexSubNavbars() {
            let visibleItems = $('#sub-navbar-container .sub-navbar-item:visible');

            visibleItems.each(function (i, el) {
                const item = $(el);
                item.find('.sub-navbar-index').text(i + 1);

                item.find('[name^="sub_navbars["]').each(function() {
                    const name = $(this).attr('name').replace(/sub_navbars\[\d+\]/g, `sub_navbars[${i}]`);
                    $(this).attr('name', name);
                });
            });

            index = visibleItems.length;
        }
    });
</script>
@endsection
