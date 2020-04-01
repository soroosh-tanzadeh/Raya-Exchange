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
use App\Alert;
use App\Option;

$headcoins = Exchange::getCoins();
$headerWallets = Wallet::getWallets();
?>

@if($user->is_admin)
<div class="modal fade" id="lawsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">قوانین و مقررات</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="max-width: 100%;height: 250px;overflow: auto;padding: 10px;border: 1px solid #C8C8C8;" readonly="" class="is-valid" aria-invalid="false">
                    {!! Option::getOption("laws") !!}
                </div>
            </div>
        </div>
    </div> 
</div>
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
                    <input type="text" name="amount" step="0.0000001" class="form-control" value="" id="coinamount" data-price="" data-coin="bitcoin" style="width: 100%;margin-bottom: 10px;" placeholder="مقدار مورد نظر خود را وارد کنید" />
                    <div class="my-2">
                        قیمت:  <text id="coinprice" ></text>
                    </div>
                    <input class="btn btn-primary btn-rounded" type="submit" value="پرداخت" />
                </form>
            </div>
        </div>
    </div> 
</div>

<div class="modal fade" id="paymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/payir/pay" id="payrialform" class="coinform" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">شارژ کیف‌پول ریالی</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>مبلغ شارژ (تومان)</label>
                    <input type="text" name="amount" class="form-control numeric" required value="" style="width: 100%;margin-bottom: 10px;" title="این فیلد اجباری است." placeholder="مبلغ مورد نظر خود را وارد کنید" />
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-rounded" type="button" data-dismiss="modal">انصراف</button>
                    <input class="btn btn-primary btn-rounded" type="submit" value="پرداخت" />
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="paycoinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <img src='' id='paycoinimg' style="max-width: 40px" /> شارژ <span id='paycoinsymbol'></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  action="/paycoin" id="paycoinform" class="coinform" method="GET">
                <div class="modal-body">
                    <label>میزان کوین</label>
                    <input id="targetcoin" type="hidden" name="target" value="" />
                    <input type="text" name="amount" required class="form-control numeric" value="" style="width: 100%;margin-bottom: 10px;" title="این فیلد اجباری است." placeholder="میزان کوین مورد نظر خود را وارد کنید" />
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-rounded" type="button" data-dismiss="modal">انصراف</button>
                    <input class="btn btn-primary btn-rounded" type="submit" value="پرداخت" />
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="checkoutcoinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <img src='' id='recievecoinimg' style="max-width: 40px" /> برداشت <span id='recievecoinsymbol'></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="javascript:;" id="receiveform" onsubmit="submitAjaxForm(this);" method="POST" data-action="/coin/checkoutrequest">
                <div class="modal-body">
                    @csrf
                    <input id="checkouttargetcoin" type="hidden" name="target" value="" />
                    <div class="form-group">
                        <label>میزان کوین</label>
                        <input id="checkoutcoinamount" type="text" required name="amount" class="form-control numeric" value="" style="width: 100%;margin-bottom: 10px;" title="این فیلد اجباری است." placeholder="میزان کوین مورد نظر خود را وارد کنید" />
                    </div>
                    <div class="form-group">
                        <label>آدرس کیف پول</label>
                        <input id="coinwalletAddress" type="text" name="token" class="form-control" required value="" style="width: 100%;margin-bottom: 10px;" placeholder="آدرس کیف پول خود را وارد کنید" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-rounded" type="button" data-dismiss="modal">انصراف</button>
                    <input class="btn btn-primary btn-rounded" type="submit" value="ثبت درخواست برداشت" />
                </div>
            </form>

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
            <form action="javascript:;" onsubmit="submitAjaxForm(this);" id="sellcoinform" method="GET" data-target="/dashboard/mywallet">
                <div class="modal-body">
                    <input type="hidden" id="sellofferid" name="offer_id"/>
                    <label>مقدار کوین</label>
                    <input type="number" name="amount" step="0.0000001" class="form-control" value="" data-price="" data-coin="bitcoin" style="width: 100%;margin-bottom: 10px;" placeholder="مقدار مورد نظر خود را وارد کنید" />
                </div>  
                <div class="modal-footer">
                    <input class="btn btn-primary" type="submit" value="فروش" />
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">انصراف</button>
                </div>
            </form>

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

                <li><a href="/dashboard/exchange"><i class="sidebar-item-icon fas fa-exchange-alt"></i><span class="nav-label">معاملات ارز</span></a></li>
                <li><a href="/dashboard/market"><i class="sidebar-item-icon ft-trending-up"></i><span class="nav-label">قیمت لحظه‌ای ارز‌دیجیتال</span></a></li>
                <li><a href="/dashboard/affilate"><i class="sidebar-item-icon ft-users"></i><span class="nav-label">کسب درآمد</span></a></li>
                <li><a href="javascript:;"><i class="sidebar-item-icon ft-list"></i><span class="nav-label">تراکنش‌ها</span><i class="arrow la la-angle-right"></i></a>
                    <ul class="nav-2-level">
                        <li><a href="/dashboard/rials"><i class="sidebar-item-icon ft-layers"></i><span class="nav-label">ریالی</span></a></li>
                        <li><a href="/dashboard/crypto"><i class="sidebar-item-icon ft-layers"></i><span class="nav-label">ارز دیجیتال</span></a></li>
                    </ul>
                </li>
                <li><a href="javascript:;"><i class="sidebar-item-icon ft-credit-card"></i><span class="nav-label">امور مالی</span><i class="arrow la la-angle-right"></i></a>
                    <ul class="nav-2-level">
                        <li><a href="/dashboard/checkouts"><i class="sidebar-item-icon ft-layers"></i><span class="nav-label">تسویه حساب</span></a></li>
                        <li><a href="/dashboard/bankaccounts"><i class="sidebar-item-icon ft-layers"></i><span class="nav-label">حساب‌های بانکی</span></a></li>
                    </ul>
                </li>
                <li><a href="/dashboard/tickets"><i class="sidebar-item-icon ft-mail"></i><span class="nav-label">تیکت</span></a></li>
                <li><a href="/dashboard/knowledge"><i class="sidebar-item-icon ft-book-open"></i><span class="nav-label">آموزش‌</span></a></li>

            </ul>
        </div>
        <!-- END: Sidebar-->

        <div class="content-area">
            <!-- BEGIN: Header--> 
            <nav class="navbar navbar-expand navbar-light fixed-top header">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link navbar-icon sidebar-toggler" id="sidebar-toggler" href="#">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-warning btn-rounded d-flex align-items-center" href="{{ url("/dashboard/buyoffer") }}"><i class="ti-plus mx-1"></i> ایجاد پیشنهاد جدید</a>
                    </li>


                </ul>
                <ul class="navbar-nav">

                    @if($user->verified_at !== null)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbar-icon" data-toggle="dropdown" href="#">
                            <i class="ti-wallet font-18 position-relative"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pt-0" style="min-width: 350px">
                            <div class="py-4 px-3 text-center text-white" style="background-color: #2c2f48;">
                                <h5 class="m-0">کیف پول</h5>
                            </div>
                            <div class="custom-scroll position-relative mb-3 ps" style="height:320px;">
                                <div class="list-group list-group-flush">
                                    @foreach($headerWallets as $headerWallet)
                                    <div class="list-group-item list-group-item-action px-4 py-3">
                                        <div class="media align-items-center">
                                            <img src="{{ url("/assets/icons/". strtolower($headerWallet->type_name) .".png") }}" class="mr-2" style="max-width: 40px;">
                                            <div class="media-body">
                                                <div class="flexbox">
                                                    <h6 class="mb-0 font-weight-bold">{{ $headerWallet->name }}</h6>
                                                    <div class="text-muted font-13">
                                                        <div class="btn-group" style="margin-bottom: -38px;">
                                                            @if($headerWallet->type === 'rial')
                                                            <a class="btn btn-outline-primary btn-sm d-flex justify-content-center align-items-center" data-toggle="tooltip" title="واریز" onclick="$('#paymodal').modal()" data-target="" href="#paymodal"><i class="ti-download"></i></a>
                                                            <a class="btn btn-outline-danger btn-sm d-flex justify-content-center align-items-center" data-toggle="tooltip" title="برداشت" href="/dashboard/checkouts"><i class="ti-upload"></i></a>
                                                            @else
                                                            <a class="btn btn-outline-primary btn-sm d-flex justify-content-center align-items-center paycoin" data-toggle="tooltip" title="واریز" data-coin="{{ $headerWallet->type_name }}" data-name="{{ $headerWallet->name }}"><i class="ti-download"></i></a>
                                                            <a class="btn btn-outline-danger btn-sm d-flex justify-content-center align-items-center recievecoin" data-toggle="tooltip" title="برداشت" data-coin="{{ $headerWallet->type_name }}" data-name="{{ $headerWallet->name }}"><i class="ti-upload"></i></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="font-13 text-muted"> موجودی :‌{{ $headerWallet->credit }}</div>
                                                <div class="font-13 text-muted">قابل برداشت :‌{{ $headerWallet->cashable }}</div>

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; left: -6px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                            <div class="px-3 py-2 text-center"><a class="hover-link font-13" href="/dashboard/mywallet">افزودن کیف پول جدید</a></div>
                        </div>
                    </li>
                    @endif
                    <?php
                    $notifications = \App\Notification::getNotifications();
                    ?>
                    <li class="nav-item dropdown" id="notifcations">
                        <a class="nav-link dropdown-toggle navbar-icon" data-toggle="dropdown" href="#">
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
                        </div>
                    </li>
                    <li class="nav-divider"></li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle no-arrow d-inline-flex align-items-center" data-toggle="dropdown" href="#"><span class="d-none d-sm-inline-block mr-2">{{ $user->first_name }} {{ $user->last_name}}</span><span class="position-relative d-inline-block"><img class="rounded-circle" src="/assets/img/users/admin-image.png" alt="image" width="36" /></span></a>
                        <div class="dropdown-menu dropdown-menu-right pt-0 pb-4" style="min-width: 280px;">
                            <div class="p-4 mb-4 media align-items-center text-white" style="background-color: #2c2f48;"><img class="rounded-circle mr-3" src="/assets/img/users/admin-image.png" alt="image" width="55" />
                                <div class="media-body">
                                    <h5 class="mb-1">{{ $user->name }}</h5>
                                </div>
                            </div><a class="dropdown-item d-flex align-items-center" href="/dashboard/profile"><i class="ft-user mr-3 font-18 text-muted"></i>اطلاعات کاربری</a><a class="dropdown-item d-flex align-items-center" href="/dashboard/passchange"><i class="ft-lock mr-3 font-18 text-muted"></i>تغییر رمز عبور</a>
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
                                        <b class="d-flex align-items-center">
                                            <span class="mx-1 float-left">{{ $headcoin->name }}</span>
                                            <span class="coinpriceToman mx-1 float-left" data-coin="{{ $headcoin->id }}">{{ $headcoin->price_in_toman }}</span>
                                            <span class="d-flex align-items-center">
                                                <span class="mt-1 float-left @if($headcoin->changePercent24Hr > 0) text-success @else text-danger @endif">{{ abs(round($headcoin->changePercent24Hr,2)) }}٪</span><i class="@if($headcoin->changePercent24Hr > 0) ft-arrow-up text-success @else ft-arrow-down text-danger @endif"></i>
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