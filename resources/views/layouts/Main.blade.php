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
                        <h6 class="mt0 mb0 text-danger">عضویت / ورود</h6>
                    </div>
                    <button class="closes" data-bs-dismiss="modal" type="button">
                        ×
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body pt-1">
                    <div class="text-center">
                        <a class="btn-small btn-outline lnk" href="#">
                            <img src="/icons/google.svg" class="img-fluid ml-2" width="15" alt="" />
                            ورود با گوگل
                        </a>
                    </div>
                    <hr class="mb-2" />
                    <div class="form-block fdgn2 mb10" style="overflow: inherit;">
                            <ol class="auth-ul d-none">
                                <li>شماره موبایلتو <strong class="text-danger">بصورت 11 رقمی</strong> وارد کن</li>
                                <li>اگه عضو نباشی، ثبت نام میشی. اگه عضو هستی وارد حساب کابریت میشی</li>
                                <li>اگه عضو هستی و رمزت یادت نیست، شماره موبایلتو وارد کن و  دکمه ارسال رمز رو بزن</li>
                                <li>رمز جدید برات پیامک میشه، رمز رو وارد کن و روی دکمه تایید رمز بزن</li>
                            </ol>
                            <div class="fieldsets">
                                <div class="col-md-12">
                                    <input name="mobile" placeholder="موبایل (11 رقمی بصورت لاتین)" type="text"
                                           minlength="11" maxlength="11" required/>
                                </div>

                                <div class="col-md-12">
                                    <input name="password" placeholder="رمز عبور را وارد نمایید" type="password"
                                           minlength="6" maxlength="64" required/>
                                </div>
                            </div>
                        <div class="fieldsets mt-2">
                            <button class="smllbtnn bg-btn3 lnk" type="button">ورود / عضویت</button>
                        </div>
                            <div class="fieldsets mt-4">
                                <p class="nav-link">عضو هستم ولی رمزم یادم نیست</p>
                                <input name="mobile" placeholder="موبایل (11 رقمی بصورت لاتین)" type="text"
                                       minlength="11" maxlength="11" required/>
                                <button class="bg-btn5 smllbtnn lnk">
                                    ارسال رمز جدید
                                    <i class="fas fa-comment"></i>
                                </button>
                            </div>
                            <div class="fieldsets mt-3">
                                <div class="col-md-12">
                                    <input minlength="6" maxlength="12" placeholder="رمز پیامکی رو وارد کن" type="text" required/>
                                </div>
                            </div>
                            <div class="fieldsets mt-2">
                                <button class="smllbtnn bg-btn3 lnk" type="button">تایید رمز پیامکی</button>
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
