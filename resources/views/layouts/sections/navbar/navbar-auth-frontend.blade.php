@php
$currentRouteName = Route::currentRouteName();
$activeRoutes = ['front-pages-pricing', 'front-pages-payment', 'front-pages-checkout', 'front-pages-help-center'];
$activeClass = in_array($currentRouteName, $activeRoutes) ? 'active' : '';
@endphp
<!-- Navbar: Start -->
<nav class="layout-navbar shadow-none py-0 border-top-pink sticky-top" style="position: sticky !important; background-color: #ffffff;box-shadow: 0 15px 50px -40px gray !important;">
    <div class="container header-container">
        <div class="navbar navbar-expand-lg landing-navbar shadow-none px-3 px-md-4 mt-0 mx-md-4 justify-content-center">
            <!-- Menu logo wrapper: Start -->
            <div class="navbar-brand app-brand demo d-flex py-0 py-lg-2 me-4">
                <!-- Mobile menu toggle: Start-->
                <button class="navbar-toggler border-0 px-0 me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti ti-menu-2 ti-sm align-middle"></i>
                </button>
                <!-- Mobile menu toggle: End-->
                <a href="{{ url('/') }}" class="app-brand-link">
                    {{-- <span class="app-brand-logo demo">@include('_partials.macros',['height'=>20,'withbg' => "fill: #fff;"])</span>
                    <span class="app-brand-text demo menu-text fw-bold ms-2 ps-1">{{ config('variables.templateName') }}</span> --}}
                    <span class="app-brand-logo">
                        <img src="{{ asset('assets/img/icons/azzia/logo.png') }}" alt="Logo" width="130">
                    </span>
                </a>
            </div>
        <!-- Toolbar: End -->
        </div>
    </div>
</nav>
<!-- Navbar: End -->