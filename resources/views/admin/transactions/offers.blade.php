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
        <title>Raya-EX | پشنهاد‌های خرید و فروش</title>
    </head>
    <body>
        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading"> 
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep"> خرید و فروش</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="la la-home font-20"></i></a></li>
                        <li class="breadcrumb-item"> خرید و فروش</li>
                    </ol>
                </div>
            </div><!-- BEGIN: Page content-->
            <div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header p-0">
                                <ul class="nav line-tabs nav-justified line-tabs-2x line-tabs-solid w-100">
                                    <li class="nav-item"><a data-toggle="tab" href="#menu1" class="nav-link w-100 justify-content-center  @if(!isset($buyers)) active show @endif" style="border-top-right-radius: 0.6rem;">فروشندگان</a></li>
                                    <li class="nav-item"><a data-toggle="tab" href="#menu2" class="nav-link w-100 justify-content-center @if(isset($buyers)) active show @endif" style="border-top-left-radius: 0.6rem;">خریداران</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div id="menu1" class="tab-pane fade  @if(!isset($buyers)) active show @endif">
                                        <div class="d-flex justify-content-between flex-column">
                                            <div>
                                                <ul class="nav nav-pills w-100" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link loadcoinoffers active show" data-offer="sell" data-coin="bitcoin"data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false">Bitcoin <i class="cc mx-2 BTC-alt font-20 text-warning mb-2"></i></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link loadcoinoffers" data-offer="sell" data-coin="etheruem" data-toggle="tab" role="tab"  aria-selected="false">Ethereum <i class="cc mx-2 ETH-alt font-20 text-primary mb-2"></i></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link loadcoinoffers" data-offer="sell" data-coin="teather" data-toggle="tab" role="tab"  aria-selected="false">Tether <i class="cc mx-2 USDT-alt font-20 text-success mb-2"></i></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link loadcoinoffers d-flex justify-contenent-center align-items-center h-100" data-offer="sell" data-coin="more" data-toggle="tab" role="tab" aria-selected="false"><i class="mx-2 ti-more font-20 text-muted"></i>سایر </a>                                                    </li>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="table-responsive font-11 my-2">
                                            <div class="table-responsive font-11">
                                                <table class="table table-hover compact-table w-100" id="buyofferstable">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>نام کاربری</th>
                                                            <th>ارز</th>
                                                            <th>موجودی</th>
                                                            <th>حداقل فروش</th>
                                                            <th>قیمت واحد (تومان)</th>
                                                            <th>تاریخ</th>
                                                            <th>عملیات</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="menu2" class="tab-pane @if(isset($buyers)) active show @endif">
                                        <div class="d-flex justify-content-between flex-column">
                                            <div>
                                                <ul class="nav nav-pills w-100" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link loadcoinoffers active show" data-offer="buy" data-coin="bitcoin"data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false">Bitcoin <i class="cc mx-2 BTC-alt font-20 text-warning mb-2"></i></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link loadcoinoffers" data-offer="buy" data-coin="etheruem" data-toggle="tab" role="tab"  aria-selected="false">Ethereum <i class="cc mx-2 ETH-alt font-20 text-primary mb-2"></i></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link loadcoinoffers" data-offer="buy" data-coin="teather" data-toggle="tab" role="tab"  aria-selected="false">Tether <i class="cc mx-2 USDT-alt font-20 text-success mb-2"></i></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link loadcoinoffers d-flex justify-contenent-center align-items-center h-100" data-offer="buy" data-coin="more" data-toggle="tab" role="tab" aria-selected="false"><i class="mx-2 ti-more font-20 text-muted"></i>سایر </a>                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="table-responsive font-11 my-2">
                                            <div class="table-responsive font-11">
                                                <div class="table-responsive font-11">
                                                    <table class="table table-hover compact-table w-100" id="sellofferstable">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>نام کاربری</th>
                                                                <th>ارز</th>
                                                                <th>موجودی</th>
                                                                <th>حداقل خرید</th>
                                                                <th>قیمت واحد (تومان)</th>
                                                                <th>تاریخ</th>
                                                                <th>عملیات</th>
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
                </div>
            </div><!-- BEGIN: Footer-->
        </div>
        @include("includes.footer") 
        <script src="/assets/js/offerslistAdmin.js"></script>

    </body>
</html>