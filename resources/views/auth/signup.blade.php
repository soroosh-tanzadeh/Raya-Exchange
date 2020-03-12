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
        <link href="/assets/vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet" /><!-- THEME STYLES-->

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
            <div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="box-title"><i class="ft-user"></i> اطلاعات کاربری </h5>
                        <form class="pill-steps expand-md" id="form-wizard-responsive" method="POST" action="/dosignup" enctype="multipart/form-data">
                            <h6>مشخصات فردی</h6>
                            <fieldset>
                                @csrf
                                <div class="input-group-icon input-group-icon-left mb-4">
                                    <label class="active">نام و نام خانوادگی</label>
                                    <div class="input-group-icon input-group-icon-left mb-4">
                                        <span class="input-icon input-icon-left"><i class="ft-user"></i></span><input class="form-control required" type="text" name="name" placeholder="نام و نام خانوادگی">
                                    </div>  
                                </div>
                                <div class="input-group-icon input-group-icon-left mb-4">
                                    <label class="active">آدرس محل سکونت</label>
                                    <div class="input-group-icon input-group-icon-left mb-4"><span class="input-icon input-icon-left"><i class="ft-home"></i></span><input class="form-control required" type="text" name="address" placeholder="آدرس محل سکونت">
                                    </div>
                                </div>
                                <div>
                                    <div class="ir-select form-row">
                                        <div class="form-group col-md-6">
                                            <div class="input-group-icon input-group-icon-left mb-4">
                                                <label>استان محل سکونت:</label>
                                                <select class="ir-province form-control" required name="province"></select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputState">شهر</label>
                                            <select class="ir-city form-control" required name="city">
                                                <option value="">یک استان را انتخاب کنید</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputZip">کد پستی</label><input class="form-control" id="inputZip" type="text" name="postalcode" pattern="\b(?!(\d)\1{3})[13-9]{4}[1346-9][013-9]{5}\b" title="کد پستی" required>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <h6>تصاویر سلفی و کارت </h6>
                            <fieldset>
                                <div class="row m-0">
                                    <div class="col-md-6 my-2">
                                        <label>کشور</label>
                                        <select class="form-control" id="country">
                                            <option>ایران</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <div class="input-group-icon input-group-icon-left mb-4">
                                            <label class="active">شماره ملی</label>
                                            <div class="input-group-icon input-group-icon-left mb-4">
                                                <span class="input-icon input-icon-left"><i class="ft-user"></i></span><input class="form-control required" required type="digit" name="nationalcode" placeholder="شماره کارت ملی">
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-6 pt-2 px-1  d-flex justify-content-center align-items-center">
                                            <input type="file" class="fileselect" name="fileBack" data-binded="#backdropzone" required id="file-back" style="position: absolute;opacity: 0; z-index: -10;" />
                                            <div class="dropzone openfile w-100" id="backdropzone" data-target="#file-back">
                                                <div class="dz-message"><i class="ti-import text-primary font-40"></i>
                                                    <div class="mt-3 font-20">برای انتخاب فایل کلیک کنید</div>
                                                    <div class="text-muted">تصویر جلو کارت ملی</div>
                                                </div>
                                                <div class="filenames">
                                                    <div class="images"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pt-2 px-1  d-flex justify-content-center align-items-center">
                                            <input type="file" class="fileselect" name="fileFront" data-binded="#frontdropzone" required id="file-front" style="position: absolute;opacity: 0; z-index: -10;" " />
                                            <div class="dropzone openfile w-100" id="frontdropzone" data-target="#file-front">
                                                <div class="dz-message"><i class="ti-import text-primary font-40"></i>
                                                    <div class="mt-3 font-20">برای انتخاب فایل کلیک کنید</div>
                                                    <div class="text-muted">تصویر پشت کارت ملی</div>
                                                </div>
                                                <div class="filenames">
                                                    <div class="images"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 pt-2 px-1  d-flex justify-content-center align-items-center">
                                            <input type="file" class="fileselect" name="selfiImage" data-binded="#selfidropzone" required id="file-selfi" style="position: absolute;opacity: 0; z-index: -10;"  />
                                            <div class="dropzone openfile w-100" id="selfidropzone" data-target="#file-selfi">
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
                            <h6>رمز عبور</h6>
                            <fieldset>
                                <div class="row m-0">
                                    <div class="col-md-6 my-2">
                                        <div class="input-group-icon input-group-icon-left mb-4">
                                            <label class="active">رمز عبور</label>
                                            <div class="input-group-icon input-group-icon-left mb-4">
                                                <span class="input-icon input-icon-left"><i class="ft-user"></i></span><input maxLength="10" class="form-control required" id="password1" type="password" name="password" placeholder="رمز عبور را وارد کنید">
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <div class="input-group-icon input-group-icon-left mb-4">
                                            <label class="active">تکرار رمز عبور</label>
                                            <div class="input-group-icon input-group-icon-left mb-4">
                                                <span class="input-icon input-icon-left"><i class="ft-user"></i></span><input maxLength="10" class="form-control required" id="password2" type="password" name="password" placeholder="رمز عبور را وارد کیند">
                                            </div>  
                                        </div>
                                    </div>
                                </div>
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
        <script src="/assets/vendors/jquery-steps/build/jquery.steps.min.js"></script><!-- CORE SCRIPTS-->
        <script src="/assets/js/app.js"></script><!-- PAGE LEVEL SCRIPTS-->
        <script src="/assets/js/signup.js" type="text/javascript"></script>
        <script src="/assets/js/irancities.js"></script>

    </body>
</html>