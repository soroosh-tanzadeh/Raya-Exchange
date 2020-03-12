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
                                <select name="date" id='date' class="form-control">
                                    <option value="" selected disabled>بازه زمانی</option>
                                    <option value="d">امروز</option>
                                    <option value="w">هفته اخیر</option>
                                    <option value="m">ماه اخیر</option>
                                    <option value="y">امسال</option>
                                </select>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive font-11">
                                    <table class="table table-hover compact-table" id="transactions">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>شماره</th>
                                                <th>ارز</th>
                                                <th>مقدار</th>
                                                <th>کد کاربر</th>
                                                <th>نام کاربر</th>
                                                <th>شماره تماس کاربر</th>
                                                <th>تاریخ</th>
                                                <th>وضعیت</th>
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
                        'csv', 'excel', 'print'
                    ],
                    processing: true,
                    serverSide: true,
                    ajax: '/admin/gettransactions',
                    columns: [
                        {data: 'id'},
                        {data: 'coin'},
                        {data: 'amount'},
                        {data: 'user_id'},
                        {data: 'user_name'},
                        {data: 'phone_number'},
                        {data: 'created_at'},
                        {data: 'status'}
                    ],
                    "language": {
                        "url": "/assets/persian.json"
                    }
                });

                $("#date").change(function () {
                    datatable.ajax.url("/admin/gettransactions?date=" + $("#date").val()).load();
                });

            });
        </script>

    </body>
</html>