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

<body class="login">

    <div class="container sm:px-10">
        @yield('content')
    </div>

    @livewireScripts
    <script src="/dist/js/app.js"></script>
    @yield('scripts')
</body>

</html>
