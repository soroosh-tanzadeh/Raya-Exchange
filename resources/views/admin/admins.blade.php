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
        <title>RayaEX | مدیران</title>
    </head>
    <body data-cache="null">


        <!-- Modal -->
        <div id="editUser" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="ft-edit"></i> ویرایش کاربر</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form data-action="/admin/editadmin" onsubmit="submitAjaxForm(this)" novalidate action="javascript:;" data-btn="#edituser" method="POST">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" id="user_edit_id" name="user_id" value="" />
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <label class="w-100">
                                            نام کاربر
                                        </label>
                                        <input type="text" required name="name" id="user_name" value="" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <label class="w-100">
                                            رمزعبور
                                        </label>
                                        <input type="password" required name="password" value="" id="editpass1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title=" رمزعبور حداقل از ۸ کاراکتر و شامل حروف کوچک ، بزرگ و عدد باشد. "  class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <label class="w-100">
                                            تکرار رمزعبور
                                        </label>
                                        <input type="password" required value="" equal="#editpass1" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">لغو</button>
                            <button type="submit" class="btn btn-primary btn-rounded" id="edituser">ثبت اطلاعات</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">مدیران و کارشناسان</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../index.html"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">مدیران و کارشناسان</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <form action="javascript:;" data-action="/admin/admins/new" novalidate data-btn="#submitAdmin" onsubmit="submitAjaxForm(this)" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-header justify-content-start">
                                    <h4 class="text-right">ایجاد کاربر جدید</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>
                                                نام کاربر
                                            </label>
                                            <input type="text" required name="name" value="" class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>
                                                شماره تماس
                                            </label>
                                            <input type="tel" required name="phone" value="" class="form-control" />
                                        </div>
                                        <div class="col-md-4">
                                            <label>
                                                سطح دسترسی
                                            </label>
                                            <select name="permissions" required class="form-control">
                                                <option value="1">مدیر کل</option>
                                                <option value="2">کارشناس امور مالی</option>
                                                <option value="3">کارشناس احراز هویت</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <label>
                                                رمزعبور
                                            </label>
                                            <input type="password" required name="password" value="" id="pass1" class="form-control" />
                                        </div>
                                        <div class="col-md-6">
                                            <label>
                                                تکرار رمزعبور
                                            </label>
                                            <input type="password" required value="" equal="#pass1" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <input type="submit" value="ایجاد کاربر" id="submitAdmin" class="btn btn-rounded btn-primary" />
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
                                    <table class="table datatable table-hover compact-table" id="users">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>شماره</th>
                                                <th>نام و نام‌خانوادگی</th>
                                                <th>شماره موبایل</th>
                                                <th>سطح دسترسی</th>
                                                <th>تاریخ ایجاد</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($admins as $admin)
                                            <tr>
                                                <td>{{ $admin->id }}</td>  
                                                <td>{{ $admin->name }}</td>  
                                                <td>{{ $admin->phone_number }}</td>  
                                                <td>{{ $admin->permissions_name }}</td>
                                                <td>{{ Jalalian::forge($admin->created_at)->ago() }}</td>  
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-outline-danger btn-sm removeAdmin" data-toggle="tooltip" title="حذف کاربر" data-user="{{ $admin->id }}" ><i class="ft-trash"></i></button>
                                                        <button class="btn btn-outline-warning btn-sm editAdmin" data-toggle="tooltip" title="ویرایش اطلاعات" data-user="{{ $admin->id }}" data-name="{{ $user->name }}" ><i class="ft-edit"></i></button>
                                                    </div>
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