@include('admin.layouts.header')
<div id="wrapper">
    <!-- Sidebar -->
    @include('admin.layouts.sidebar')
    <!-- Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <!-- TopBar -->
            @include('admin.layouts.navbar')
            <!-- Topbar -->

            <!-- Container Fluid -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- Container Fluid -->
        </div>
        <!-- Footer -->
        @include('admin.layouts.footer')
        <!-- Footer -->
    </div>
</div>
