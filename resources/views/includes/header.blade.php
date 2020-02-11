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

use App\Exchange;
use App\Wallet;

$headcoins = Exchange::getCoins();
$headerWallets = Wallet::getWallets();
?>

  @if($user->is_admin)
    @include("includes.adminheader")
  @else
<div class="modal fade" id="buycoinmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">خرید کوین</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:;" id="buycoinform" method="GET">
                    <input type="hidden" id="offeridIN" name="offer_id"/>
                    <label>میزان کوین</label>
                    <input type="number" name="amount" step="0.0000001" class="form-control" value="" id="coinamount" data-price="" data-coin="bitcoin" style="width: 100%;margin-bottom: 10px;" placeholder="مقدار مورد نظر خود را وارد کنید" />
                    <div class="my-2">
                        قیمت:  <text id="coinprice" ></text>
                    </div>
                    <input class="btn btn-primary" type="submit" value="پرداخت" />
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="sellcoinmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">خرید کوین</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:;" onsubmit="submitAjaxForm(this);" id="sellcoinform" method="GET" data-target="/dashboard/mywallet">
                    <input type="hidden" id="sellofferid" name="offer_id"/>
                    <label>مقدار کوین</label>
                    <input type="number" name="amount" step="0.0000001" class="form-control" value="" data-price="" data-coin="bitcoin" style="width: 100%;margin-bottom: 10px;" placeholder="مقدار مورد نظر خود را وارد کنید" />
                    <input class="btn btn-primary" type="submit" value="فروش" />
                </form>
            </div>
        </div>
    </div>
</div>

<div class="page-wrapper">
    <div class="content-wrapper">
        <!-- BEGIN: Sidebar-->
        <div class="page-sidebar custom-scroll" id="sidebar">
            <div class="sidebar-header"><a class="sidebar-brand" href="/dashboard">Raya-EX</a><a class="sidebar-brand-mini" href="/index">RX</a><span class="sidebar-points"><span class="badge badge-success badge-point mr-2"></span><span class="badge badge-danger badge-point mr-2"></span><span class="badge badge-warning badge-point"></span></span></div>
            <ul class="sidebar-menu metismenu" id="theulsidebar">
                <li><a href="/dashboard"><i class="sidebar-item-icon ft-home"></i><span class="nav-label">داشبورد</span></a></li>
                <li><a href="/dashboard/mywallet"><i class="sidebar-item-icon ft-dollar-sign"></i><span class="nav-label">کیف پول</span></a></li>
                <li><a href="javascript:;"><i class="sidebar-item-icon ft-shopping-cart"></i><span class="nav-label">خرید و فروش ارز</span><i class="arrow la la-angle-right"></i></a>
                    <ul class="nav-2-level">
                        <!-- 2-nd level-->
                        <li><a href="/dashboard/offers"><i class="sidebar-item-icon ft-trending-up"></i><span class="nav-label">جدول خرید و فروش</span></a></li>
                        <li><a href="/dashboard/buyoffer"><i class="sidebar-item-icon ft-shopping-cart"></i><span class="nav-label">ایجاد پیشنهاد جدید</span></a></li>
                        <li><a href="/dashboard/myoffers"><i class="sidebar-item-icon ft-shopping-cart"></i><span class="nav-label">پیشنهادات من</span></a></li>

                    </ul>
                </li>
                <li><a href="javascript:;"><i class="sidebar-item-icon ft-list"></i><span class="nav-label">تراکنش‌ها</span><i class="arrow la la-angle-right"></i></a>
                    <ul class="nav-2-level">
                        <li><a href="/dashboard/rials"><i class="sidebar-item-icon ft-layers"></i><span class="nav-label">ریالی</span></a></li>
                        <li><a href="/dashboard/crypto"><i class="sidebar-item-icon ft-layers"></i><span class="nav-label">ارز دیجیتال</span></a></li>
                    </ul>
                </li>
                <li><a href="javascript:;"><i class="sidebar-item-icon ft-trending-up"></i><span class="nav-label">معاملات ارزی</span><i class="arrow la la-angle-right"></i></a>
                    <ul class="nav-2-level">
                        <!-- 2-nd level-->
                        <li><a href="/dashboard/exchange"><i class="sidebar-item-icon ft-layers"></i><span class="nav-label">تبادل ارز</span></a></li>
                        <li><a href="/dashboard/market"><i class="sidebar-item-icon ft-layers"></i><span class="nav-label">قیمت لحظه‌ای</span></a></li>
                    </ul>
                </li>
                <li><a href="/dashboard/affilate"><i class="sidebar-item-icon ft-users"></i><span class="nav-label">کسب درآمد</span></a></li>
                <li><a href="javascript:;"><i class="sidebar-item-icon ft-shopping-cart"></i><span class="nav-label">مالی</span><i class="arrow la la-angle-right"></i></a>
                    <ul class="nav-2-level">
                        <li><a href="/dashboard/checkouts"><i class="sidebar-item-icon ft-layers"></i><span class="nav-label">تسویه حساب</span></a></li>
                        <li><a href="/dashboard/bankaccounts"><i class="sidebar-item-icon ft-layers"></i><span class="nav-label">حساب‌های بانکی</span></a></li>
                    </ul>
                </li>
                <li><a href="/dashboard/tickets"><i class="sidebar-item-icon ft-mail"></i><span class="nav-label">تیکت</span></a></li>
                <li><a href="/dashboard/faq"><i class="sidebar-item-icon ft-book-open"></i><span class="nav-label">آموزش</span></a></li>
            </ul>
        </div>
        <!-- END: Sidebar-->

        <div class="content-area">
            <!-- BEGIN: Header-->
            <nav class="navbar navbar-expand navbar-light fixed-top header">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link navbar-icon sidebar-toggler" id="sidebar-toggler" href="#"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a></li>
                </ul>
                <ul class="navbar-nav">

                    @if($user->verified_at !== null)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbar-icon" data-toggle="dropdown" href="#">
                            <i class="ti-wallet font-18 position-relative"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pt-0" style="min-width: 60vw">
                            <div class="py-4 px-3 text-center text-white mb-3" style="background-color: #2c2f48;">
                                <h5 class="m-0">کیف پول</h5>
                            </div>
                            <div class="custom-scroll position-relative mb-3" style="height:320px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="media w-100"><i class="cc BTC-alt font-40 text-warning mr-4"></i>
                                                    <div class="media-body">
                                                        <div class="mb-2 text-muted font-16">کیف پول بیت کوین</div> 
                                                        <div class="d-flex" style="word-break:break-word"><span class="h5 mb-0 font-20"><span>{{ $headerWallets['BTC']->credit }}</span><span class="font-weight-normal">BTC</span></span><span class="mx-3"></span>قابل برداشت : ‌{{ $headerWallets['BTC']->cashable }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="media w-100"><i class="cc ETH-alt font-40 text-primary mr-4"></i>
                                                    <div class="media-body">
                                                        <div class="mb-2 text-muted font-16">کیف پول اتریم</div>
                                                        <div class="d-flex" style="word-break:break-word"><span class="h5 mb-0 font-20"><span>{{ $headerWallets['ETH']->credit }}</span><span class="font-weight-normal">ETH</span></span><span class="mx-3">قابل برداشت : ‌{{ $headerWallets['ETH']->cashable }}</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body media">
                                                <div class="media w-100"><i class="cc LTC-alt font-40 text-secondary mr-4"></i>
                                                    <div class="media-body">
                                                        <div class="mb-2 text-muted font-16">کیف پول لایت کوین</div>
                                                        <div class="d-flex" style="word-break:break-word"><span class="h5 mb-0 font-20"><span>{{ $headerWallets['LTC']->credit }}</span><span class="font-weight-normal">LTC</span></span><span class="mx-3">قابل برداشت : ‌{{ $headerWallets['LTC']->cashable }}</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body media">
                                                <div class="media w-100"><i class="cc XRP-alt font-40 text-primary mr-4"></i>
                                                    <div class="media-body">
                                                        <div class="mb-2 text-muted font-16">کیف پول ریپل</div>
                                                        <div class="d-flex" style="word-break:break-word"><span class="h5 mb-0 font-20"><span>{{ $headerWallets['XRP']->credit }}</span><span class="font-weight-normal">XRP</span></span><span class="mx-3">قابل برداشت : ‌{{ $headerWallets['XRP']->cashable }}</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif
                    <?php
                    $notifications = \App\Notification::getNotifications();
                    ?>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle navbar-icon" data-toggle="dropdown" href="#">
                            <i class="ft-bell position-relative"></i>
                            @if(count($notifications) > 0)
                            <span class="notify-signal bg-danger"></span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pt-0" style="min-width: 350px">
                            <div class="py-4 px-3 text-center text-white mb-3" style="background-color: #2c2f48;">
                                <h5 class="m-0">اعلان ها</h5>
                            </div>
                            <div class="custom-scroll position-relative mb-3" style="height:320px;">
                                <div class="list-group list-group-flush">
                                    @if(count($notifications) > 0)
                                    @foreach($notifications as $notification)
                                    <a class="list-group-item list-group-item-action px-4 py-3" href="{{ $notification->getTarget() }}">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <div class="flexbox">
                                                    <h6 class="mb-0 font-weight-bold">{{ $notification->title }}</h6>
                                                    <div class="text-muted font-13">{{ \Morilog\Jalali\Jalalian::forge($notification->created_at)->ago() }}</div>
                                                </div>
                                                <div class="font-13 text-muted">{{ $notification->text }}</div>
                                            </div>
                                        </div>
                                    </a>
                                    @endforeach
                                    @else
                                    <div class="text-center">
                                        هیچ اعلانی وجود ندارد.
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="px-3 py-2 text-center"><a class="hover-link font-13" href="javascript:;">مشاهده همه</a></div>
                        </div>
                    </li>
                    <li class="nav-divider"></li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle no-arrow d-inline-flex align-items-center" data-toggle="dropdown" href="#"><span class="d-none d-sm-inline-block mr-2">{{ $user->first_name }} {{ $user->last_name}}</span><span class="position-relative d-inline-block"><img class="rounded-circle" src="/assets/img/users/admin-image.png" alt="image" width="36" /></span></a>
                        <div class="dropdown-menu dropdown-menu-right pt-0 pb-4" style="min-width: 280px;">
                            <div class="p-4 mb-4 media align-items-center text-white" style="background-color: #2c2f48;"><img class="rounded-circle mr-3" src="/assets/img/users/admin-image.png" alt="image" width="55" />
                                <div class="media-body">
                                    <h5 class="mb-1">{{ $user->name }}</h5>
                                </div>
                            </div><a class="dropdown-item d-flex align-items-center" href="#"><i class="ft-user mr-3 font-18 text-muted"></i>اطلاعات کاربری</a><a class="dropdown-item d-flex align-items-center" href="#"><i class="ft-lock mr-3 font-18 text-muted"></i>تغییر رمز عبور</a>
                            <div class="dropdown-divider my-3"></div>
                            <div class="mx-4"><a class="btn btn-link p-0" href="/logout"><span class="btn-icon"><i class="ft-power mr-2 font-18"></i>خروج</span></a></div>
                        </div>
                    </li>
                    <li><a class="nav-link navbar-icon quick-sidebar-toggler" href="javascript:;"><span class="ft-align-left"></span></a></li>
                </ul>
            </nav>

            <div class="pricebar text-white w-100 bg-dark">
                <div class="mcwp-crypto" id="mcwp-6540">
                    <div class="mcwp-ticker mcwp-header" data-speed="100">
                        <div class="cc-ticker cc-white-color" style="background-color:#333333;">
                            <ul class="cc-stats">
                                @foreach($headcoins as $headcoin)
                                <li class="cc-coin">
                                    <div>
                                        <img src="{{ $headcoin->icon }}" alt="bitcoin">
                                        <b>{{ $headcoin->name }}
                                            <span>{{ $headcoin->price_in_toman }}</span>
                                            <span>
                                                <span class="mt-1 @if($headcoin->changePercent24Hr > 0) text-success @else text-danger @endif">{{ abs(round($headcoin->changePercent24Hr,2)) }}٪</span><i class="@if($headcoin->changePercent24Hr > 0) ft-arrow-up text-success @else ft-arrow-down text-danger @endif"></i>
                                            </span>
                                        </b>
                                    </div>
                                </li>
                                @endforeach


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Header-->
            @endif