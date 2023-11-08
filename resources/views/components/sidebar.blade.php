<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home.index') }}"><i class="fas fa-home"></i> {{ env('APP_NAME') }} </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home.index') }}">{{ env('SHORT_APP_NAME') }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menus</li>
            @foreach ($menus as $menu)
                @if ($menu->access_to == session('auth.role') || $menu->access_to == 'All')
                    @if ($menu->position == 'S')
                        @if ($menu->child->count() != 0)
                            <li
                                class="dropdown {{ count(explode(Str::lower($menu->name), url()->current())) > 1 ? 'active' : '' }}">
                                <a href="{{ $menu->link }}" class="nav-link has-dropdown"><i
                                        class="{{ $menu->icon }}"></i><span>{{ $menu->name }}</span></a>
                                <ul class="dropdown-menu">
                                    @foreach ($menu->child as $child)
                                        @if ($child->access_to == session('auth.role') || $child->access_to == 'All')
                                            <li
                                                class="{{ count(explode(Str::lower($child->name), url()->current())) > 1 ? 'active' : '' }}">
                                                <a class="nav-link" href="{{ url($child->link) }}"><i
                                                        class="{{ $child->icon }}"></i>{{ $child->name }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            @if ($menu->name == 'Home' && url()->current() == env('APP_URL'))
                                <li class="active">
                                @else
                                <li
                                    class="{{ count(explode(Str::lower($menu->name), url()->current())) > 1 ? 'active' : '' }}">
                            @endif
                            <a class="nav-link" href="{{ url($menu->link) }}">
                                <i class="{{ $menu->icon }}"></i>
                                <span>{{ $menu->name }}</span></a>
                            </li>
                        @endif
                    @endif
                @endif
            @endforeach
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>
