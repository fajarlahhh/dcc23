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
    <div class="mobile-menu md:hidden">
        <div class="mobile-menu-bar">
            <a href="" class="flex mr-auto">
                <img alt="Icewall Tailwind HTML Admin Template" class="w-6" src="/dist/images/logo.png">
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
                <a href="/balance" class="menu">
                    <div class="menu__icon"> <i data-feather="dollar-sign"></i> </div>
                    <div class="menu__title"> Balance </div>
                </a>
            </li>
            <li>
                <a href="/bonus" class="menu">
                    <div class="menu__icon"> <i data-feather="gift"></i> </div>
                    <div class="menu__title"> Bonus </div>
                </a>
            </li>
            <li>
                <a href="/downline" class="menu">
                    <div class="menu__icon"> <i data-feather="users"></i> </div>
                    <div class="menu__title"> Downline </div>
                </a>
            </li>
            @if (auth()->user()->upline_id == null)
                <hr>
                <li>
                    <a href="/dailybonus" class="menu">
                        <div class="menu__icon"> <i data-feather="calendar"></i> </div>
                        <div class="menu__title">
                            Daily Bonus </div>
                    </a>
                </li>
                <li>
                    <a href="/datamember" class="menu">
                        <div class="menu__icon"> <i data-feather="command"></i> </div>
                        <div class="menu__title"> Data Member </div>
                    </a>
                </li>
                <li>
                    <a href="/requestactivation" class="menu">
                        <div class="menu__icon"> <i data-feather="star"></i> </div>
                        <div class="menu__title"> Request Activation </div>
                    </a>
                </li>
                <li>
                    <a href="/requestdeposit" class="menu">
                        <div class="menu__icon"> <i data-feather="codepen"></i> </div>
                        <div class="menu__title"> Request Deposit </div>
                    </a>
                </li>
                <li>
                    <a href="/requestwd" class="menu">
                        <div class="menu__icon"> <i data-feather="bookmark"></i> </div>
                        <div class="menu__title"> Request WD </div>
                    </a>
                </li>
            @endif
        </ul>
    </div>
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
            <div class="intro-x mr-3 text-red">
                <button class="btn btn-sm btn-secondary mr-1 mt-2 mb-2" disabled>Hy, {{ auth()->user()->name }}
                    ({{ auth()->user()->username }})</button>
            </div>
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
                    @if (auth()->user()->upline_id == null)
                        <hr>
                        <li>
                            <a href="/dailybonus" class="side-menu">
                                <div class="side-menu__icon"> <i data-feather="calendar"></i> </div>
                                <div class="side-menu__title">
                                    Daily Bonus </div>
                            </a>
                        </li>
                        <li>
                            <a href="/datamember" class="side-menu">
                                <div class="side-menu__icon"> <i data-feather="command"></i> </div>
                                <div class="side-menu__title"> Data Member </div>
                            </a>
                        </li>
                        <li>
                            <a href="/requestactivation" class="side-menu">
                                <div class="side-menu__icon"> <i data-feather="star"></i> </div>
                                <div class="side-menu__title"> Request Activation </div>
                            </a>
                        </li>
                        <li>
                            <a href="/requestdeposit" class="side-menu">
                                <div class="side-menu__icon"> <i data-feather="codepen"></i> </div>
                                <div class="side-menu__title"> Request Deposit </div>
                            </a>
                        </li>
                        <li>
                            <a href="/requestwd" class="side-menu">
                                <div class="side-menu__icon"> <i data-feather="bookmark"></i> </div>
                                <div class="side-menu__title"> Request WD </div>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
            <!-- END: Side Menu -->
            <!-- BEGIN: Content -->
            <div class="content">
                @if (!auth()->user()->pin)
                    @livewire('form.createpin')
                @endif
                @if (!auth()->user()->wallet)
                    @livewire('form.createwallet')
                @endif
                @if (auth()->user()->package->benefit +
                    auth()->user()->bonus->where('amount', '<', 0)->sum('amount') <
                    auth()->user()->package->minimum_withdrawal)
                    @livewire('form.reinvest')
                @endif
                @livewire('form.createpassword')
                {{ $slot }}
            </div>
            <!-- END: Content -->
        </div>
    </div>

    <x-modal title='Password'>
        @livewire('form.password')
    </x-modal>
    <x-modal title='Profile'>
        @livewire('form.profile')
    </x-modal>
    <x-modal title='Pin'>
        @livewire('form.pin')
    </x-modal>

    @livewireScripts

    <script src="/dist/js/app.js"></script>
    @stack('scripts')
</body>

</html>
