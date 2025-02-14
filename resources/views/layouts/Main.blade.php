<!DOCTYPE html>
<html class="no-js" dir="rtl" lang="fa">
<head>
    <meta charset="utf-8"/>
    <title>@yield('title') | مارلیک افزار</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

<!-- Start Auth Modal -->
<div class="popup-modal1">
    <div class="modal" id="auth-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="common-heading">
                        <h5 class="mt0 mb0 text-danger">عضویت / ورود به حساب کاربری</h5>
                    </div>
                    <button class="closes" data-bs-dismiss="modal" type="button">
                        ×
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-block fdgn2 mb10" style="overflow: inherit;">
                        <form action="#" method="post" name="feedback-form">
                            <ol class="auth-ul">
                                <li>شماره موبایل خود را <strong class="text-danger">بصورت 11 رقمی</strong> وارد نمایید</li>
                                <li>سپس دکمه <strong class="text-danger">دریافت کد تایید</strong> را لمس نمایید</li>
                                <li>کد تایید برای شما پیامک خواهد شد.</li>
                                <li>پس از وارد کردن کد تایید، دکمه تایید کد را لمس نمایید</li>
                            </ol>
                            <div class="fieldsets row">
                                <div class="col-md-12">
                                    <input name="mobile" placeholder="موبایل (11 رقمی بصورت لاتین)" type="text"
                                           minlength="11" maxlength="11" required/>
                                </div>
                            </div>
                            <div class="fieldsets">
                                <button class="bg-btn5 smllbtnn lnk">
                                    دریافت کد تایید
                                    <i class="fas fa-comment">
                                    </i>
                                </button>
                            </div>
                            <div class="fieldsets mt-5">
                                <div class="col-md-12">
                                    <input name="verify_code" min="10000" max="500000" placeholder="کد فعالسازی دریافتی را وارد نمایید" type="number"/>
                                </div>
                            </div>
                            <div class="fieldsets mt-2">
                                <button class="smllbtnn bg-btn3 lnk" type="button">تایید کد</button>
                            </div>
                        </form>
                        <hr class="my-4" />
                        <div class="text-center">
                            <a class="btn-outline lnk" href="#">
                                <img src="/icons/google.svg" class="img-fluid ml-2" width="15" alt="" />
                                ورود با گوگل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Auth Modal -->

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
<script src="/js/main.js"></script>
@yield('script')
</body>
</html>
