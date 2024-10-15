<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css')}}">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layouts._partials.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('layouts._partials.topbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1>{{ $title}}</h1>
                        @if (isset($breadcrumbs) && count($breadcrumbs) > 0)
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    @foreach ( $breadcrumbs as $i => $item )
                                        @if ($i == count($breadcrumbs) - 1)
                                            <li class="breadcrumb-item active"><a
                                                href="javascript:void(0)">{{$item->name}}</a>
                                            </li>
                                        @else
                                            <li class="breadcrumb-item"><a href="javascript:void(0)">{{$item->name}}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ol>
                            </div>
                        @endisset
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <img src="" alt="" id="dummy">

    @include('layouts._partials.js')

    @stack('scripts')
</body>
