<!doctype html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>پنل کاربری | @yield('title')</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet">
    <link href="/css/dashboard.css" rel="stylesheet">
</head>
<body>

<main>

    <div class="wrapper">

        @include('layouts.Dashboard.Sidebar')

        <div class="main p-3">
            <div class="container">
                <a href="/" target="_blank" class="btn btn-outline-dark">مشاهده سایت</a>
                <a href="/shop" target="_blank" class="btn btn-outline-dark">فروشگاه</a>
            </div>
            @yield('content')
        </div>
    </div>
</main>

<footer>

</footer>

<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/admin.js"></script>

@yield('script')
</body>
</html>
