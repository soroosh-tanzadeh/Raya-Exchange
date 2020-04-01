<!DOCTYPE html>
<!--
Copyright (C) 2019 Soroosh Tanzadeh

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->

<html lang="en">
    <head>
        @include("includes.head")
        <link href="/assets/vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet" /><!-- THEME STYLES-->
        <link href="/assets/css/pages/form-wizard.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <link href="/assets/vendors/feather-icons/feather.css" rel="stylesheet" />
        <link href="/assets/vendors/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
        <link href="/assets/vendors/themify-icons/themify-icons.css" rel="stylesheet" />
        <link href="/assets/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" />
        <link href="/assets/vendors/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" /><!-- PAGE LEVEL VENDORS-->
        <!-- THEME STYLES-->
        <link href="/assets/css/app.min.css" rel="stylesheet" /><!-- PAGE LEVEL STYLES-->
        <link href="/assets/css/style.css" rel="stylesheet" /><!-- PAGE RTL STYLES-->
        <link href="/assets/css/pages/form-wizard.css" rel="stylesheet" />
        <title>Raya-EX | تکمیل اطلاعات کاربری</title>

        <style>
            .input-icon{
                max-height: 38px;
            }
            .wizard>.content>.body {
                padding: 7px;
            }
        </style>

    </head>
    <body data-cache="null">
        @include("includes.header") 
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">داشبورد</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">داشبورد</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            @if($alert)
            <div class="alert alert-warning has-icon text-white" style="direction: rtl;" role="alert"><i class="la la-warning alert-icon"></i>برای دسترسی به این بخش باید اطلاعات حساب کاربری خود را تکمیل کنید.</div>
            @endif

            <div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="box-title"><i class="ft-user"></i> اطلاعات کاربری </h5>
                    </div>
                    <div class="card-body"> 
                        <form class="pill-steps justified-steps" id="form-wizard-responsive" method="POST" action="/dosignup" enctype="multipart/form-data">
                            <h6>مشخصات فردی</h6>
                            <fieldset>
                                @csrf
                                <div class="alert alert-warning alert-bordered has-icon" role="alert">
                                    <i class="la la-warning alert-icon"></i>
                                    <strong>هشدار!</strong><br> لطفا در وارد کردن شماره تلفن ثابت دقت کنید.در راستای بررسی صحت اطلاعات درج شده همکاران ما با شما تماس می‌گیرند.
                                </div>
                                <div class="form-row">
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group-icon input-group-icon-left mb-4">
                                                    <label class="active">نام و نام خانوادگی</label>
                                                    <div class="input-group-icon input-group-icon-left mb-4">
                                                        <span class="input-icon input-icon-left">
                                                            <i class="ft-user"></i>
                                                        </span>
                                                        @if($user->name !== '')
                                                        <input class="form-control required form-control-solid" required type="text" name="name"  value="{{ $user->name }}" title="این فیلد اجباری است." placeholder="نام و نام خانوادگی">
                                                        @else
                                                        <input class="form-control required" required type="text" name="name"  value="" title="این فیلد اجباری است." placeholder="نام و نام خانوادگی">
                                                        @endif
                                                    </div>  
                                                </div>
                                            </div>
                                            <div class="col-md-6 my-2">
                                                <div class="input-group-icon input-group-icon-left mb-4">
                                                    <label class="active">شماره ملی</label>
                                                    <div class="input-group-icon input-group-icon-left mb-4">
                                                        <span class="input-icon input-icon-left"><i class="ft-credit-card"></i></span><input class="form-control required" required title="این فیلد اجباری است." type="digit" value="{{ $user->nationalcode }}"  name="nationalcode" placeholder="شماره کارت ملی">
                                                    </div>  
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group-icon input-group-icon-left mb-4">
                                                    <label class="active">تلفن ثابت</label>
                                                    <div class="input-group-icon input-group-icon-left mb-4"><span class="input-icon input-icon-left"><i class="ft-phone"></i></span><input class="form-control required" type="tel" value="{{ $user->telephone }}" title="این فیلد اجباری است." name="telephone" placeholder="تلفن">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group-icon input-group-icon-left mb-4">
                                                    <label class="active">ایمیل</label>
                                                    <div class="input-group-icon input-group-icon-left mb-4"><span class="input-icon input-icon-left"><i class="ft-mail"></i></span><input class="form-control required" type="email" value="{{ $user->email }}" name="email" placeholder="ایمیل">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="ir-select form-row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="form-group col-md-3">
                                                        <label for="inputZip">کد پستی (۱۰ رقمی)</label>
                                                        <input class="form-control" id="inputZip" type="text"  title="این فیلد اجباری است." name="postalcode" pattern="\b(?!(\d)\1{3})[13-9]{4}[1346-9][013-9]{5}\b" title="کد پستی" value="{{ $user->postalcode }}" required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>کشور</label>
                                                        <select class="form-control" id="country">
                                                            <option>ایران</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <div class="input-group-icon mb-4">
                                                            <label>استان محل سکونت</label>
                                                            <select class="ir-province form-control"  title="این فیلد اجباری است." required name="province"></select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="inputState">شهر محل سکونت:</label>
                                                        <select class="ir-city form-control" required name="city"  title="این فیلد اجباری است.">
                                                            <option value="">انتخاب شهر</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group-icon input-group-icon-left mb-4">
                                                    <label class="active">آدرس محل سکونت</label>
                                                    <div class="input-group-icon input-group-icon-left mb-4">
                                                        <span class="input-icon input-icon-left">
                                                            <i class="ft-home"></i>
                                                        </span>
                                                        <textarea class="form-control required" title="این فیلد اجباری است." type="text" name="address" placeholder="آدرس محل سکونت" style="margin-top: 0px; margin-bottom: 0px;height: 97px;max-height: 97px;resize: none">{{ $user->address }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-center">
                                        <img src="/assets/img/user-information.png" alt="" style="max-width: 60%;margin-top: 15px"/>
                                    </div>

                                </div>
                                <div>

                                </div>
                            </fieldset>
                            <h6>تصویر سلفی و کارت ملی </h6>
                            <fieldset>
                                <div class="dz-message" style="text-align: center;width: 100%;">
                                    <img src="/assets/img/identity-selfie-guide.png" alt="" style="width: 50vw;align-self: center;">
                                </div>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-4 pt-2 px-1  d-flex justify-content-center align-items-center">
                                            <input type="file" class="fileselect" name="fileBack" data-binded="#backdropzone" title="این فیلد اجباری است." required id="file-back" style="position: absolute;opacity: 0; z-index: -10;" />
                                            <div class="dropzone dz-clickable openfile w-100" id="backdropzone" data-target="#file-back">
                                                <div class="dz-message"><i class="ti-import text-primary font-40"></i>
                                                    <div class="mt-3 font-20">برای انتخاب فایل کلیک کنید</div>
                                                    <div class="text-muted">تصویر جلو کارت ملی</div>
                                                </div>
                                                <div class="filenames">
                                                    <div class="images"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 pt-2 px-1  d-flex justify-content-center align-items-center">
                                            <input type="file" class="fileselect" name="fileFront" data-binded="#frontdropzone"  title="این فیلد اجباری است." required id="file-front" style="position: absolute;opacity: 0; z-index: -10;" />
                                            <div class="dropzone dz-clickable openfile w-100" id="frontdropzone" data-target="#file-front">
                                                <div class="dz-message"><i class="ti-import text-primary font-40"></i>
                                                    <div class="mt-3 font-20">برای انتخاب فایل کلیک کنید</div>
                                                    <div class="text-muted">تصویر پشت کارت ملی</div>
                                                </div>
                                                <div class="filenames">
                                                    <div class="images"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 pt-2 px-1  d-flex justify-content-center align-items-center">
                                            <input type="file" class="fileselect" name="selfiImage" data-binded="#selfidropzone" required id="file-selfi" style="position: absolute;opacity: 0; z-index: -10;"  />
                                            <div class="dropzone dz-clickable openfile w-100" id="selfidropzone" data-target="#file-selfi">
                                                <div class="dz-message"><i class="ti-import text-primary font-40"></i>
                                                    <div class="mt-3 font-20">برای انتخاب فایل کلیک کنید</div>
                                                    <div class="text-muted">تصویر سلفی با کارت ملی</div>
                                                </div>
                                                <div class="filenames">
                                                    <div class="images"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <h6>اطلاعات حساب بانکی</h6>
                            <fieldset>
                                <div class="alert alert-warning alert-bordered has-icon" role="alert">
                                    <i class="la la-warning alert-icon"></i>
                                    <strong>هشدار!</strong><br>لطفا در ثبت اطلاعات بانکی خود دقت داشته باشید در صورت بروز هرگونه مشکل در مغایرت حساب رایا هیچ مسئولیتی ندارد.
                                </div>
                                <h4>اطلاعات حساب بانکی</h4>
                                <div class="row m-0">                                    
                                    <div class="col-md-6 mb-3">
                                        <label>
                                            شماره شبا
                                        </label>
                                        <input type="text" name="IBAN" data-mask='IR 00-0000-0000-0000-0000-0000-00' required value="" style="direction: ltr" id="iban" class="form-control w-100">
                                    </div>
                                    <div class="col-md-6">
                                        <label> 
                                            شماره کارت 
                                        </label>
                                        <input type="text" name="card_number" required value="" data-mask='0000-0000-0000-0000' style="direction: ltr" class="form-control w-100">
                                    </div>
                                    <div class="col-md-6">
                                        <label>
                                            شماره حساب
                                        </label>
                                        <input type="text" maxlength="20" name="account_number" required value="" class="form-control w-100">
                                    </div>
                                    <div class="col-md-6">
                                        <label>
                                            نام مالک حساب
                                        </label>
                                        <input type="text" name="account_owner" required value="" class="form-control w-100">
                                    </div>
                                </div>
                                <div class="dz-message my-5" style="text-align: center;width: 100%;">
                                    <img src="/assets/img/credit-selfie-guide.png" alt="" style="width: 50vw;align-self: center;">
                                </div>
                                <div class="container-fluid pt-2 px-1 d-flex justify-content-center align-items-center">
                                    <input type="file" class="fileselect" name="creditcardpic" data-binded="#creditcardpicShower" required id="creditcardpic" style="position: absolute;opacity: 0; z-index: -10;"  />
                                    <div class="dropzone openfile w-100" id="creditcardpicShower" data-target="#creditcardpic">
                                        <div class="dz-message"><i class="ti-import text-primary font-40"></i>
                                            <div class="mt-3 font-20">برای انتخاب فایل کلیک کنید</div>
                                            <div class="text-muted">تصویر کارت بانکی</div>
                                        </div>
                                        <div class="filenames">
                                            <div class="images"></div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group w-100 d-flex align-items-center"><input type="checkbox" id="verifyLaws"> <label for="verifyLaws" class="mb-0 ml-2"><a href="#lawsmodal" data-toggle="modal" data-target="#lawsmodal">شرایط و  قوانین</a> را خوانده‌ام و با آن مواقم.</label></div>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include("includes.footer") 
        <script>
            $(document).ready(function () {
                setTimeout(function () {
                    $(".openfile").click(function () {
                        var target = $(this).attr("data-target");
                        $(target).click();
                    });
                    $(".fileselect").change(function () {
                        var targetDropzone = $(this).attr("data-binded");
                        var filesdiv = $(targetDropzone).children(".filenames");
                        $(targetDropzone).children(".filenames").show();
                        input = this;
                        filesdiv.html("");
                        if (input.files) {
                            for (i = 0; i < input.files.length; i++) {
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    var element = "<img src='" + e.target.result + "' style='max-width:150px;margin:10px;'/>";
                                    filesdiv.append(element);
                                }

                                reader.readAsDataURL(input.files[i]);
                            }
                        }
                    });
                }, 2000);

            });
        </script>
        <script src="/assets/vendors/jquery-validation/dist/jquery.validate.js"></script>
        <script src="/assets/vendors/jquery-validation/dist/localization/messages_fa.js"></script>
        <script src="/assets/vendors/jquery-steps/build/jquery.steps.min.js"></script><!-- CORE SCRIPTS-->
        <script src="/assets/js/app.js"></script><!-- PAGE LEVEL SCRIPTS-->
        <script src="/assets/js/signup.js" type="text/javascript"></script>
        <script src="/assets/js/irancities.js"></script>


        <script>
            setTimeout(function () {
                $(".ir-province").val("{{ $user->province }}");
                $(".ir-province").trigger("change");
            }, 1000);
            setTimeout(function () {
                $(".ir-city").val("{{ $user->city }}");
                $(".ir-city").trigger("change");
            }, 1000);

        </script>
    </body>
</html>