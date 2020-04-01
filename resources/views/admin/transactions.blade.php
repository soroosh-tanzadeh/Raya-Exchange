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
        <title>Raya-EX | تراکنش‌ها</title><!-- GLOBAL VENDORS-->
        <style>
            .form-control-select {
                display: block;
                width: 100%;
                height: -webkit-calc(2.6rem + 2px);
                height: calc(2.6rem + 2px);
                padding: .55rem 1.1rem;
                font-size: 1rem;
                line-height: 1.5;
                color: #495057;
                background-color: #fff;
                background-clip: padding-box;
                border: 1px solid #ced4da;
                border-top-color: rgb(206, 212, 218);
                border-right-color: rgb(206, 212, 218);
                border-bottom-color: rgb(206, 212, 218);
                border-left-color: rgb(206, 212, 218);
                -webkit-border-radius: .25rem;
                border-radius: .25rem;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                -webkit-transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
                transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
                -o-transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
                transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
                transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;

            }
        </style>
    </head>
    <body>
        @include("includes.adminheader")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">ادمین</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">تراکنش‌ها</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">

                            </div>
                            <div class="card-body">
                                <div class="p-0" style="width: 186px;float: right;margin-bottom: 10px;">
                                    <select name="date" id='date' class="form-control-select">
                                        <option value="" selected disabled>بازه زمانی</option>
                                        <option value="d">امروز</option>
                                        <option value="w">هفته اخیر</option>
                                        <option value="m">ماه اخیر</option>
                                        <option value="y">امسال</option>
                                    </select>
                                </div>
                                <div class="table-responsive font-11">
                                    <table class="table w-100 table-hover compact-table" id="transactions">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>کد کاربر</th>
                                                <th>نام کاربر</th>
                                                <th>نام ارز</th>
                                                <th>مقدار</th>
                                                <th>شماره تراکنش</th>
                                                <th>تاریخ</th>
                                                <th>وضعیت</th>
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

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>

        <script>
            $(document).ready(function () {

                var datatable = $("#transactions").DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'excel', 'print'
                    ],
                    processing: true,
                    serverSide: true,
                    ajax: '/admin/gettransactions',
                    columns: [
                        {data: 'user_id'},
                        {data: 'user_name'},
                        {data: 'coin'},
                        {data: 'amount'},
                        {data: 'trans_id'},
                        {data: 'created_at'},
                        {data: 'status'},
                        {data: 'actions'}
                    ],
                    "language": {
                        "url": "/assets/persian.json"
                    }, drawCallback: function (settings) {
                        $('[data-toggle="tooltip"]').tooltip()
                    }
                });

                $("#date").change(function () {
                    datatable.ajax.url("/admin/gettransactions?date=" + $("#date").val()).load();
                });

            });
        </script>

    </body>
</html>