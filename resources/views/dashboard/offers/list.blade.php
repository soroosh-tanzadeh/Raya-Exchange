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
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-4">
                                    <div>
                                        <h5 class="box-title mb-2"><i class="ft-bar-chart-2"></i> Bitcoin</h5>
                                    </div><a class="text-muted" href="#"><i class="ti-more-alt"></i></a>
                                </div>
                                <div id="crypto_axes" style="height:300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-4">
                                    <div>
                                        <h5 class="box-title mb-2"><i class="ft-bar-chart-2"></i> Litecoin</h5>
                                    </div><a class="text-muted" href="#"><i class="ti-more-alt"></i></a>
                                </div>
                                <div id="crypto_litecoin" style="height:300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-4">
                                    <div>
                                        <h5 class="box-title mb-2"><i class="ft-bar-chart-2"></i> Ripple</h5>
                                    </div><a class="text-muted" href="#"><i class="ti-more-alt"></i></a>
                                </div>
                                <div id="crypto_ripple" style="height:300px;"></div>
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
                                                            <th>#</th>
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
                                                                <th>#</th>
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
            $(document).ready(function () {
            if ($('#crypto_axes').length) {
            var bitcoin = [
            {{ $chart['bitcoin'] }}
            ];
            var litecoin = [
            {{ $chart['litecoin'] }}
            ];
            var ripple = [
            {{ $chart['ripple'] }}
            ];
            function euroFormatter(v, axis) {
            return v.toFixed(axis.tickDecimals) + "в‚¬";
            }

            function doPlot(position) {
            $.plot("#crypto_axes", [{
            data: litecoin,
                    label: "Bitcoin"
            }], {
            xaxes: [{
            mode: "time"
            }],
                    yaxes: [{
                    min: 0
                    }],
                    colors: [theme_color('warning')],
                    grid: {
                    color: "#999999",
                            hoverable: true,
                            clickable: true,
                            tickColor: "#DADDE0",
                            borderWidth: 0,
                    },
                    series: {
                    lines: {
                    show: true,
                            fillColor: {
                            colors: [{
                            opacity: 0.1
                            }, {
                            opacity: 0.1
                            }]
                            }
                    }
                    },
                    legend: {
                    position: "sw"
                    },
                    tooltip: {
                    show: true,
                            content: "قیمت %s در%x, %y تومان بوده",
                    }
            });
            ///////////////////////////
            $.plot("#crypto_ripple", [{
            data: ripple,
                    label: "Ripple"
            }], {
            xaxes: [{
            mode: "time"
            }],
                    yaxes: [{
                    min: 0
                    }],
                    colors: ["red"],
                    grid: {
                    color: "#999999",
                            hoverable: true,
                            clickable: true,
                            tickColor: "#DADDE0",
                            borderWidth: 0,
                    },
                    series: {
                    lines: {
                    show: true,
                            fillColor: {
                            colors: [{
                            opacity: 0.1
                            }, {
                            opacity: 0.1
                            }]
                            }
                    }
                    },
                    legend: {
                    position: "sw"
                    },
                    tooltip: {
                    show: true,
                            content: "قیمت %s در%x, %y تومان بوده",
                    }
            });
            ///////////////////////////
            $.plot("#crypto_litecoin", [{
            data: bitcoin,
                    label: "Litecoin"
            }], {
            xaxes: [{
            mode: "time"
            }],
                    yaxes: [{
                    min: 0
                    }],
                    colors: ["#666"],
                    grid: {
                    color: "#999999",
                            hoverable: true,
                            clickable: true,
                            tickColor: "#DADDE0",
                            borderWidth: 0,
                    },
                    series: {
                    lines: {
                    show: true,
                            fillColor: {
                            colors: [{
                            opacity: 0.1
                            }, {
                            opacity: 0.1
                            }]
                            }
                    }
                    },
                    legend: {
                    position: "sw"
                    },
                    tooltip: {
                    show: true,
                            content: "قیمت %s در%x, %y تومان بوده",
                    }
            });
            }
            doPlot("right");
            }
            }
            );
        </script>
    </body>
</html>