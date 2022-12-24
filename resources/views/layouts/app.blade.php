<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <title>Vers21</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Vers21 rev B">
    <meta name="keywords" content="Vers21 rev b">
    <meta name="author" content="LEFT4CODE">
    <link href="/dist/images/logo.svg" rel="shortcut icon">
    <link rel="stylesheet" href="/dist/css/app.css" />
    @livewireStyles
</head>

<body class="main">
    <div class="mobile-menu md:hidden">
        <div class="mobile-menu-bar">
            <a href="" class="flex mr-auto">
                <img alt="Icewall Tailwind HTML Admin Template" class="w-6" src="dist/images/logo.svg">
            </a>
            <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2"
                    class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        </div>
        <ul class="border-t border-theme-2 py-5 hidden">
            <li>
                <a href="/dashboard" class="menu">
                    <div class="menu__icon"> <i data-feather="home"></i> </div>
                    <div class="menu__title"> Dashboard </div>
                </a>
            </li>
            <li>
                <a href="/bonus" class="menu">
                    <div class="menu__icon"> <i data-feather="gift"></i> </div>
                    <div class="menu__title"> Bonus </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="top-bar-boxed border-b border-theme-2 -mt-7 md:-mt-5 -mx-3 sm:-mx-8 px-3 sm:px-8 md:pt-0 mb-12">
        <div class="h-full flex items-center">
            <!-- BEGIN: Logo -->
            <a href="" class="-intro-x hidden md:flex">
                <img alt="Icewall Tailwind HTML Admin Template" class="w-6" src="dist/images/logo.svg">
                <span class="text-white text-lg ml-3"> Vers<span class="font-medium">21</span> </span>
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
                    <img alt="Icewall Tailwind HTML Admin Template" src="dist/images/profile-4.jpg">
                </div>
                <div class="dropdown-menu w-56">
                    <div class="dropdown-menu__content box bg-theme-11 dark:bg-dark-6 text-white">
                        <div class="p-4 border-b border-theme-12 dark:border-dark-3">
                            <div class="font-medium">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-theme-13 mt-0.5 dark:text-gray-600">
                                {{ auth()->user()->package->name }}</div>
                        </div>
                        <div class="p-2">
                            <a href="javascript:;" data-toggle="modal" data-target="#modal-profile"
                                class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                                <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile
                            </a>
                            <a href="javascript:;" data-toggle="modal" data-target="#modal-pin"
                                class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"><i
                                    data-feather="key" class="w-4 h-4 mr-2"></i> Change PIN
                            </a>
                            <a href="javascript:;" data-toggle="modal" data-target="#modal-password"
                                class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"><i
                                    data-feather="lock" class="w-4 h-4 mr-2"></i> Change Password
                            </a>
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
            <!-- BEGIN: Side Menu -->
            <nav class="side-nav">
                <ul>
                    <li>
                        <a href="/dashboard" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="home"></i> </div>
                            <div class="side-menu__title"> Dashboard </div>
                        </a>
                    </li>
                    <li>
                        <a href="/balance" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="dollar-sign"></i> </div>
                            <div class="side-menu__title"> Balance </div>
                        </a>
                    </li>
                    <li>
                        <a href="/bonus" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="gift"></i> </div>
                            <div class="side-menu__title"> Bonus </div>
                        </a>
                    </li>
                    <li>
                        <a href="/downline" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                            <div class="side-menu__title"> Downline </div>
                        </a>
                    </li>
                    <li>
                        <a href="/renewal" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="refresh-cw"></i> </div>
                            <div class="side-menu__title"> Renewal </div>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- END: Side Menu -->
            <!-- BEGIN: Content -->
            <div class="content">
                {{ $slot }}
            </div>
            <!-- END: Content -->
        </div>
    </div>

    <div id="modal-password" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Change Password</h1>
                </div>
                @livewire('password')
            </div>
        </div>
    </div>

    <div id="modal-profile" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Profile</h2>
                </div>
                @livewire('profile')
            </div>
        </div>
    </div>

    <div id="modal-pin" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">PIN</h1>
                </div>
                @livewire('pin')
            </div>
        </div>
    </div>
    @livewireScripts
    <script src="/dist/js/app.js"></script>
</body>

</html>
