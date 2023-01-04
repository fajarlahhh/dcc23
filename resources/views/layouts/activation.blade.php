<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <title>DCC23</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DCC23">
    <meta name="keywords" content="DCC23">
    <meta name="author" content="LEFT4CODE">
    <link href="/dist/images/logo.png" rel="shortcut icon">
    <link rel="stylesheet" href="/dist/css/app.css" />
    @stack('styles')
    @livewireStyles
</head>

<body class="main">
    <div class="top-bar-boxed border-b border-theme-2 -mt-7 md:-mt-5 -mx-3 sm:-mx-8 px-3 sm:px-8 md:pt-0 mb-12">
        <div class="h-full flex items-center">
            <!-- BEGIN: Logo -->
            <a href="" class="-intro-x hidden md:flex">
                <img alt="Icewall Tailwind HTML Admin Template" class="w-6" src="/dist/images/logo.png">
                <span class="text-white text-lg ml-3"> DCC<span class="font-medium">23</span> </span>
            </a>
            <!-- END: Logo -->
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto">
            </div>
            <!-- END: Breadcrumb -->
            <!-- BEGIN: Account Menu -->
            <div class="intro-x dropdown w-8 h-8">
                <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110"
                    role="button" aria-expanded="false">
                    <img alt="Icewall Tailwind HTML Admin Template" src="/dist/images/profile-4.jpg">
                </div>
                <div class="dropdown-menu w-56">
                    <div class="dropdown-menu__content box bg-theme-11 dark:bg-dark-6 text-white">
                        <div class="p-4 border-b border-theme-12 dark:border-dark-3">
                            <div class="font-medium">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-theme-13 mt-0.5 dark:text-gray-600">
                                {{ auth()->user()->package->name }}</div>
                        </div>
                        <div class="p-2 border-t border-theme-12 dark:border-dark-3">
                            <a href="javascript:;"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"><i
                                    data-feather="toggle-right" class="w-4 h-4 mr-2"></i>Logout</a>
                            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Account Menu -->
        </div>
    </div>
    <div class="wrapper">
        <div class="wrapper-box">
            <!-- BEGIN: Content -->
            <div class="content">
                @yield('content')
            </div>
            <!-- END: Content -->
        </div>
    </div>

    @livewireScripts

    <script src="/dist/js/app.js"></script>
    @stack('scripts')
</body>

</html>
