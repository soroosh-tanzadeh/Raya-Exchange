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
        <title>Raya-EX | خرید ارز دیجیتال</title>
    </head>
    <body>
        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading"> 
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">خرید و فروش ارز</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="la la-home font-20"></i></a></li>
                        <li class="breadcrumb-item">خرید پیشنهاد جدید</li>
                    </ol>
                </div>
            </div><!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="d-flex"><i class="cc BCN mr-3 font-40 text-warning" title="BCN" style="line-height: 1"></i>
                                        <div>
                                            <h5 class="font-18 mb-2 font-weight-normal">BTC</h5>
                                            <div class="text-muted">بیت کوین</div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="h3 mb-2">{{ $coins['bitcoin']->price_in_toman }}</div>
                                        @if($coins['bitcoin']->changePercent24Hr < 0)
                                        <div class="text-danger change text-right"> <i class="ti-arrow-down mx-2"></i>{{ number_format(round($coins['bitcoin']->changePercent24Hr,2),2) }}%</div>
                                        @else
                                        <div  class="text-success change text-right"><i class="ti-arrow-up mx-2"></i>{{ round($coins['bitcoin']->changePercent24Hr,2) }}%</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-fullwidth-block" style="margin-bottom: -1.8rem"><canvas id="crypto_chart_1" style="height:100px;"></canvas></div>  
                            </div>
                            <div class="card-footer p-1">
                                <div class="w-100 d-flex justify-content-between">
                                    <a class="btn btn-primary" href="/dashboard/buyoffer">ایجاد پیشنهاد جدید</a>
                                    <a class="btn btn-secondary" href="/dashboard/exchange">تبادل</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="d-flex"><i class="cc ETC-alt mr-3 font-40 text-primary" title="ETC" style="line-height: 1"></i>
                                        <div>
                                            <h5 class="font-18 mb-2 font-weight-normal">ETC</h5>
                                            <div class="text-muted">اتریم</div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="h3 mb-2">{{ $coins['ethereum']->price_in_toman }}</div>
                                        @if($coins['ethereum']->changePercent24Hr < 0)
                                        <div class="text-danger change text-right"> <i class="ti-arrow-down mx-2"></i>{{ number_format(round($coins['ethereum']->changePercent24Hr,2),2) }}%</div>
                                        @else
                                        <div  class="text-success change text-right"><i class="ti-arrow-up mx-2"></i>{{ round($coins['ethereum']->changePercent24Hr,2) }}%</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-fullwidth-block" style="margin-bottom: -1.8rem"><canvas id="crypto_chart_2" style="height:100px;"></canvas></div>
                            </div>
                            <div class="card-footer p-1">
                                <div class="w-100 d-flex justify-content-between">
                                    <a class="btn btn-primary" href="/dashboard/buyoffer">ایجاد پیشنهاد جدید</a>
                                    <a class="btn btn-secondary" href="/dashboard/exchange">تبادل</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="d-flex"><i class="cc LTC mr-3 font-40 text-secondary" title="LTC" style="line-height: 1"></i>
                                        <div>
                                            <h5 class="font-18 mb-2 font-weight-normal">LTC</h5>
                                            <div class="text-muted">لایت کوین</div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="h3 mb-2">{{ $coins['litecoin']->price_in_toman }}</div>
                                        @if($coins['litecoin']->changePercent24Hr < 0)
                                        <div class="text-danger change text-right"> <i class="ti-arrow-down mx-2"></i>{{ number_format(round($coins['litecoin']->changePercent24Hr,2),2) }}%</div>
                                        @else
                                        <div  class="text-success change text-right"><i class="ti-arrow-up mx-2"></i>{{ round($coins['litecoin']->changePercent24Hr,2) }}%</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-fullwidth-block" style="margin-bottom: -1.8rem"><canvas id="crypto_chart_3" style="height:100px;"></canvas></div>
                            </div>
                            <div class="card-footer p-1">
                                <div class="w-100 d-flex justify-content-between">
                                    <a class="btn btn-primary" href="/dashboard/buyoffer">ایجاد پیشنهاد جدید</a>
                                    <a class="btn btn-secondary" href="/dashboard/exchange">تبادل</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header p-0">
                                <ul class="nav line-tabs nav-justified line-tabs-2x line-tabs-solid w-100">
                                    <li class="nav-item"><a data-toggle="tab" href="#menu1" class="nav-link w-100 justify-content-center active show" style="border-top-right-radius: 0.6rem;">فروشندگان</a></li>
                                    <li class="nav-item"><a data-toggle="tab" href="#menu2" class="nav-link w-100 justify-content-center" style="border-top-left-radius: 0.6rem;">خریداران</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div id="menu1" class="tab-pane fade active show">
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
                                                    <a class="nav-link d-flex align-items-center justify-content-center loadcoinoffers px-1 h-100" data-offer="sell" data-coin="more" data-toggle="tab" role="tab"  aria-selected="false">سایر <i class="mx-2 ti-more font-20 text-muted"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="table-responsive font-11 my-2">
                                            <div class="table-responsive font-11">
                                                <table class="table table-hover compact-table w-100" id="buyofferstable">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>نام کاربری</th>
                                                            <th>ارز</th>
                                                            <th>موجودی</th>
                                                            <th>حداقل خرید</th>
                                                            <th>قیمت واحد (تومان)</th>
                                                            <th>تاریخ</th>
                                                            <th>خرید</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="menu2" class="tab-pane">
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
                                        <div class="table-responsive font-11 my-2">
                                            <div class="table-responsive font-11">
                                                <div class="table-responsive font-11">
                                                    <table class="table table-hover compact-table w-100" id="sellofferstable">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>نام کاربری</th>
                                                                <th>ارز</th>
                                                                <th>موجودی</th>
                                                                <th>حداقل فروش</th>
                                                                <th>قیمت واحد (تومان)</th>
                                                                <th>تاریخ</th>
                                                                <th>فروش</th>
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
            </div>
        </div><!-- BEGIN: Footer-->

        @include("includes.footer") 
        <script src="/assets/js/offerslist.js"></script>
        <script>
var bitcoin = {!! $chart['bitcoin'] !!}
;
        var litecoin = {!! $chart['litecoin'] !!}
;
        var ethereum = {!! $chart['ethereum'] !!}
;
        </script>

        <script>
            initCryptoAreaCharts('crypto_chart_1', bitcoin, theme_color('warning'));
            initCryptoAreaCharts('crypto_chart_2', ethereum, theme_color('primary'));
            initCryptoAreaCharts('crypto_chart_3', litecoin, theme_color('dark'));

        </script>
    </body>
</html>