<!--

=========================================================
* Volt Free - Bootstrap 5 Dashboard
=========================================================

* Product Page: https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard
* Copyright 2021 Themesberg (https://www.themesberg.com)
* License (https://themesberg.com/licensing)

* Designed and coded by https://themesberg.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. Please contact us to request a removal.

-->
<!DOCTYPE html>
<html lang="en">

@include('layout.header')

<body>

    <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->


    @include('layout.sidebar')

    <main class="content">

        @include('layout.navbar')

        @yield('content')

        @include('layout.footer')
    </main>

    @include('layout.scripts')

</body>

</html>