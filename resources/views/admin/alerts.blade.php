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

<?php

use Morilog\Jalali\Jalalian;
?>
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
        <title>RayaEX | اعلان‌ها</title>
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
                        <li class="breadcrumb-item">مدیران</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <form action="javascript:;" id="newalertform" data-action="/admin/alerts/new" data-btn="#submitAdmin" onsubmit="submitAjaxForm(this)" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-header justify-content-start">
                                    <h4 class="text-right">اعلان جدید</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>
                                                متن
                                            </label>
                                            <input type="text" required name="text" value="" class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>
                                                آیکون
                                            </label>
                                            <input type="file" required name="icon" value="" class="form-control-file" />
                                        </div>
                                        <div class="col-md-2">
                                            <label>
                                                نوع
                                            </label>
                                            <select name="type" class="form-control">
                                                <option value="success">موفقیت آمیز (سبز)</option>
                                                <option value="danger">خطا یا وجود مشکل (قرمز)</option>
                                                <option value="warning">اخطار (نارنجی)</option>
                                                <option value="info">اطلاعات (آبی)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <input type="submit" value="ارسال اعلان" id="submitAdmin" class="btn btn-primary" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive font-11">
                                    <table class="table table-hover compact-table" id="users">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>شماره</th>
                                                <th>متن</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($alerts as $alert)
                                            <tr class="bg-{{ $alert->type }}">
                                                <td>{{ $alert->id }}</td>  
                                                <td>{{ $alert->text }}</td>  
                                                <td>
                                                    @if($alert->active)
                                                    <input type="button" value="غیرفعال" class="btn btn-danger deactivealert" data-id="{{ $alert->id }}" />
                                                    @else 
                                                    غیرفعال
                                                    @endif
                                                </td>  
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
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