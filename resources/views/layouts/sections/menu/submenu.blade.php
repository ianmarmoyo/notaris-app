<ul class="menu-sub">
    @if (isset($menu))
        @foreach ($menu as $submenu)
            {{-- active menu method --}}
            @php
                $activeClass = null;
                $active = $configData['layout'] === 'vertical' ? 'active open' : 'active';
                $currentRouteName = Route::currentRouteName();

                if (isset($menu_active) && '/admin/' . $menu_active === $submenu->url) {
                    $activeClass = 'active';
                }
            @endphp
            <li class="menu-item {{ $activeClass }}">

                @php
                    $_menu_ifconfition = 'd-none';
                @endphp
                @if (in_array('superadmin', isSuperAdmin()->toArray()))
                    @php
                        $_menu_ifconfition = '';
                    @endphp
                @else
                    @php
                        $_menu_ifconfition = '';
                    @endphp
                    @if (in_array('_' . $submenu->slug, userPermissions()))
                        @php
                            $_menu_ifconfition = '';
                        @endphp
                    @else
                        <?php $_menu_ifconfition = 'd-none'; ?>
                    @endif
                @endif

                <a href="{{ isset($submenu->slug) ? url($submenu->url) : 'javascript:void(0)' }}"
                    class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }} {{ $_menu_ifconfition }}"
                    @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
                    @if (isset($submenu->icon))
                        <i class="{{ $submenu->icon }}"></i>
                    @endif
                    <div>
                        {{ isset($submenu->name) ? __($submenu->name) : '' }}
                    </div>
                </a>

                {{-- submenu --}}
                @if (isset($submenu->submenu))
                    @include('layouts.sections.menu.submenu', ['menu' => $submenu->submenu])
                @endif
            </li>
        @endforeach
    @endif
</ul>
