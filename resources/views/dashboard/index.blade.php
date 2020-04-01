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
use App\Wallet;

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
            @include("includes.alert")

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
                        @include("includes.offerCard")
                    </div>
                    <div class="col-lg-4"> 
                        <div class="card card-fullheight">
                            <div class="card-header">
                                <h4 class="m-0"><i class="ft-shuffle"></i> مبدل ارز</h4>
                            </div>
                            <form action="{{ url("/dashboard/exchange") }}" method="GET" id="coinexchange">
                                <div class="card-body">

                                    <ul class="nav nav-pills w-100 mb-2">
                                        <li class="nav-item clickable w-50"><a data-toggle="tab" class="nav-link d-flex w-100 justify-content-center extype active show" data-type="fixed">نرخ ثابت</a></li>
                                        <li class="nav-item clickable w-50"><a data-toggle="tab" class="nav-link d-flex w-100 justify-content-center extype" data-type="floating">نرخ شناور</a></li>
                                    </ul>

                                    <div class="form-group mb-5">
                                        <div class="d-flex flex-column justify-content-center">
                                            <div class="from-group w-100">
                                                <select class="form-control my-1" name="from" required id="from_coin" data-icon="http://raya.webflaxco.ir/assets/img/raya-logo.png">
                                                    <option value="" data-icon="http://raya.webflaxco.ir/assets/img/raya-logo.png"></option>
                                                    @foreach($currencies as $currency)
                                                    <option value="{{ $currency->symbol }}" data-icon="https://simpleswap.io{{ $currency->image }}">{{ $currency->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="d-inline-flex justify-content-center align-items-center my-1"><i class="fas fa-exchange-alt text-muted font-16"></i></div>
                                            <div class="from-group w-100">
                                                <select class="form-control my-1" name="to" id="to_coin" required>
                                                    <option value="" data-icon="http://raya.webflaxco.ir/assets/img/raya-logo.png"></option>
                                                    @foreach($currencies as $currency)
                                                    <option value="{{ $currency->symbol }}" data-icon="https://simpleswap.io{{ $currency->image }}">{{ $currency->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                    </div>



                                    <div class="form-group mb-5 mt-5">
                                        <div class="input-group">
                                            <input class="form-control numeric" id="amount" type="text" name="amount" required placeholder="مقدار مورد نظر را وارد کنید"/>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 justify-content-center py-3">
                                        <img src="/assets/img/exchange-icon.png" style="max-width: 80px;height: 80px;"/>
                                    </div>
                                    <div class="text-right" style="display: flex;justify-content: center;align-items: flex-end;flex-direction: column;">
                                        <div class="p-1 text-center w-100 " id="cointarget" style="font-size: 1.5rem;direction: rtl;">

                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    <button class="btn btn-danger btn-rounded" id="exchangebtn" type="submit" style="min-width: 200px">تبادل</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header p-0">
                                <ul class="nav line-tabs nav-justified line-tabs-2x line-tabs-solid w-100">
                                    <li class="nav-item"><a data-toggle="tab" href="#buyers" class="nav-link w-100 justify-content-center active show" style="border-top-right-radius: 0.6rem;">آخرین خریداران</a></li>
                                    <li class="nav-item"><a data-toggle="tab" href="#sellers" class="nav-link w-100 justify-content-center" style="border-top-left-radius: 0.6rem;">آخرین فروشندگان</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div id="buyers" class="tab-pane fade active show">
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
                                        <div class="table-responsive font-11">
                                            <div class="table-responsive font-11">
                                                <div class="table-responsive font-11">
                                                    <table class="table table-hover compact-table w-100" id="sellofferstable">
                                                        <thead class="thead-light">
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
                                    <div id="sellers" class="tab-pane">
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
                                        <div class="table-responsive font-11">
                                            <table class="table table-hover compact-table w-100" id="buyofferstable">
                                                <thead class="thead-light" >
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
                </div>

                <div class="row">
                    <div class="col-md-12">

                    </div>                    
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex w-100 justify-content-between">
                                    <div>
                                        <h5 class="m-0"><i class="sidebar-item-icon ft-shopping-cart"></i> پیشنهادات من</h5>
                                    </div>
                                    <a class="text-muted" href="/dashboard/myoffers">مشاهده همه<i class="ft-arrow-left mx-1"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive font-11">
                                    <table class="table datatable table-hover compact-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>شماره سفارش</th>
                                                <th>نوع ارز</th>
                                                <th>مقدار</th>
                                                <th>قیمت در لحظه سفارش</th>
                                                <th>نوع معامله</th>
                                                <th>تاریخ ایجاد</th>
                                                <th>وضعیت</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($myoffers as $offer)
                                            <tr>
                                                <td>{{ $offer->id }}</td>
                                                <td>
                                                    {{ $offer->coin }}
                                                    <img src="/assets/icons/{{ strtolower($coins[$offer->coin]->symbol) }}.png" style="max-width: 30px;"/>

                                                </td>
                                                <td>{{ $offer->amount }}</td>
                                                <td><?php
                                                    $priceInToman = ($offer->price_pre * $offer->amount) / $offer->max_buy;
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
                                                <td>{{ $offer->created_at }}</td>
                                                <td>
                                                    @if($offer->type === "sell")
                                                    فروش
                                                    @else
                                                    خرید
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($offer->is_selled)
                                                    فروخته شده
                                                    @else
                                                    در انتظار خریدار
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="button" class="btn btn-danger" value="لغو پیشنهاد" />
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <h5 class="box-title mb-0"><i class="ft-menu"></i> آخرین تراکنش‌ها</h5>
                                    </div>
                                    <a class="text-muted" href="/dashboard/rials">مشاهده همه<i class="ft-arrow-left mx-1"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table datatable table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="pl-4">نوع ارز</th>
                                                <th>میزان</th>
                                                <th class="pr-4">عملیات</th>
                                                <th class="pr-4">وضعیت</th>
                                                <th class="pr-4">تاریخ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transactions as $transaction)
                                            <tr>
                                                <td class="pl-4"><b>{{ $transaction->coin }}</b></td>
                                                <td>{{ $transaction->amount}}</td>
                                                <td class="text-success">{{ $transaction->type }}</td>
                                                <td class="text-success">{{ Jalalian::forge($transaction->created_at)->ago() }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card card-fullheight">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h5 class="box-title mb-0"><i class="ft-activity"></i> آخرین فعالیت های شما </h5>
                                </div>
                            </div>
                            <div class="card-body">
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
        <!-- END: Quick sidebar-->
        @include("includes.footer")
        <script src="/assets/js/index.js"></script>
        <script>


function resolveAfter2Seconds(x) {
    return new Promise(resolve => {
        setTimeout(() => {
            resolve(x);
        }, 2000);
    });
}

$(document).ready(function () {

    var dataType = "fixed";


    $(".extype").click(function () {
        dataType = $(this).data("type");
        $.ajax({
            url: "/get_all_coins",
            type: 'GET',
            data: {type: dataType},
            beforeSend: function (xhr) {
                $("#exchangebtn").prop("disabled", true);
                $("#loader").show();
            },
            success: function (data, textStatus, jqXHR) {
                $("#from_coin").html(data.from);
                $("#to_coin").html(data.to);
                setTimeout(function () {
                    $("#loader").hide();
                    $("#exchangebtn").prop("disabled", false);
                    if ($("#amount").val() !== '') {
                        $("#amount").trigger("input");
                    }

                    $("#from_coin").select2("destroy");
                    $("#to_coin").select2("destroy");
                    $("#from_coin").select2({
                        placeholder: "از",
                        templateSelection: iformat,
                        templateResult: iformat,
                        allowHtml: true
                    });
                    $("#to_coin").select2({
                        placeholder: "به",
                        templateSelection: iformat,
                        templateResult: iformat,
                        allowHtml: true
                    });
                    if ($("#amount").val() !== '') {
                        $("#amount").trigger("input");
                    }
                }, 1000);
            }

        });
    });



    $("#to_coin").change(function () {
        if ($("#from_coin").val() === "") {
            $.ajax({
                url: "/getpairs",
                type: 'GET',
                data: {coin: $(this).val(), type: dataType},
                beforeSend: function (xhr) {
                    $("#exchangebtn").prop("disabled", true);
                    $("#cointarget").html('<img src="/assets/img/loader.gif" style="max-width: 80px"/>');
                },
                complete: function (jqXHR, textStatus) {
                    $("#exchangebtn").prop("disabled", false);
                    $("#cointarget").html(" ");
                },
                success: function (data, textStatus, jqXHR) {
                    $("#from_coin").html(data);
                    setTimeout(function () {
                        $("#exchangebtn").prop("disabled", false);
                        $("#cointarget").html(" ");
                        if ($("#amount").val() !== '') {
                            $("#amount").trigger("change");
                        }

                        $("#from_coin").select2("destroy");
                        $("#from_coin").select2({
                            placeholder: "از",
                            templateSelection: iformat,
                            templateResult: iformat,
                            allowHtml: true
                        });
                        if ($("#amount").val() !== '') {
                            $("#amount").trigger("input");
                        }
                    }, 1000);

                }
            });
        }
        if (resolveAfter2Seconds($("#amount").val()) !== '') {
            $("#amount").trigger("change");
        }
    });


    $("#from_coin").change(function () {
        $.ajax({
            url: "/getpairs",
            type: 'GET',
            data: {coin: $(this).val(), type: dataType},
            beforeSend: function (xhr) {
                $("#exchangebtn").prop("disabled", true);
                $("#cointarget").html('<img src="/assets/img/loader.gif" style="max-width: 80px"/>');
            },
            complete: function (jqXHR, textStatus) {
                $("#exchangebtn").prop("disabled", false);
                $("#cointarget").html(" ");
            },
            success: function (data, textStatus, jqXHR) {
                $("#to_coin").html(data);

                setTimeout(function () {
                    $("#exchangebtn").prop("disabled", false);
                    $("#cointarget").html(" ");
                    if ($("#amount").val() !== '') {
                        $("#amount").trigger("change");
                    }

                    $("#to_coin").select2("destroy");
                    if (data !== "") {
                        $("#to_coin").select2({
                            placeholder: "به",
                            templateSelection: iformat,
                            templateResult: iformat,
                            allowHtml: true
                        });
                        if ($("#amount").val() !== '') {
                            $("#amount").trigger("input");
                        }
                    } else {
                        $("#to_coin").select2({
                            placeholder: "موردی یافت نشد!",
                            templateSelection: iformat,
                            templateResult: iformat,
                            allowHtml: true
                        });
                    }
                    if ($("#amount").val() !== '') {
                        $("#amount").trigger("input");
                    }
                }, 1000);

            }
        });
    });


//setup before functions
    var typingTimer;                //timer identifier
    var doneTypingInterval = 2000;  //time in ms, 5 second for example

//on keyup, start the countdown
    $('#amount').on('keyup', function () {
        $("#cointarget").html('<img src="/assets/img/loader.gif" style="max-width: 80px"/>');
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function () {
            $("#amount").trigger("change");
        }, doneTypingInterval);
    });

//on keydown, clear the countdown 
    $('#amount').on('keydown', function () {
        clearTimeout(typingTimer);
    });

    $("#amount").on("change", function () {
        $("#amount").parent().parent().find('.text-danger').remove();
        $("#amount").removeClass("is-invalid");
        $("#exchangebtn").prop("disabled", true);
        var from_coin = $("#from_coin").val();
        var to_coin = $("#to_coin").val();
        var amount = $("#amount").val();
        if (from_coin !== "" && to_coin !== "") {
            if (amount !== "" && parseFloat(amount) > 0 && parseInt(amount) !== NaN) {
                $("#cointarget").html('<img src="/assets/img/loader.gif" style="max-width: 80px"/>');
                $.ajax({
                    url: "/get_estimate",
                    data: {
                        from: from_coin,
                        to: to_coin,
                        amount: amount,
                        type: dataType
                    },
                    success: function (data, textStatus, jqXHR) {
                        if (!isNaN(parseFloat(data.value))) {
                            $("#cointarget").html(amount + "" + from_coin.toUpperCase() + " = " + (Math.round((parseFloat(data.value) + Number.EPSILON) * 100) / 100) + "" + to_coin.toUpperCase() + "<br>"
                                    + "<p style='font-size:14px;' class='text-muted mb-0'>" + "با دقت بیشتر : " + "</p><p style='font-size:14px;' class='text-muted'>" + data.value + to_coin.toUpperCase() + "</p>");
                            $("#exchangebtn").prop("disabled", false);
                            setTimeout(function () {
                                $("#amount").parent().parent().find('.text-danger').remove();
                                $("#amount").removeClass("is-invalid");
                                $("#exchangebtn").prop("disabled", false);
                            }, 300);
                        } else {
                            if (data.max) {
                                $("#cointarget").html("");
                                $("#amount").parent().parent().find('.text-danger').remove();
                                $("#amount").addClass("is-invalid");
                                $('<small class="text-danger">حداکثر مقدار تبادل این کوین ' + data.msg + ' است</small>').insertAfter($("#amount").parent());
                                $("#exchangebtn").prop("disabled", true);
                            } else if (data.min) {
                                $("#cointarget").html("");
                                $("#loader").hide();
                                $("#amount").parent().parent().find('.text-danger').remove();
                                $("#amount").addClass("is-invalid");
                                $('<small class="text-danger">حداقل مقدار تبادل این کوین ' + data.msg + ' است</small>').insertAfter($("#amount").parent());
                                $("#exchangebtn").prop("disabled", false);
                            } else {
                                $("#cointarget").html("<p style='font-size: 0.8rem' class='text-warning'><i class='ft-alert-triangle mx-1'></i> مقدار وارد شده ارزش تبادل ندارد</p>");
                                setTimeout(function () {
                                    $("#amount").parent().parent().find('.text-danger').remove();
                                    $("#amount").removeClass("is-invalid");
                                    $("#exchangebtn").prop("disabled", false);
                                }, 2000);
                            }
                        }
                    },
                    async: true
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
});
        </script>
    </body>
</html>