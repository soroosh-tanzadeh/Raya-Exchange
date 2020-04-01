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
use App\Activity;

$activities = Activity::getActivities();
?>
<html lang="en">
    <head>
        @include("includes.head")
        <title>Raya-EX | داشبورد</title><!-- GLOBAL VENDORS-->
    </head>
    <body>
        @include("includes.adminheader")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">داشبورد</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">داشبورد</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-4 pb-3"><i class="ti-user text-muted font-40"></i></div>
                                <h5 class="mb-3">کاربران</h5>
                                <p>{{ count($users) }}</p>
                                <div><a class="d-inline-flex align-items-center text-danger" href="/admin/users"><span class="mr-2">مشاهده بیشتر</span><i class="fas fa-angle-right font-16"></i></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-4 pb-3"><i class="ti-shopping-cart text-muted font-40"></i></div>
                                <h5 class="mb-3">پشنهادات فروش</h5>
                                <p>{{ count($selloffersall) }}</p>
                                <div><a class="d-inline-flex align-items-center text-danger" href="/admin/offers"><span class="mr-2">مشاهده بیشتر</span><i class="fas fa-angle-right font-16"></i></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-4 pb-3"><i class="ti-download text-muted font-40"></i></div>
                                <h5 class="mb-3">پیشنهادات خرید</h5>
                                <p>{{ count($buyoffersall) }}</p>
                                <div><a class="d-inline-flex align-items-center text-danger" href="/admin/offers?buyers"><span class="mr-2">مشاهده بیشتر</span><i class="fas fa-angle-right font-16"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-4">
                                    <div>
                                        <h5 class="box-title mb-2"><i class="ft-download"></i> آخرین خریداران </h5>
                                    </div>
                                </div>
                                <div class="table-responsive font-11">
                                    <div class="table-responsive font-11">
                                        <div class="table-responsive font-11">
                                            <table class="table datatable table-hover compact-table">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>نام کاربری</th>
                                                        <th>ارز</th>
                                                        <th>موجودی</th>
                                                        <th>حداقل خرید</th>
                                                        <th>واحد (تومان)</th>
                                                        <th>تاریخ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($buyoffers as $buyoffer)
                                                    <tr>
                                                        <td>
                                                            <b>{{ $buyoffer->name }}</b>
                                                        </td>
                                                        <td>{{ $buyoffer->coin }}</td>
                                                        <td>{{ $buyoffer->amount }}</td>
                                                        <td>{{ $buyoffer->min_buy }}</td>
                                                        <td><?php
                                                            $priceInToman = $buyoffer->price_pre;
                                                            $price_in_toman = "";
                                                            if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                                                                $price = $priceInToman / 1000;
                                                                $price_in_toman = $price . " هزار تومان";
                                                            } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                                                                $price = $priceInToman / 1000000;
                                                                $price_in_toman = $price . " میلیون تومان";
                                                            } elseif ($priceInToman >= 1000000000) {
                                                                $price = $priceInToman / 1000000000;
                                                                $price_in_toman = $price . " میلیارد تومان";
                                                            } else {
                                                                $price = $priceInToman;
                                                                $price_in_toman = $price . " تومان";
                                                            }
                                                            echo $price_in_toman;
                                                            ?></td>
                                                        <td>{{ Jalalian::forge($buyoffer->created_at)->ago() }}</td>
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-4">
                                    <div>
                                        <h5 class="box-title mb-2"><i class="ft-download"></i> آخرین فروشندگان </h5>
                                    </div>
                                </div>
                                <div class="table-responsive font-11">
                                    <table class="table table-hover datatable compact-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>نام کاربری</th>
                                                <th>ارز</th>
                                                <th>موجودی</th>
                                                <th>حداقل فروش</th>
                                                <th>واحد (تومان)</th>
                                                <th>تاریخ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($selloffers as $offer)
                                            <tr>
                                                <td>
                                                    <b>{{ $offer->name }}</b>
                                                </td>
                                                <td>{{ $offer->coin }}</td>
                                                <td>{{ $offer->amount }}</td>
                                                <td>{{ $offer->min_buy }}</td>
                                                <td><?php
                                                    $priceInToman = $offer->price_pre;
                                                    $price_in_toman = "";
                                                    if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                                                        $price = $priceInToman / 1000;
                                                        $price_in_toman = $price . " هزار تومان";
                                                    } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                                                        $price = $priceInToman / 1000000;
                                                        $price_in_toman = $price . " میلیون تومان";
                                                    } elseif ($priceInToman >= 1000000000) {
                                                        $price = $priceInToman / 1000000000;
                                                        $price_in_toman = $price . " میلیارد تومان";
                                                    } else {
                                                        $price = $priceInToman;
                                                        $price_in_toman = $price . " تومان";
                                                    }
                                                    echo $price_in_toman;
                                                    ?></td>
                                                <td>{{ Jalalian::forge($offer->created_at)->ago() }}</td>
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
            <!-- END: Page content-->
        </div>
        <!-- BEGIN: Footer-->
        <footer class="page-footer flexbox">
            <div class="text-muted"><strong><a href="webflax.ir">وب فلکس</a></strong>   تمامی حقوق محفوظ است. </div><div class="text-muted"><a href="#" class="text-muted">شرایط و قوانین</a> | <a href="#" class="text-muted">حریم خصوصی</a></div>
        </footer><!-- END: Footer-->
    </div><!-- END: Content-->
</div>
</div>
<!-- BEGIN: Quick sidebar-->
<div class="quick-sidebar" id="quick-sidebar"><button class="close quick-sidebar-close js-close-backdrop"><span aria-hidden="true">×</span></button>
    <div class="px-4 quick-sidebar-header">
        <ul class="nav nav-pills nav-pills-solid nav-justified w-100 mr-4">
            <li class="nav-item mr-2"><a class="nav-link active" data-toggle="pill" href="#sidenav-tab-settings">تنظیمات</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane active h-100 p-4" id="sidenav-tab-settings">
            <div class="position-relative custom-scroll h-100">
                <h5 class="mb-4">تنظیمات اعلان</h5>
                <div class="flexbox py-3">فعال سازی اعلانات<label class="ui-switch switch-solid"><input type="checkbox" checked=""><span></span></label></div>
                <div class="flexbox py-3">اعلان پیامکی<label class="ui-switch switch-solid"><input type="checkbox"><span></span></label></div>
                <h5 class="mb-4 mt-5">تنظیمات سفارشات</h5>
                <div class="flexbox py-3">اعلان تکمیل فروش<label class="ui-switch switch-solid"><input type="checkbox" checked=""><span></span></label></div>
                <div class="flexbox py-3">اعلان پیشنهاد جدید<label class="ui-switch switch-solid"><input type="checkbox"><span></span></label></div>
            </div>
        </div>
    </div>
</div>
<!-- END: Quick sidebar-->
@include("includes.footer")

</body>
</html>