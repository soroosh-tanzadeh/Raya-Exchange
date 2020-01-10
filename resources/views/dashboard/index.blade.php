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
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <div>
                                <h5 class="box-title mb-2"><i class="ft-bar-chart-2"></i> نمودار نوسانات ارزی</h5>
                            </div><a class="text-muted" href="#"><i class="ti-more-alt"></i></a>
                        </div>
                        <div id="crypto_axes" style="height:300px;"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="box-title mb-4"><i class="ft-zap"></i> خرید و فروش سریع </h5>
                                <ul class="nav nav-pills justify-content-center nav-justified mb-5">
                                    <li class="nav-item"><a class="nav-link active show" data-toggle="pill" href="#tab-sell">فروش کوین</a></li>
                                </ul>
                                <ul class="nav line-tabs nav-justified line-tabs-2x line-tabs-solid mb-5">
                                    <li class="nav-item dcurrency-select"><a class="nav-link text-center active show" data-toggle="tab" href="#tab-1" data-coin="bitcoin" data-price="{{ $coins['bitcoin']->price_in_toman_int }}"><i class="cc BTC-alt font-26 text-warning mb-2"></i></a></li>
                                    <li class="nav-item dcurrency-select"><a class="nav-link text-center" data-toggle="tab" href="#tab-2" data-coin="ethereum" data-price="{{ $coins['litecoin']->price_in_toman_int }}"><i class="cc ETC font-26 text-primary mb-2"></i></a></li>
                                    <li class="nav-item dcurrency-select"><a class="nav-link text-center" data-toggle="tab" href="#tab-2" data-coin="litecoin" data-price="{{ $coins['ethereum']->price_in_toman_int }}"><i class="cc LTC-alt font-26 text-secondary mb-2"></i></a></li>
                                    <li class="nav-item dcurrency-select"><a class="nav-link text-center" data-toggle="tab" href="#tab-2" data-coin="ripple" data-price="{{ $coins['ripple']->price_in_toman_int }}"><i class="cc XRP-alt font-26 text-primary mb-2"></i></a></li>
                                </ul>
                                <h5 class="mb-3 mt-4">مقدار مورد نظر :</h5>
                                <form action="/dashboard/newoffer" method="POST">
                                    @csrf
                                    <div class="form-group mb-5">
                                        <input type="hidden" id="coin-type" value="bitcoin" name="coin"/> 
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="input-group-icon input-group-icon-right"><input class="form-control" type="text" name="coinـnum" id="coin-num" placeholder="0.000000"><span class="input-icon input-icon-right"><i class="cc BCN-alt text-warning font-13"></i></span></div>
                                            </div>
                                            <div class="d-inline-flex justify-content-center align-items-center" style="width: 60px"><i class="fas fa-exchange-alt text-muted font-16"></i></div>
                                            <div class="col">
                                                <div class="input-group-icon input-group-icon-right"><input class="form-control" type="text" placeholder="قیمت به تومان" id="price-toman"><span class="input-icon input-icon-right">تومان</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center"><button class="btn btn-danger btn-rounded" type="submit" style="min-width: 200px">تکمیل سفارش</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-fullheight">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-5">
                                    <h5 class="box-title mb-0"><i class="ft-activity"></i> آخرین فعالیت های شما </h5>
                                </div>
                                <ul class="timeline timeline-default outline-points timeline-danger">
                                    <li class="timeline-item">ورود به حساب کاربری<span class="font-13 text-muted ml-2">همین الان</span></li>
                                    <li class="timeline-item">بازیابی رمز عبور<span class="font-13 text-muted ml-2">5 دقیقه پیش</span></li>
                                    <li class="timeline-item">تغییر رمز عبور<span class="font-13 text-muted ml-2">۲ ساعت پیش</span></li>
                                    <li class="timeline-item">ورود به حساب کاربری<span class="font-13 text-muted ml-2">دو روز پیش</span></li>
                                    <li class="timeline-item">تکمیل اطلاعات شخصی<span class="font-13 text-muted ml-2">یک ماه پیش</span></li>
                                    <li class="timeline-item">ثبت نام در سامانه<span class="font-13 text-muted ml-2">۳ ماه پیش</span></li>
                                </ul>
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
<script>
    $(document).ready(function () {
    if ($('#crypto_axes').length) {
    var oilprices = [
    {{ $chart }}
    ];
            function euroFormatter(v, axis) {
            return v.toFixed(axis.tickDecimals) + "в‚¬";
            }

    function doPlot(position) {
    $.plot("#crypto_axes", [{
    data: oilprices,
            label: "Bitcoin price ($)"
    },
    ], {
    xaxes: [{
    mode: "time"
    }],
            yaxes: [{
            min: 0
            }, {
            // align if we are to the right
            alignTicksWithAxis: position == "right" ? 1 : null,
                    position: position,
                    tickFormatter: euroFormatter
            }],
            colors: [theme_color('primary'), theme_color('warning')],
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
            },
                    points: {
                    //show: !0
                    },
            },
            legend: {
            position: "sw"
            },
            tooltip: {
            show: true,
                    content: "%s for %x was %y",
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