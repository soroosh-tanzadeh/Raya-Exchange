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

use App\Wallet;
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
        <title>RayaEx | کسب درآمد</title>
    </head>
    <body data-cache="null">
        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">کسب درآمد</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">زیرمجموعه‌ها</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-3 py-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center">
                                    کاربران ثبت‌نام کرده
                                </div>
                                <div class="d-flex justify-content-center align-items-center my-5">
                                    <i class="fa fa-bullhorn text-primary fa-5x"></i>
                                </div>
                                <div class="d-flex justify-content-center align-items-center" style="font-size: 1.5rem;">
                                    <h2>{{ $users }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 py-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center">
                                    کاربرانی که خرید کرده‌اند
                                </div>
                                <div class="d-flex justify-content-center align-items-center my-5">
                                    <i class="fas fa-users text-primary fa-5x"></i>
                                </div>
                                <div class="d-flex justify-content-center align-items-center" style="font-size: 1.5rem;">
                                    <h2>{{ $users }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 py-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center">
                                    درآمد تومان
                                </div>
                                <div class="d-flex justify-content-center align-items-center my-5">
                                    <i class="fas fa-money-bill text-primary fa-5x"></i>
                                </div>
                                <div class="d-flex justify-content-center align-items-center" style="font-size: 1.5rem;">
                                    <h2>{{ $wallet->cashable }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 py-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center">
                                    درآمد به بیت‌کوین
                                </div>
                                <div class="d-flex justify-content-center align-items-center my-5">
                                    <i class="fab fa-bitcoin text-warning fa-4x"></i>
                                </div>
                                <div class="d-flex justify-content-center align-items-center" style="font-size: 1.5rem;">
                                    <h2>{{ number_format(($wallet->cashable / Wallet::getCoin("bitcoin")->price_in_toman_int),8) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <h3 class="text-center">  تیم خود را گسترش دهید</h3>
                            </div>
                            <div class="card-body">
                                <h4 class="text-center">کد معرفی شما</h4>
                                <div class="container">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <input type="submit"  class="btn btn-success" value="کپی" style="border-radius: 0 5px 5px 0;"/>
                                        </div>
                                        <input type="text" class="form-control" name="" value="{{ url("/?user_referral_id=".$user->id) }}" readonly="readonly" style="border-radius: 5px 0 0 5px;" />
                                    </div>
                                </div>
                                <hr class="mb-4">
                                <h4>خلاصه تراکنش‌های مجموعه شما</h4>
                                <div class="table-responsive">
                                    @if(count($transactions) <= 0)
                                    <h4 class="text-center">هیچ تراکنشی وجود ندارد</h4>
                                    @else
                                    <table class="table table-hover table-inbox w-100">
                                        <thead class="rowlinkx" data-link="row">
                                            <tr>
                                                <th>کابر</th>
                                                <th>مقدار تراکنش</th>
                                            </tr>
                                        </thead>
                                        <tbody class="rowlinkx" data-link="row">
                                            @foreach($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->from_user }}</td>
                                                <td>{{ $transaction->amount }} تومان</td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                    @endif
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <h3 class="text-center">درآمد</h3>
                            </div>
                            <div class="card-body">
                                <div>
                                    <input type="submit" class="btn btn-warning text-white convert2btc" data-credit="{{ $wallet->cashable }}" value="تبدیل درآمد به بیت‌کوین" />
                                    <input type="submit" class="btn btn-primary text-white deposit" value="واریز به کیف‌پول" />
                                </div>
                                <hr class="mb-4">
                                <h4>درخواست‌های تبدیل درآمد به بیت‌کوین</h4>
                                <div class="table-responsive">
                                    @if(count($checkouts) <= 0)
                                    <h4 class="text-center">هیچ درخواستی وجود ندارد</h4>
                                    @else
                                    <table class="table table-hover table-inbox w-100">
                                        <thead class="rowlinkx" data-link="row">
                                            <tr>
                                                <th>شماره</th>
                                                <th>مقدار</th>
                                                <th>وضعیت</th
                                            </tr>
                                        </thead>
                                        <tbody class="rowlinkx" data-link="row">
                                            @foreach($checkouts as $checkout)
                                            <tr>
                                                <td>{{ $checkout->id }}</td>
                                                <td>{{ $checkout->amount }} تومان</td>
                                                <td>
                                                    @if($checkout->status)
                                                    <span class="text-success">انجام شده</span>
                                                    @else
                                                    <span class="text-warning">انجام نشده</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include("includes.footer") 
        <script src="/assets/js/affilate.js"></script>
    </body>
</html>