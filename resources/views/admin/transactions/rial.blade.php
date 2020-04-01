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
        <title>Raya-EX | تراکنش‌های ریالی </title><!-- GLOBAL VENDORS-->
    </head>
    <body>
        @include("includes.adminheader")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">تراکنش‌ها</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">تراکنش‌های ریالی </li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header p-0">
                                <ul class="nav line-tabs nav-justified line-tabs-2x line-tabs-solid w-100">
                                    <li class="nav-item"><a data-toggle="tab" href="#menu1" class="nav-link w-100 justify-content-center active show" style="border-top-right-radius: 0.6rem;">درخواست برداشت</a></li>
                                    <li class="nav-item"><a data-toggle="tab" href="#menu2" class="nav-link w-100 justify-content-center" style="border-top-left-radius: 0.6rem;">انتقال به کیف پول</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div id="menu1" class="tab-pane fade active show">
                                        <div class="table-responsive font-11">
                                            <table class="table table-hover compact-table datatable-full w-100" data-ajax="/admin/datatable/getrialdeposits" data-columns='[{"data": "id"},{"data": "IBAN"},{"data": "card_number"},{"data": "account_number"},{"data": "amount"},{"data": "user_name"},{"data": "created_at"},{"data": "is_payed"},{"data": "actions"}]'>
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>شماره</th>
                                                        <th>شماره شبا</th>
                                                        <th>شماره کارت</th>
                                                        <th>شماره حساب</th>
                                                        <th>مقدار</th>
                                                        <th>نام کاربر</th>
                                                        <th>تاریخ</th>
                                                        <th>وضعیت پرداخت</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="menu2" class="tab-pane">
                                        <div class="table-responsive font-11">
                                            <table class="table table-hover compact-table datatable-full w-100" data-ajax="/admin/datatable/getrialpayments" data-columns='[{"data": "id"},{"data": "coin"},{"data": "amount"},{"data": "user_id"},{"data": "user_name"},{"data":"trans_id"},{"data": "created_at"}]'>
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>شماره</th>
                                                        <th>ارز</th>
                                                        <th>مقدار</th>
                                                        <th>کد کاربر</th>
                                                        <th>نام کاربر</th>
                                                        <th>شماره تراکنش</th>
                                                        <th>تاریخ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Page content-->
        </div>
        <!-- END: Quick sidebar-->
        @include("includes.footer")
    </body>
</html>