@php
    $currentRouteName = Route::currentRouteName();
    $activeRoutes = ['front-pages-pricing', 'front-pages-payment', 'front-pages-checkout', 'front-pages-help-center'];
    $activeClass = in_array($currentRouteName, $activeRoutes) ? 'active' : '';
@endphp

<style>
    .btn-outline-primary {
        color: #DE127D;
        border-color: #DE127D;
    }

    .btn-outline-primary:hover {
        color: white !important;
        background-color: #DE127D !important;
        border-color: #DE127D !important;
    }

    .input-group:focus-within .form-control {
        border-color: #DE127D !important;
    }

    .no-logged {
        display: flex;
        column-gap: 1em;
        margin-left: 3rem;
    }

    .no-logged span.text-dark:hover {
        color: #DE127D !important;
    }

    nav.layout-navbar {
        position: sticky !important;
        background-color: #ffffff;
        box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px !important;
    }
</style>

<!-- Navbar: Start -->
@isMobile
    @include('mobile.pages.home.partials.navbar')
    @elseMobile
    @include('frontend.home.partials.navbar')
@endIsMobile
<!-- Navbar: End -->
