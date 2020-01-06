<!DOCTYPE html>
<!--
Copyright (C) 2020 Soroosh Tanzadeh

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
<html lang="en">
    <head>
        @include("includes.head")
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
                        <li class="breadcrumb-item">ثبت پیشنهاد فروش</li>
                    </ol>
                </div>
            </div><!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-2"><i class="cc BTC-alt font-40 text-warning"></i></div>
                                <div class="mb-3 text-muted font-16">بیت کوین</div>
                                <div class="h5 font-20"><span>{{ $coins['bitcoin']->priceUsd }}</span><span class="font-weight-normal">$</span></div>
                                <div class="font-16">{{ $coins['bitcoin']->price_in_toman }}</div>
                                <hr>
                                <div class="flexbox"><a href="#">خرید</a><a class="text-warning" href="#">فروش</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-2"><i class="cc ETC font-40 text-primary"></i></div>
                                <div class="mb-3 text-muted font-16">اتریم</div>
                                <div class="h5 font-20"><span>{{ $coins['ethereum']->priceUsd }}</span><span class="font-weight-normal">$</span></div>
                                <div class="font-16">{{ $coins['ethereum']->price_in_toman }}</div>
                                <hr>
                                <div class="flexbox"><a href="#">خرید</a><a class="text-warning" href="#">فروش</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-2"><i class="cc LTC-alt font-40 text-secondary"></i></div>
                                <div class="mb-3 text-muted font-16">لایت کوین</div>
                                <div class="h5 font-20"><span>{{ $coins['litecoin']->priceUsd }}</span><span class="font-weight-normal">$</span></div>
                                <div class="font-16">{{ $coins['litecoin']->price_in_toman }}</div>
                                <hr>
                                <div class="flexbox"><a href="#">خرید</a><a class="text-warning" href="#">فروش</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-2"><i class="cc XRP-alt font-40 text-danger"></i></div>
                                <div class="mb-3 text-muted font-16">ریپل</div>
                                <div class="h5 font-20"><span>{{ $coins['ripple']->priceUsd }}</span><span class="font-weight-normal">$</span></div>
                                <div class="font-16">{{ $coins['ripple']->price_in_toman }}</div>
                                <hr>
                                <div class="flexbox"><a href="#">خرید</a><a class="text-warning" href="#">فروش</a></div>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-4">
                                    <div>
                                        <h5 class="box-title mb-2"><i class="ft-download"></i> آخرین فروشندگان </h5>
                                    </div>
                                </div>

                                <div class="table-responsive font-11">
                                    <table class="table table-hover compact-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>نام کاربری</th>
                                                <th>ارز</th>
                                                <th>مقدار</th>
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
                                                <td><?php
                                                    $priceInToman = $coins[$offer->coin]->price_in_toman_int * $offer->amount;
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
                                                <td><a href="/buycoin?offer_id={{ $offer->id }}" class="btn btn-outline-primary">خرید</a></td>
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