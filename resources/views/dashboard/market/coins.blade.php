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
        <title>Raya-EX | قیمت ارز دیجیتال</title>

    </head>
    <body>
        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading"> 
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">رمز‌ارزها</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="la la-home font-20"></i></a></li>
                        <li class="breadcrumb-item">برگه ها</li>
                        <li class="breadcrumb-item">قیمت لحظه‌ای</li>
                    </ol>
                </div>
            </div><!-- BEGIN: Page content-->
            <div>
                <div class="card">
                    <div class="card-body px-5">
                        <div class="card-fullwidth-block">
                            <div class="table-responsive">
                                <table class="table table-hover table-inbox w-100" id="market-table">
                                    <thead class="rowlinkx" data-link="row">
                                        <tr>
                                            <th>رتبه</th>
                                            <th>#</th>
                                            <th>نام ارز</th>
                                            <th>قیمت به دلار</th>
                                            <th>قیمت به تومان</th>
                                            <th>حجم بازار</th>
                                        </tr>
                                    </thead>
                                    <tbody class="rowlinkx" data-link="row">

                                    </tbody>
                                </table>                          
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- END: Page content-->
        </div><!-- BEGIN: Footer-->

        @include("includes.footer") 
    </body>
</html>