<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="admin template, angular admin template, bootstrap admin template, modern admin template, modern design admin template, dashboard template, responsive admin template, angular web app, crypto dashboard, bitcoin dashboard">
        <title>Raya Exchange | login</title><!-- GLOBAL VENDORS-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CRoboto:300,400,500,600,700" media="all">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <link href="/assets/vendors/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
        <link href="/assets/vendors/themify-icons/themify-icons.css" rel="stylesheet" />
        <link href="/assets/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" /><!-- PAGE LEVEL VENDORS-->
        <!-- THEME STYLES-->
        <link href="/assets/css/app.min.css" rel="stylesheet" /><!-- PAGE LEVEL STYLES-->
        <link href="/assets/css/style.css" rel="stylesheet" /><!-- PAGE RTL STYLES-->
        <style>.login-page {
                display: flex;
                justify-content: flex-end;
                flex: 1 0 auto;
                height: 100%;
                background: url('/assets/img/blog/01.jpeg') no-repeat center center;
                background-size: cover;
            }
            .login-page:before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.6);
            }
            .login-content {
                width: 500px;
                height: 100%;
                overflow-y: auto;
                z-index: 10;
                position: relative;
            }
            .login-content>.card {
                margin: 0;
                height: 100%;
                min-height: 100%;
                box-shadow: none;
                border-radius: 0;
                background-color: #fff;
            }
            .auth-brand-text {
                font-size: 24px;
            }
            .auth-welcome-box {
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                align-items: flex-start;
                flex-grow: 1;
                flex-basis: 0;
                padding: 20px;
                max-width: 100%;
                color: #eee;
                z-index: 2;
                padding: 2rem;
            }
            .auth-features-box {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
            }
            .auth-features-box>div {
                padding: 5px;
                margin-right: 1rem;
                margin-bottom: 1rem;
                text-align: center;
            }
            .auth-features-box .features-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                height: 60px;
                width: 60px;
                border-radius: 50%;
                font-size: 24px;
                background-color: rgba(0, 0, 0, .5);
            }
            @media (max-width: 767.98px) {
                .login-content {
                    width: 100%;
                }
            }
        </style>
    </head>

    <body>
        <div class="login-page">
            <div class="auth-welcome-box text-white pl-lg-5 d-none d-lg-flex">
                <div><a class="btn btn-link home-link text-white-50 pl-lg-5" href="index.html"><span class="btn-icon"><i class="ti-arrow-left font-20"></i>رفتن به برگه اصلی</span></a></div>
                <div class="pl-lg-5">
                    <h4 class="font-40 mb-4">پیوستن به گروه ما</h4>
                    <p class="mb-0">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ, <br>	و با استفاده از طراحان گرافیک است. چاپگرها و متون. <br>بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است.</p>
                </div>
                <div class="pl-lg-5 font-13"><span class="text-white-50">2019 © تمامی حقوق محفوظ است</span><span class="pl-5"><a class="text-white" href="#" style="border-bottom: 1px solid;">درباره</a><a class="ml-3 text-white" href="#" style="border-bottom: 1px solid;">سیاست</a></span></div>
            </div>
            <div class="login-content">
                <div class="card">
                    <div class="card-body bg-white p-5">
                        <h3 class="mb-4 text-primary text-center">
                            <img src="/assets/img/raya-logo.png" style="max-height: 100px">
                        </h3>
                        <div class="font-18 text-center mb-5">ورود به حساب کاربری</div>
                        <form id="login-form" action="/dologin" method="post">
                            @csrf
                            <div class="mb-4">
                                <div class="md-form mb-0"><input class="md-form-control" type="email" name="email"><label>ایمیل</label></div>
                            </div>
                            <div class="mb-4">
                                <div class="md-form mb-0"><input class="md-form-control" type="password" name="password"><label>رمز عبور</label></div>
                            </div>
                            <div class="flexbox mb-5">
                                <button class="btn btn-primary" style="min-width: 100px">ورود</button>
                            </div>
                        </form>
                        <p class="mt-5 mb-4 text-muted text-center">یا با شبکه های اجتماعی وارد شوید</p>
                        <div class="mb-5">
                            <button class="btn btn-google btn-block"><span class="btn-icon"><i class="fab fa-google-plus-g"></i>گوگل</span></button>
                        </div>
                        <p class="mt-5 mb-4 text-muted text-center">می‌خواهید در رایا <a href="/signup">ثبت نام کنید؟</a></p>
                    </div>
                </div>
            </div>
        </div><!-- BEGIN: Page backdrops-->
        <div class="sidenav-backdrop backdrop"></div>
        <div class="preloader-backdrop">
            <div class="page-preloader">Loading</div>
        </div><!-- END: Page backdrops-->
        <!-- CORE PLUGINS-->
        <script src="/assets/vendors/jquery/dist/jquery.min.js"></script>
        <script src="/assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script><!-- PAGE LEVEL PLUGINS-->
        <script src="/assets/vendors/jquery-validation/dist/jquery.validate.min.js"></script><!-- CORE SCRIPTS-->
        <script src="/assets/js/app.min.js"></script><!-- PAGE LEVEL SCRIPTS-->
        <script>
            $(function () {
                $('#login-form').validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true
                        }
                    },
                    errorClass: 'invalid-feedback',
                    validClass: 'valid-feedback',
                    errorPlacement: function (error, element) {
                        if (element.hasClass('md-form-control')) {
                            error.insertAfter(element.closest('.md-form'));
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    highlight: function (e) {
                        $(e).addClass("invalid").removeClass('valid');
                    },
                    unhighlight: function (e) {
                        $(e).removeClass("invalid").addClass('valid');
                    },
                });
            });
        </script>
    </body>

</html>