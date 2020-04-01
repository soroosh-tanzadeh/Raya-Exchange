<!DOCTYPE html>
<!--
Copyright (C) 2020 Webflax

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
        <style>
            .btn-outline-light:hover{
                background: transparent !important;
                color: #FFF !important;
            }
        </style>
        <title>RayaEX |‌ احراز هویت</title>
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
                        <li class="breadcrumb-item"><a href="../index.html"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">داشبورد</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="alert alert-success has-icon" style="direction: rtl;" role="alert">
                    <i class="la la-check alert-icon"></i>
                    <strong>اطلاعات شما با موفقیت ثبت شد</strong>
                    <br> 
                    نتیجه بررسی از طریق تیکت به شما اعلام می‌شود.
                    <div class="float-left px-2" style="margin-top: -20px;">
                        <a href="/dashboard" class="btn border-white text-white btn-outline-light btn-rounded">بازگشت به داشبورد</a>
                    </div>
                </div>
            </div>
        </div>
        @include("includes.footer") 
        <script src="/assets/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="/assets/vendors/jquery-steps/build/jquery.steps.min.js"></script><!-- CORE SCRIPTS-->
        <script src="/assets/js/app.js"></script><!-- PAGE LEVEL SCRIPTS-->
        <script src="/assets/js/signup.js" type="text/javascript"></script>

    </body>
</html>