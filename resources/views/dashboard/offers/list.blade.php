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
                                        <div class="table-responsive font-11">
                                            <div class="table-responsive font-11">
                                                <table class="table table-hover compact-table">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>نام کاربری</th>
                                                            <th>ارز</th>
                                                            <th>موجودی</th>
                                                            <th>حداقل خرید</th>
                                                            <th>واحد (تومان)</th>
                                                            <th>تاریخ</th>
                                                            <th>خرید</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($offers as $offer)
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
                                                            <td><a  data-toggle="tooltip" title="" data-original-title="خرید" data-min="{{ $offer->min_buy }}" data-max="{{ $offer->amount }}" data-offer="{{ $offer->id }}" data-coin="{{ $offer->price_pre }}" data-price="{{ $offer->price_pre}}" class="text-success buycoin font-18"><i class="ft-shopping-cart"></i></a></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            {{ $offers->links() }}
                                        </div>
                                    </div>
                                    <div id="menu2" class="tab-pane">
                                        <div class="table-responsive font-11">
                                            <div class="table-responsive font-11">
                                                <div class="table-responsive font-11">
                                                    <table class="table table-hover compact-table">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>نام کاربری</th>
                                                                <th>ارز</th>
                                                                <th>موجودی</th>
                                                                <th>حداقل فروش</th>
                                                                <th>واحد (تومان)</th>
                                                                <th>تاریخ</th>
                                                                <th>فروش</th>
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
                                                                <td><a data-toggle="tooltip" title="" data-original-title="فروش" data-min="{{ $buyoffer->min_buy }}" data-max="{{ $buyoffer->amount }}" data-offer="{{ $buyoffer->id }}" data-coin="{{ $buyoffer->price_pre }}" data-price="{{ $buyoffer->price_pre}}" class="text-success sellcoin font-18"><i class="ft-thumbs-up"></i></a></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="w-100 text-center">
                                                    {{ $offers->links() }}
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
        <script>
            var bitcoin = {{ $chart['bitcoin'] }};
            var litecoin = {{ $chart['litecoin'] }};
            var ethereum = {{ $chart['ethereum'] }};
        </script>

        <script>
            initCryptoAreaCharts('crypto_chart_1', bitcoin, theme_color('warning'));
            initCryptoAreaCharts('crypto_chart_2', ethereum, theme_color('primary'));
            initCryptoAreaCharts('crypto_chart_3', litecoin, theme_color('dark'));

        </script>
    </body>
</html>