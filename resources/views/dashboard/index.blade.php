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
        @include("includes.header")
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
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-2"><i class="cc BTC-alt font-40 text-warning"></i></div>
                                <div class="mb-3 text-muted font-16">بیت کوین</div>
                                <div class="d-flex justify-content-center align-items-center mb-1">
                                    <div class="h5 m-0 font-20"><span>{{ number_format($coins['bitcoin']->priceUsd,2) }}</span><span class="font-weight-normal">$</span></div>
                                    <div class="mx-3">
                                        <span class="@if($coins['bitcoin']->changePercent24Hr > 0) text-success @else text-danger @endif">{{ abs(round($coins['bitcoin']->changePercent24Hr,2)) }}٪</span><i class="@if($coins['bitcoin']->changePercent24Hr > 0) ft-arrow-up text-success @else ft-arrow-down text-danger @endif"></i>
                                    </div>
                                </div>
                                <div class="font-16 coinpriceToman" data-coin="{{ $coins['bitcoin']->id }}">{{ $coins['bitcoin']->price_in_toman }}</div>
                                <hr>
                                <div class="flexbox"><a href="/dashboard/buyoffer">خرید</a><a class="text-warning" href="/dashboard/buyoffer">فروش</a><a class="text-secondary" href="/dashboard/exchange">تبادل</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-2"><i class="cc ETC font-40 text-primary"></i></div>
                                <div class="mb-3 text-muted font-16">اتریم</div>
                                <div class="d-flex justify-content-center align-items-center mb-1">
                                    <div class="h5 m-0 font-20"><span>{{ number_format($coins['ethereum']->priceUsd,2) }}</span><span class="font-weight-normal">$</span></div>
                                    <div class="mx-3">
                                        <span class="@if($coins['ethereum']->changePercent24Hr > 0) text-success @else text-danger @endif">{{ abs(round($coins['ethereum']->changePercent24Hr,2)) }}٪</span><i class="@if($coins['ethereum']->changePercent24Hr > 0) ft-arrow-up text-success @else ft-arrow-down text-danger @endif"></i>
                                    </div>
                                </div>
                                <div class="font-16 coinpriceToman" data-coin="{{ $coins['ethereum']->id }}">{{ $coins['ethereum']->price_in_toman }}</div>
                                <hr>
                                <div class="flexbox" ><a href="/dashboard/buyoffer">خرید</a><a class="text-warning" href="/dashboard/buyoffer">فروش</a><a class="text-secondary" href="/dashboard/exchange">تبادل</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-2"><i class="cc LTC-alt font-40 text-secondary mb-1"></i></div>
                                <div class="mb-3 text-muted font-16">لایت کوین</div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="h5 m-0 font-20"><span>{{ number_format($coins['litecoin']->priceUsd,2) }}</span><span class="font-weight-normal">$</span></div>
                                    <div class="mx-3">
                                        <span class="@if($coins['litecoin']->changePercent24Hr > 0) text-success @else text-danger @endif">{{ abs(round($coins['litecoin']->changePercent24Hr,2)) }}٪</span><i class="@if($coins['litecoin']->changePercent24Hr > 0) ft-arrow-up text-success @else ft-arrow-down text-danger @endif"></i>
                                    </div>
                                </div>
                                <div class="font-16 coinpriceToman" data-coin="{{ $coins['litecoin']->id }}">{{ $coins['litecoin']->price_in_toman }}</div>
                                <hr>
                                <div class="flexbox"><a href="/dashboard/buyoffer">خرید</a><a class="text-warning" href="/dashboard/buyoffer">فروش</a><a class="text-secondary" href="/dashboard/exchange">تبادل</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-2"><i class="cc USDT-alt font-40 text-success mb-1"></i></div>
                                <div class="mb-3 text-muted font-16">تتر</div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="h5 m-0 font-20"><span>{{ number_format($coins['tether']->priceUsd,2) }}</span><span class="font-weight-normal">$</span></div>
                                    <div class="mx-3">
                                        <span class="@if($coins['tether']->changePercent24Hr > 0) text-success @else text-danger @endif">{{ abs(round($coins['tether']->changePercent24Hr,2)) }}٪</span><i class="@if($coins['tether']->changePercent24Hr > 0) ft-arrow-up text-success @else ft-arrow-down text-danger @endif"></i>
                                    </div>
                                </div>
                                <div class="font-16 coinpriceToman" data-coin="{{ $coins['tether']->id }}">{{ $coins['tether']->price_in_toman }}</div>
                                <hr>
                                <div class="flexbox"><a href="/dashboard/buyoffer">خرید</a><a class="text-warning" href="/dashboard/buyoffer">فروش</a><a class="text-secondary" href="/dashboard/exchange">تبادل</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card card-fullheight">
                            <div class="card-header p-0">
                                <ul class="nav line-tabs nav-justified line-tabs-2x line-tabs-solid w-100">
                                    <li class="nav-item"><a data-toggle="tab" href="#menu1" class="nav-link w-100 justify-content-center active show" style="border-top-right-radius: 0.6rem;">پیشنهاد فروش</a></li>
                                    <li class="nav-item"><a data-toggle="tab" href="#menu2" class="nav-link w-100 justify-content-center" style="border-top-left-radius: 0.6rem;">پیشنهاد خرید</a></li>
                                </ul>                                
                            </div>

                            <div class="card-body">
                                <div class="tab-content">
                                    <div id="menu1" class="tab-pane fade active show">
                                        <h5 class="box-title mb-4"><i class="ft-zap"></i>ایجاد پیشنهاد فروش</h5>
                                        <form action="/dashboard/newoffer" method="POST">
                                            @csrf
                                            <input type="hidden"  value="sell" name="type"/>
                                            <div class="form-group mb-5">
                                                <div class="form-row mt-1">
                                                    <div class="col-md">
                                                        <div style="width: 100%;">
                                                            <select required name="coin" class="form-control coins_select" style="width: 100%">
                                                                <option value=""></option>
                                                                @foreach($offerablecoins as $offerablecoin)
                                                                @if(isset($coins[strtolower($offerablecoin->name)]))
                                                                <option value="{{ strtolower($offerablecoin->name) }}" data-symbol="{{ strtoupper($offerablecoin->type_name) }}" data-price="{{ $coins[strtolower($offerablecoin->name)]->price_in_toman_int }}" data-icon="{{ url("/assets/icons/".strtolower($offerablecoin->type_name).".png") }}">{{ $offerablecoin->name }}</option>
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="input-group-icon input-group-icon-right">
                                                            <input class="form-control" type="text" name="coinـnum" required id="coin-num" placeholder="مقدار">
                                                            <span class="input-icon input-icon-right coinicon"></span>
                                                        </div>
                                                        <input class="form-control mt-1" type="text" name="mincoin" required placeholder="حداقل سفارش">
                                                    </div>
                                                    <div class="col-md-1 d-inline-flex justify-content-center align-items-center"><i class="fas fa-exchange-alt text-muted font-16"></i></div>
                                                    <div class="col-md d-flex justify-content-center flex-column">
                                                        <div class="input-group-icon input-group-icon-right w-100 my-2">
                                                            <input class="form-control" type="text" placeholder="قیمت پیشنهادی شما" required name="price_toman" id="offerprice"><span class="input-icon input-icon-right">تومان</span>
                                                        </div>
                                                        <p>
                                                            <span style="float:right;">قیمت پیشنهادی ما برای</span> <span id="price-toman"></span>
                                                        </p>
                                                        <div class="bg-warning text-white text-center rounded p-2 my-2" style="font-size: 12px;">
                                                            مبلغی که شما از فروش <span id="selloffercoin"></span>  دریافت می‌کنید
                                                            <p class="text-center" id="totalsellprice">
                                                                قیمت پیشنهادی خود را وارد کنید
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <ul type="disc">
                                                        <li>قیمت پیشنهادی ما همیشه با توجه نوسانات قیمت جهانی ارزهای دیجیتال و با نسبت ثابت تغییر خواهد کرد</li>
                                                        <li>قیمت پیشنهادی ما همیشه ۱٪ بیشتر از قیمت جهانی ارز انتخابی خواهد بود.</li>
                                                    </ul>

                                                </div>
                                                <div class="col-4 text-right">
                                                    <button class="btn btn-danger btn-rounded" type="submit" style="min-width: 200px">تکمیل سفارش</button>
                                                </div>
                                            </div>                                       
                                        </form>
                                    </div>
                                    <div id="menu2" class="tab-pane">
                                        <h5 class="box-title mb-4"><i class="ft-zap"></i>ایجاد پیشنهاد خرید</h5>
                                        <form action="/dashboard/newoffer" method="POST">
                                            @csrf
                                            <input type="hidden"  value="buy" name="type"/>
                                            <div class="form-group mb-5">
                                                <div class="form-row mt-1">
                                                    <div class="col-md">
                                                        <div style="width: 100%;">
                                                            <select required name="coin" class="form-control coins_select" style="width: 100%">
                                                                <option value=""></option>
                                                                @foreach($offerablecoins as $offerablecoin)
                                                                @if(isset($coins[strtolower($offerablecoin->name)]))
                                                                <option value="{{ strtolower($offerablecoin->name) }}" data-symbol="{{ strtoupper($offerablecoin->type_name) }}" data-price="{{ $coins[strtolower($offerablecoin->name)]->price_in_toman_int }}" data-icon="{{ url("/assets/icons/".strtolower($offerablecoin->type_name).".png") }}">{{ $offerablecoin->name }}</option>
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="input-group-icon input-group-icon-right">
                                                            <input class="form-control" type="text" name="coinـnum" required id="coinbuy-num" placeholder="مقدار">
                                                            <span class="input-icon input-icon-right coinicon"></span></div>
                                                        <input class="form-control mt-1" type="text" name="mincoin" required placeholder="حداقل سفارش">
                                                    </div>
                                                    <div class="col-md-1 d-inline-flex justify-content-center align-items-center"><i class="fas fa-exchange-alt text-muted font-16"></i></div>
                                                    <div class="col-md d-flex justify-content-center flex-column">
                                                        <div class="input-group-icon input-group-icon-right w-100 my-2">
                                                            <input class="form-control" type="text" placeholder="قیمت به تومان" required name="price_toman"><span class="input-icon input-icon-right">تومان</span>
                                                        </div>
                                                        <p>
                                                            <span style="float:right;">قیمت پیشنهادی ما برای</span> <span id="pricebuy-toman"></span>
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <ul type="disc">
                                                        <li>قیمت پیشنهادی ما همیشه با توجه نوسانات قیمت جهانی ارزهای دیجیتال و با نسبت ثابت تغییر خواهد کرد</li>
                                                        <li>قیمت پیشنهادی ما همیشه ۱٪ کمتر از قیمت جهانی ارز انتخابی خواهد بود.</li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    <button class="btn btn-danger btn-rounded" type="submit" style="min-width: 200px">تکمیل سفارش</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-fullheight">
                            <div class="card-header">
                                <h4 class="m-0">مبدل ارز</h4>
                            </div>
                            <div class="card-body">
                                <form action="javascript:;">
                                    <div class="form-group mb-5">
                                        <div class="form-group">
                                            <div class="input-group-icon input-group-icon-right"><input class="form-control" id="amount" type="number" step="0.0000001" min="0" required placeholder="مقدار مورد نظر را وارد کنید"></div>
                                        </div>
                                    </div>
                                    <div class="form-group px-5">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <select class="form-control my-1" required id="from_coin" data-icon="http://raya.webflaxco.ir/assets/img/raya-logo.png">
                                                <option value="" data-icon="http://raya.webflaxco.ir/assets/img/raya-logo.png"></option>
                                                @foreach($currencies as $currency)
                                                <option value="{{ $currency->symbol }}" data-icon="https://simpleswap.io{{ $currency->image }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="d-inline-flex justify-content-center align-items-center my-1"><i class="fas fa-exchange-alt text-muted font-16"></i></div>
                                            <select class="form-control my-1" id="to_coin" required>
                                                <option value="" data-icon="http://raya.webflaxco.ir/assets/img/raya-logo.png"></option>
                                                @foreach($currencies as $currency)
                                                <option value="{{ $currency->symbol }}" data-icon="https://simpleswap.io{{ $currency->image }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-right" style="display: flex;justify-content: center;align-items: flex-end;flex-direction: column;">
                                        <div class="p-1 text-center w-100 " id="cointarget" style="font-size: 1.5rem;direction: rtl;">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <a class="btn btn-danger btn-rounded" href="/dashboard/exchange" style="min-width: 200px">تبادل</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-column">
                                    <div>
                                        <h5 class="box-title mb-2"><i class="ft-download"></i> آخرین خریداران </h5>
                                    </div>
                                    <div>
                                        <ul class="nav line-tabs line-tabs-solid w-100" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center justify-content-center loadcoinoffers px-1" data-offer="buy" data-coin="bitcoin"data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false">Bitcoin <i class="cc mx-2 BTC-alt font-20 text-warning mb-2"></i></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center justify-content-center loadcoinoffers px-1" data-offer="buy" data-coin="etheruem" data-toggle="tab" role="tab"  aria-selected="false">Ethereum <i class="cc mx-2 ETH-alt font-20 text-primary mb-2"></i></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center justify-content-center loadcoinoffers px-1" data-offer="buy" data-coin="teather" data-toggle="tab" role="tab"  aria-selected="false">Tether <i class="cc mx-2 USDT-alt font-20 text-success mb-2"></i></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center justify-content-center loadcoinoffers px-1 h-100" data-offer="buy" data-coin="more" data-toggle="tab" role="tab"  aria-selected="false">سایر <i class="mx-2 ti-more font-20 text-muted"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="table-responsive font-11">
                                    <div class="table-responsive font-11">
                                        <div class="table-responsive font-11">
                                            <table class="table table-hover compact-table" id="sellofferstable">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>نام کاربری</th>
                                                        <th>ارز</th>
                                                        <th>موجودی</th>
                                                        <th>حداقل فروش</th>
                                                        <th>واحد (تومان)</th>
                                                        <th>تاریخ</th>
                                                        <th>#</th>
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
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-column">
                                    <div>
                                        <h5 class="box-title mb-2"><i class="ft-download"></i> آخرین فروشندگان </h5>
                                    </div>
                                    <div>
                                        <ul class="nav line-tabs line-tabs-solid w-100" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center justify-content-center loadcoinoffers px-1" data-offer="sell" data-coin="bitcoin"data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false">Bitcoin <i class="cc mx-2 BTC-alt font-20 text-warning mb-2"></i></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center justify-content-center loadcoinoffers px-1" data-offer="sell" data-coin="etheruem" data-toggle="tab" role="tab"  aria-selected="false">Ethereum <i class="cc mx-2 ETH-alt font-20 text-primary mb-2"></i></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center justify-content-center loadcoinoffers px-1" data-offer="sell" data-coin="teather" data-toggle="tab" role="tab"  aria-selected="false">Tether <i class="cc mx-2 USDT-alt font-20 text-success mb-2"></i></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center justify-content-center loadcoinoffers h-100  px-1" data-offer="sell" data-coin="more" data-toggle="tab" role="tab"  aria-selected="false">سایر <i class="mx-2 ti-more font-20 text-muted"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="table-responsive font-11">
                                    <table class="table table-hover compact-table" id="buyofferstable">
                                        <thead class="thead-light" >
                                            <tr>
                                                <th>نام کاربری</th>
                                                <th>ارز</th>
                                                <th>موجودی</th>
                                                <th>حداقل خرید</th>
                                                <th>واحد (تومان)</th>
                                                <th>تاریخ</th>
                                                <th>#</th>
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

                <div class="row">
                    <div class="col-lg-7">
                        <div class="card card-fullheight">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-4">
                                    <div>
                                        <h5 class="box-title mb-0">آخرین تراکنش ها</h5>
                                    </div><a class="text-muted" href="#"><i class="ti-more-alt"></i></a>
                                </div>
                                <div class="card-fullwidth-block">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="pl-4">نوع ارز</th>
                                                    <th>مبلغ</th>
                                                    <th class="pr-4">فعالیت</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transactions as $transaction)
                                                <tr>
                                                    <td class="pl-4"><b>{{ $transaction->coin }}</b></td>
                                                    <td>{{ $transaction->amount}}</td>
                                                    <td class="text-success">{{ $transaction->type }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card card-fullheight">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-5">
                                    <h5 class="box-title mb-0"><i class="ft-activity"></i> آخرین فعالیت های شما </h5>
                                </div>
                                <ul class="timeline timeline-default outline-points timeline-danger">
                                    @foreach($activities as $activity)
                                    <li class="timeline-item">{{ $activity->text }}<span class="font-13 text-muted ml-2">{{ Jalalian::forge($activity->created_at)->ago() }}</span></li>
                                    @endforeach
                                </ul>
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
<script src="/assets/js/index.js"></script>
<script>

$(document).ready(function () {
    $("#from_coin,#to_coin").change(function () {
        var from_coin = $("#from_coin").val();
        var to_coin = $("#to_coin").val();
        if (from_coin !== to_coin) {
            var amount = $("#amount").val();
            if (amount !== "" && parseFloat(amount) > 0 && parseInt(amount) !== NaN) {
                $.get("/get_estimate?from=" + from_coin + "&to=" + to_coin + "&amount=" + amount, {}, function (data) {
                    $("#cointarget").text(amount + " " + from_coin + " = " + data.value + to_coin);
                });
            }
        } else {
            Swal.fire(
                    'خطا!',
                    'نمی‌توان یک کوین را به خودش تبادل کرد',
                    'error'
                    );
            $("#to_coin").val(null);
            $("#from_coin").val(null);
            $("#from_coin").trigger('change.select2');
            $("#to_coin").trigger('change.select2');
        }
    });
    $("#amount").on("input", function () {
        var from_coin = $("#from_coin").val();
        var to_coin = $("#to_coin").val();
        var amount = $("#amount").val();
        if (from_coin !== "" && to_coin !== "") {
            if (amount !== "" && parseFloat(amount) > 0 && parseInt(amount) !== NaN) {
                $.get("/get_estimate?from=" + from_coin + "&to=" + to_coin + "&amount=" + amount, {}, function (data) {
                    $("#cointarget").html(amount + " " + from_coin.toUpperCase() + " = " + (Math.round((parseFloat(data.value) + Number.EPSILON) * 100) / 100)+ " " + to_coin.toUpperCase() + "<br>"
                            + "<p style='font-size:14px;' class='text-muted mb-0'>" + "با دقت بیشتر : " + "</p><p style='font-size:14px;' class='text-muted'>" + data.value + to_coin.toUpperCase() + "</p>");
                });
            }
        } else {
            Swal.fire(
                    'خطا!',
                    'ارز مبدا و مقصد را انتخاب کنید',
                    'error'
                    );
            $(this).val("");
        }
    });
    $("#exchangebtn").click(function () {
        var from_coin = $("#from_coin").val();
        var to_coin = $("#to_coin").val();
        var amount = $("#amount").val();
        var wallet = $("#walletAddress").val();
        $(this).prop("disabled", true);
        $.post("/exchange", {_token: $("meta[name='csrf-token']").attr("content"), from: from_coin, to: to_coin, amount: amount, wallet: wallet}, function (data) {
            if (data.address_from) {
                $("#msg").html("مقدار " + amount + from_coin + " " + "به این کیف پول واریز کنید تا تبادل ارز دیجیتال انجام شود" + "<br><br>" + data.address_from);
            } else {
                $("#msg").html("آدرس کیف‌پول اشتباه است! ");
            }
            $("#exchangebtn").prop("disabled", false);
        });
    });
});
</script>
</body>
</html>