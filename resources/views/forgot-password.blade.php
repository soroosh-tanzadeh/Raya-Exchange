

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="admin template, angular admin template, bootstrap admin template, modern admin template, modern design admin template, dashboard template, responsive admin template, angular web app, crypto dashboard, bitcoin dashboard">
        <title>RayaEX | بازیابی رمزعبور</title><!-- GLOBAL VENDORS-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CRoboto:300,400,500,600,700" media="all">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <link href="/assets/vendors/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
        <link href="/assets/vendors/themify-icons/themify-icons.css" rel="stylesheet" />
        <link href="/assets/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" /><!-- PAGE LEVEL VENDORS-->
        <!-- THEME STYLES-->
        <link href="/assets/css/app.min.css" rel="stylesheet" /><!-- PAGE LEVEL STYLES-->
        <link href="/assets/vendors/sweetalert2/dist/sweetalert2.css" rel="stylesheet" /><!-- PAGE RTL STYLES-->
        <link href="/assets/css/style.css" rel="stylesheet" /><!-- PAGE RTL STYLES-->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="jeeb-verification" content="O4AQ3GUGYFFGJRFHUXRK7VE6LV7K2Q">
        <style>body {
                background-color: #eff4ff;
            }
            .auth-wrapper {
                flex: 1 0 auto;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 50px 15px 30px 15px;
            }
            .auth-content {
                max-width: 900px;
                flex-basis: 900px;
                box-shadow: 0 1px 15px 1px rgba(62, 57, 107, .07);
            }
            .home-link {
                position: absolute;
                left: 5px;
                top: 10px;
            }
        </style>
    </head>

    <body>
        <div class="page-wrapper">
            <div class="auth-wrapper">
                <div class="row auth-content mx-0">
                    <div class="col-md-6 bg-white p-5">
                        <div>
                            <div class="text-center mb-5">
                                <h4 class="mb-3">بازیابی رمزعبور</h4>
                            </div>
                            <form id="signupForm" action="javascript:;">
                                @csrf
                                <div class="mb-4">
                                    <input class="form-control" placeholder="شماره موبایل" type="text" name="phone" id="vcodereceiver" pattern="^(\+98|0)?9\d{9}$" title="شماره موبایل نامعتبر است.">
                                </div>
                                <div id="passs" style="display: none">
                                    <div class="mb-4">
                                        <input class="form-control" placeholder="رمز عبور" type="password" name="password" id="password1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title=" رمزعبور حداقل از ۸ کاراکتر و شامل حروف کوچک ، بزرگ و عدد باشد. ">
                                    </div>
                                    <div class="mb-4">
                                        <input class="form-control" placeholder="تکرار رمزعبور" type="password" id="password2">
                                    </div>  
                                </div>
                                <div class="flexbox mb-5">
                                    <button class="btn btn-primary btn-rounded" id="sendvcode" onclick="sendVcode();return false;" style="min-width: 100px">دریافت کد بازیابی</button>
                                </div>
                                <br>
                                <p class="mt-5 mb-4 text-muted text-center"> حساب کاربری دارید؟<a  href="/" id="loginbtn">وارد شوید.</a></p>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 bg-danger text-white p-5 d-flex flex-column justify-content-center">
                        <div class="h-100 ">
                            <div class="d-flex h-100 justify-content-center align-items-center flex-column w-100">
                                <div class="bg-white rounded-lg p-3 shadow">
                                    <img src="/assets/img/raya-logo.png" style="max-width: 150px"/>
                                </div>
                                <h4 class="my-4">RayaEX</h4>
                            </div>
                        </div>
                        <div class="flexbox font-13 text-white-50 justify-content-center align-items-center">
                            <span>2020 © طراحی و توسعه توسط <a style="color: #FFF;" class="bold mx-1" href="https://webflax.ir">وب‌فلکس</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- BEGIN: Page backdrops-->
        <div class="sidenav-backdrop backdrop"></div>
        <div class="preloader-backdrop">
            <div class="page-preloader">در حال بارگذاری</div>
        </div><!-- END: Page backdrops-->
        <!-- CORE PLUGINS-->
        <script src="/assets/vendors/jquery/dist/jquery.min.js"></script>
        <script src="/assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script><!-- PAGE LEVEL PLUGINS-->
        <script src="/assets/vendors/jquery-validation/dist/jquery.validate.min.js"></script><!-- CORE SCRIPTS-->
        <script src="/assets/js/app.min.js"></script><!-- PAGE LEVEL SCRIPTS-->
        <script src="/assets/vendors/sweetalert2/dist/sweetalert2.all.js"></script><!-- PAGE LEVEL SCRIPTS-->
        <script>


                                        $(".form-control").change(function () {
                                            if (this.hasAttribute("pattern")) {
                                                var regex = new RegExp($(this).attr("pattern"));
                                                if ((regex.test($(this).val()))) {
                                                    $(this).removeClass("is-invalid");
                                                    $(this).parent().find('.text-danger').remove();
                                                    $(this).addClass("is-valid");
                                                } else {
                                                    $(this).addClass("is-invalid");
                                                    $(this).parent().find('.text-danger').remove();
                                                    $('<small class="text-danger">' + $(this).attr("title") + '</small>').insertAfter(this);
                                                }
                                            } else {
                                                $(this).removeClass("is-invalid");
                                                $(this).parent().find('.text-danger').remove();
                                                $(this).addClass("is-valid");
                                            }
                                        });
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        var cache_data;
                                        var vcode = false;

                                        function sendVcode() {
                                            var canPass = true;
                                            if (vcode) {
                                                $(".text-danger").remove();
                                                var pass1 = $("#password1").val();
                                                var pass2 = $("#password2").val();
                                                var code = $('#vcodereceiver').val();
                                                if (pass1 === '') {
                                                    $("#password1").addClass("is-invalid");
                                                    $("#password1").parent().find('.text-danger').remove();
                                                    $('<small class="text-danger">این فیلد اجباری است.</small>').insertAfter("#password1");
                                                } else {
                                                    passwordRegex = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
                                                    if (!(passwordRegex.test(pass1))) {
                                                        $("#password1").addClass("is-invalid");
                                                        $("#password1").parent().find('.text-danger').remove();
                                                        $('<small class="text-danger">رمزعبور حداقل از ۸ کاراکتر  و شامل حروف کوچک ، بزرگ و عدد باشد.</small>').insertAfter("#password1");
                                                        canPass = false;
                                                    }
                                                }
                                                if (code === '') {
                                                    $("#vcodereceiver").addClass("is-invalid");
                                                    $("#vcodereceiver").parent().find('.text-danger').remove();
                                                    $('<small class="text-danger">این فیلد اجباری است.</small>').insertAfter("#vcodereceiver");
                                                    canPass = false;
                                                }
                                                if (canPass) {
                                                    if (pass1 === pass2) {
                                                        $.ajax({
                                                            url: "/password-reset",
                                                            type: 'POST',
                                                            data: {code: code, password: pass1},
                                                            beforeSend: function (xhr) {
                                                                $("#sendvcode").prop("disabled", true);
                                                            },
                                                            success: function (data, textStatus, jqXHR) {
                                                                if (data.result) {
                                                                    window.location = "/dashboard";
                                                                    vcode = true;
                                                                } else {
                                                                    $("#vcodereceiver").addClass("is-invalid");
                                                                    $("#vcodereceiver").parent().find('.text-danger').remove();
                                                                    $('<small class="text-danger">کد وارد شده نامعتبر است.</small>').insertAfter("#vcodereceiver");
                                                                }
                                                            },
                                                            complete: function (jqXHR, textStatus) {
                                                                $("#sendvcode").prop("disabled", false);
                                                            }
                                                        });
                                                    } else {
                                                        $("#password2").addClass("is-invalid");
                                                        $("#password2").parent().find('.text-danger').remove();
                                                        $('<small class="text-danger">رمزعبور و تاییدیه آن برابر نیست</small>').insertAfter("#password2");
                                                    }
                                                }
                                            } else {
                                                var vcoder = $('#vcodereceiver').val();
                                                intRegex = /^(\+98|0)?9\d{9}$/;
                                                var type = "phone";
                                                if (!(intRegex.test(vcoder) && vcoder !== '')) {
                                                    $("#vcodereceiver").addClass("is-invalid");
                                                    $("#vcodereceiver").parent().find('.text-danger').remove();
                                                    $('<small class="text-danger">.شماره موبایل وارد شده نامعتبر است</small>').insertAfter("#vcodereceiver");
                                                    return;
                                                }
                                                $(".text-danger").remove();
                                                cache_data = vcoder;
                                                $.ajax({
                                                    url: "/sendvcode",
                                                    type: 'POST',
                                                    data: {_token: $('meta[name="csrf-token"]').attr('content'), type: type, receiver: vcoder},
                                                    beforeSend: function (xhr) {
                                                        $("#sendvcode").prop("disabled", true);
                                                    },
                                                    success: function (data, textStatus, jqXHR) {
                                                        if (data.result.IsSuccessful) {
                                                            $("#vcodereceiver").attr("placeholder", "کد تایید را وارد کنید");
                                                            $("#vcodereceiver").removeClass("is-invalid");
                                                            $("#vcodereceiver").removeClass("is-valid");
                                                            $("#vcodereceiver").removeAttr("pattern");
                                                            $(".text-danger").remove();
                                                            $("#vcodereceiver").val("");


                                                            $("#passs").show();
                                                            $("#sendvcode").text("تغییر رمزعبور")

                                                            vcode = true;
                                                        } else {
                                                            $("#vcodereceiver").addClass("is-invalid");
                                                            $("#vcodereceiver").parent().find('.text-danger').remove();
                                                            $('<small class="text-danger">کاربری با این شماره موبایل وجود ندارد.</small>').insertAfter("#vcodereceiver");
                                                        }
                                                    },
                                                    complete: function (jqXHR, textStatus) {
                                                        $("#sendvcode").prop("disabled", false);
                                                    }
                                                });

                                            }
                                        }


                                        $(function () {
                                            $('#login-form').validate({
                                                rules: {
                                                    email: {
                                                        required: true
                                                    },
                                                    password: {
                                                        required: true
                                                    }
                                                },
                                                errorClass: 'invalid-feedback',
                                                validClass: 'valid-feedback',
                                                errorPlacement: function (error, element) {
                                                    if (element.hasClass('form-control')) {
                                                        error.insertAfter(element.closest('.form-control'));
                                                    } else {
                                                        error.insertAfter(element);
                                                    }
                                                },
                                                highlight: function (e) {
                                                    $(e).addClass("is-invalid").removeClass('is-valid');
                                                },
                                                unhighlight: function (e) {
                                                    $(e).removeClass("is-invalid").addClass('is-valid');
                                                },
                                            });
                                        });
        </script>
    </body>

</html>