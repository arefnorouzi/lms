<!DOCTYPE html>
<html class="no-js" dir="rtl" lang="fa">
<head>
    <meta charset="utf-8"/>
    <title>
        نیواکس - قالب html آژانس طراحی وب و دیجیتال مارکتینگ
    </title>
    <meta content="Creative Agency, Marketing Agency Template" name="description"/>
    <meta content="rajesh-doot" name="author"/>
    <meta content="width=device-width,initial-scale=1" name="viewport"/>
    <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
    <!--website-favicon-->
    <link href="/images/favicon.png" rel="icon"/>
    <!--plugin-css-->
    <link href="/css/bootstrap-main.min.css" rel="stylesheet"/>
    <link href="css/plugin.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <!-- template-style-->
    <link href="/css/style.css" rel="stylesheet"/>
    <link href="/css/responsive.css" rel="stylesheet"/>
    <link href="/css/darkmode.css" rel="stylesheet"/>
    <!-- custom-style-->
    <link href="/css/custom.css" rel="stylesheet"/>
    <!--===== Custom Font css =====-->
    <link href="/css/custom-fonts.css" rel="stylesheet"/>
</head>
<body>
<!--Start Header -->
<header class="nav-bg-w main-header navfix fixed-top menu-white">
    @include('layouts.Main.Header')
</header>
<!--End Header -->

@yield('content')

<!--Start Footer-->
<footer>
    @include('layouts.Main.Footer')
</footer>
<!--End Footer-->
<!-- js placed at the end of the document so the pages load faster -->
<script src="/js/vendor/modernizr-3.5.0.min.js">
</script>
<script src="/js/jquery.min.js">
</script>
<script src="/js/bootstrap-main.bundle.min.js">
</script>
<script src="/js/plugin.min.js">
</script>
<!--common script file-->
<script src="/js/main.js">
</script>
</body>
</html>
