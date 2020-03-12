<!DOCTYPE html>
<!--
Copyright (C) 2019 Webflax

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
<?php

use Morilog\Jalali\Jalalian;
?>
<html lang="en">
    <head>
        @include("includes.head")
        <title>Raya-EX | تغییر رمزعبور</title><!-- GLOBAL VENDORS-->

    </head>
    <body>
        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">کابران</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">تغییر رمز عبور</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>رمزعبور فعلی</label>
                                        <input type="password" class="form-control" id="current" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>رمزعبور جدید</label>
                                        <input type="password" class="form-control" id="pass1"/>
                                    </div>
                                    <div class="col-md-4">
                                        <label>تکرار رمزعبور جدید</label>
                                        <input type="password" class="form-control" id="pass2"/>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer justify-content-end d-flex">
                                <input type="submit" class="changePass btn btn-success" value="تغییر رمزعبور" />
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Page content-->
        <!-- END: Quick sidebar-->
        @include("includes.footer")
        <script src="/assets/js/profile.js"></script>
    </body>
</html>