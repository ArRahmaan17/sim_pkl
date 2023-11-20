<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image-picture"
                    src="{{ $profile_picture != null ? 'data:image/png;base64,' . profile_asset($profile_picture) : asset('img/avatar/avatar-1.png') }}"
                    class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ session('auth.username') }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">
                    Logged in
                    {{ now()->parse(session('auth.last_login'), 'Asia/Jakarta')->shortRelativeDiffForHumans(now('Asia/Jakarta')->format('Y-m-d H:i:s')) }}
                </div>
                @foreach ($menus as $menu)
                    @if ($menu->position == 'N')
                        <a href="{{ $menu->link }}"
                            class="dropdown-item has-icon {{ count(explode(Str::lower($menu->name), url()->current())) > 1 ? 'active' : '' }}">
                            <i class="{{ $menu->icon }}"></i> {{ $menu->name }}
                        </a>
                    @endif
                @endforeach
            </div>
        </li>
    </ul>
</nav>
