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

<?php

use App\Wallet;

$wcoins = Wallet::getCoins();
?>

<html lang="en">
    <head>
        @include("includes.head")
        <title>Raya-EX | پیشنهاد جدید</title><!-- GLOBAL VENDORS-->
    </head>
    <body>
        <div class="modal fade" id="paymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">شارژ کیف‌پول ریالی</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/payir/pay" method="GET">
                            <label>مبلغ شارژ (تومان)</label>
                            <input type="number" name="amount" class="form-control" value="" style="width: 100%;margin-bottom: 10px;" placeholder="مبلغ مورد نظر خود را وارد کنید" />
                            <input class="btn btn-primary" type="submit" value="پرداخت" />
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading"> 
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">خرید و فروش ارز</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="la la-home font-20"></i></a></li>
                        <li class="breadcrumb-item">ثبت پیشنهاد فروش</li>
                    </ol>
                </div>
            </div><!-- BEGIN: Page content-->
            @include("includes.alert")

            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-fullheight">
                            <!-- TradingView Widget BEGIN -->
                            <div class="card-header">
                                <h4 class="mb-0"><i class="ft-trending-up"></i> نمودار نوسانات قیمت بیت‌کوین</h4>
                            </div>
                            <div class="card-body">
                                <!-- TradingView Widget BEGIN -->
                                <div class="tradingview-widget-container">
                                    <div id="tradingview_f7b3f" style="height: 600px"></div>
                                    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                                    <script type="text/javascript">
                                        new TradingView.widget(
                                                {
                                                    "autosize": true,
                                                    "symbol": "BITSTAMP:BTCUSD",
                                                    "interval": "240",
                                                    "timezone": "Asia/Tehran",
                                                    "theme": "Dark",
                                                    "style": "1",
                                                    "locale": "en",
                                                    "toolbar_bg": "#f1f3f6",
                                                    "enable_publishing": false,
                                                    "withdateranges": true,
                                                    "hide_side_toolbar": false,
                                                    "allow_symbol_change": true,
                                                    "studies": [
                                                        "MACD@tv-basicstudies",
                                                        "MASimple@tv-basicstudies",
                                                        "RSI@tv-basicstudies",
                                                        "Volume@tv-basicstudies"
                                                    ],
                                                    "container_id": "tradingview_f7b3f"
                                                }
                                        );
                                    </script>
                                </div>
                                <!-- TradingView Widget END -->
                                <!-- TradingView Widget END -->
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @include("includes.offerCard")
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="box-title"><i class="ft-download"></i> آخرین پیشنهادات من</h5>
                                    </div>
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
                                                <th>عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($offers as $offer)
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
                                                    <input type="button" class="btn btn-danger canceloffer" value="لغو پیشنهاد" />
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $offers->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- BEGIN: Footer-->

        @include("includes.footer") 
        <script src="/assets/js/offers.js"></script>
        {!! $toRun !!}
    </body>
</html>