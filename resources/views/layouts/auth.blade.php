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
    @livewireStyles
</head>

<body class="login">

    <div class="container sm:px-10">
        @yield('content')
    </div>

    @livewireScripts
    <script src="/dist/js/app.js"></script>
    @yield('scripts')
</body>

</html>
