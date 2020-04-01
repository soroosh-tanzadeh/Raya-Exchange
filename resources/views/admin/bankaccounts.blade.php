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
        <title>Raya-EX | حساب‌های بانکی </title><!-- GLOBAL VENDORS-->

    </head>
    <body>
        @include("includes.adminheader")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">حساب‌های بانکی</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">حساب‌های بانکی</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive font-11">
                                    <table class="table table-hover w-100 compact-table" id="accounts">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>شماره</th>
                                                <th>نام صاحب حساب</th>
                                                <th>شماره شبا</th>
                                                <th>شماره کارت</th>
                                                <th>شماره حساب</th>
                                                <th>تاریخ ثبت</th>
                                                <th>وضعیت تایید</th>
                                                <th>عملیات</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Page content-->
        <!-- END: Quick sidebar-->
        @include("includes.footer")


        <script>
            $(document).ready(function () {
                $("#accounts").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '/admin/getbankaccounts',
                    columns: [
                        {data: 'id'},
                        {data: "owner"},
                        {data: 'IBAN'},
                        {data: 'card_number'},
                        {data: 'account_number'},
                        {data: 'created_at'},
                        {data: 'is_active'},
                        {data: 'actions'}
                    ],
                    "language": {
                        "url": "/assets/persian.json"
                    }, drawCallback: function (settings) {
                        $('[data-toggle="tooltip"]').tooltip()
                    }
                });
            });
        </script>

    </body>
</html>