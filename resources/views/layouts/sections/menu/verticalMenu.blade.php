@php
    $configData = Helper::appClasses();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    @if (!isset($navbarFull))
        <div class="app-brand demo">
            <div class="app-brand-link">
                {{-- <span class="app-brand-logo demo">
                    @include('_partials.macros', ['height' => 20])
                </span>
                <span class="app-brand-text demo menu-text fw-bold">{{ config('variables.templateName') }}</span> --}}
                {{-- <img class="icon_sidebar" src="{{ asset('assets/img/icons/chauffeur/CHAUFFEUR.png') }}"
                    style="width: 8em;margin-left: 2em" alt="" srcset=""> --}}
                <img class="icon_sidebar" src="{{ asset('storage/' . config('configs.img_banner_icon')) }}"
                    style="width: 8em;margin-left: 2em" alt="" srcset="">
            </div>

            <a href="javascript:void(0);" data-is_open="true" onclick="toggleSideBar(this)"
                class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
        </div>
    @endif


    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        {{-- {{ dd(auth()->user()->roles->pluck('name')[0]) }} --}}

        @foreach ($menuData[0]->menu as $menu)
            {{-- adding active and open class if child is active --}}
            {{-- menu headers --}}
            @if (isset($menu->menuHeader))
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">{{ $menu->menuHeader }}</span>
                </li>
            @else
                {{-- active menu method --}}
                @php
                    $activeClass = null;
                    $currentRouteName = Route::currentRouteName();
                    if ($currentRouteName === $menu->slug) {
                        $activeClass = 'active';
                    } elseif (isset($menu->submenu)) {
                        if (isset($menu_open) && $menu->slug) {
                            if ($menu->slug == $menu_open) {
                                $activeClass = 'active open';
                            }
                        }
                    }
                @endphp

                @php
                    $singgle_menu = true;
                    if (isset($menu->slug) && !empty($menu->submenu)) {
                        $singgle_menu = false;
                    } elseif (isset($menu->slug) && empty($menu->submenu) && $menu->slug == $menu_active) {
                        $singgle_menu = true;
                        $activeClass = 'active';
                    }
                @endphp

                {{-- main menu --}}
                <li class="menu-item {{ $activeClass }}">
                    {{-- {{ dd(isSuperAdmin()->toArray()) }} --}}

                    @php
                        $_menu_ifconfition = 'd-none';
                    @endphp
                    @if (in_array('superadmin', isSuperAdmin()->toArray()))
                        @php
                            $_menu_ifconfition = '';
                        @endphp
                    @else
                        @php
                            $_menu_ifconfition = 'd-none';
                        @endphp
                        @if (in_array('_' . $menu->slug, userPermissions()))
                            @php
                                $_menu_ifconfition = '';
                            @endphp
                        @endif
                    @endif
                    <a href="{{ $singgle_menu ? url($menu->url) : 'javascript:void(0);' }}"
                        class="{{ isset($menu->slug) && !empty($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }} {{ $_menu_ifconfition }}"
                        @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                        @isset($menu->icon)
                            <i class="menu-icon tf-icons {{ $menu->icon }}"></i>
                        @endisset
                        <div>
                            {{ isset($menu->name) ? __($menu->name) : '' }}
                        </div>
                        @isset($menu->badge)
                            <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                        @endisset
                    </a>

                    {{-- submenu --}}
                    @isset($menu->submenu)
                        @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                    @endisset
                </li>
            @endif
        @endforeach
    </ul>

</aside>
