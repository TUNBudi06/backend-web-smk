<div class="row">
    <div class="col-md-8 offset-md-1 col-9">
        <div class="form-group my-3 shadow-sm">
            <div class="input-group">
                <input type="text" name="key" id="key" class="form-control poppins border-1 border-right-0 bg-transparent" placeholder="Cari sesuatu" aria-describedby="helpId">
                <div class="input-group-append">
                    <span class="input-group-text bg-transparent border-1 border-left-0"><i class="fas fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-3 px-4 pt-3 text-center">
        <a href="{{ route('profile', ['token' => $token]) }}">
            <div class="avatar-admin-nav mx-3 shadow rounded-circle">
                <img src="{{ session()->get('user')->image ? asset('img/users/' . session()->get('user')->image) : asset('img/illust/male.svg') }}" class="w-100" alt="">
            </div>
        </a>
    </div>
</div>
