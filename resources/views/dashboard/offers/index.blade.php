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
<html lang="en">
    <head>
        @include("includes.head")
        <link href="/assets/css/pages/form-wizard.css" rel="stylesheet" />
        <link href="/assets/vendors/feather-icons/feather.css" rel="stylesheet" />
        <link href="/assets/vendors/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
        <link href="/assets/vendors/themify-icons/themify-icons.css" rel="stylesheet" />
        <link href="/assets/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" />
        <link href="/assets/vendors/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" /><!-- PAGE LEVEL VENDORS-->
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
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-fullheight">
                            <!-- TradingView Widget BEGIN -->

                            <div class="card-header">
                                <h4>ایجاد پیشنهاد جدید</h4>
                            </div>
                            <div class="card-body">


                                <div class="tab-content">
                                    <div id="bitcoin" class="tab-pane fade active show">
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

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
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
                                        <h5 class="mb-3 mt-4">مقدار مورد نظر :</h5>
                                        <form action="/dashboard/newoffer" method="POST">
                                            @csrf
                                            <input type="hidden"  value="sell" name="type"/>
                                            <div class="form-group mb-5">
                                                <select required name="coin" class="form-control coins_select" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach($offerablecoins as $offerablecoin)
                                                    @if(isset($coins[strtolower($offerablecoin->name)]))
                                                    <option value="{{ strtolower($offerablecoin->name) }}" data-price="{{ $coins[strtolower($offerablecoin->name)]->price_in_toman_int }}" data-icon="{{ url("/assets/icons/".strtolower($offerablecoin->type_name).".png") }}">{{ $offerablecoin->name }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <div class="form-row mt-1">
                                                    <div class="col">
                                                        <div class="input-group-icon input-group-icon-right">
                                                            <input class="form-control" type="text" name="coinـnum" required id="coin-num" placeholder="مقدار">
                                                            <span class="input-icon input-icon-right coinicon"></span></div>
                                                        <input class="form-control mt-1" type="text" name="mincoin" required placeholder="حداقل سفارش">

                                                    </div>
                                                    <div class="d-inline-flex justify-content-center align-items-center" style="width: 60px"><i class="fas fa-exchange-alt text-muted font-16"></i></div>
                                                    <div class="col d-flex justify-content-center flex-column">
                                                        <div class="input-group-icon input-group-icon-right w-100 my-2">
                                                            <input class="form-control" type="text" placeholder="قیمت به تومان" required name="price_toman" id="price-toman"><span class="input-icon input-icon-right">تومان</span>
                                                        </div>
                                                        <div class="bg-warning text-white text-center rounded p-2 my-2">
                                                            مبلغی که شما از فروش این مقدار ارز دیجیتال دریافت می‌کنید
                                                            <p class="text-center" id="totalsellprice">
                                                                مبلغ را وارد کنید
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-8">
                                                    <ul type="disc">
                                                        <li>قیمت پیشنهادی ما همیشه با توجه نوسانات قیمت جهانی ارزهای دیجیتال و با نسبت ثابت تغییر خواهد کرد</li>
                                                        <li>قیمت پیشنهادی ما همیشه ۲٪ بیشتر از قیمت چهانی ارز انتخابی خواهد بود.</li>
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
                                        <h5 class="mb-3 mt-4">مقدار مورد نظر :</h5>
                                        <form action="/dashboard/newoffer" method="POST">
                                            @csrf
                                            <input type="hidden"  value="buy" name="type"/>
                                            <div class="form-group mb-5">
                                                <select required name="coin" class="form-control coins_select" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach($offerablecoins as $offerablecoin)
                                                    @if(isset($coins[strtolower($offerablecoin->name)]))
                                                    <option value="{{ strtolower($offerablecoin->name) }}" data-price="{{ $coins[strtolower($offerablecoin->name)]->price_in_toman_int }}" data-icon="{{ url("/assets/icons/".strtolower($offerablecoin->type_name).".png") }}">{{ $offerablecoin->name }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <div class="form-row mt-1">
                                                    <div class="col">
                                                        <div class="input-group-icon input-group-icon-right">
                                                            <input class="form-control" type="text" name="coinـnum" required id="coinbuy-num" placeholder="مقدار">
                                                            <span class="input-icon input-icon-right coinicon"></span></div>
                                                        <input class="form-control mt-1" type="text" name="mincoin" required placeholder="حداقل سفارش">

                                                    </div>
                                                    <div class="d-inline-flex justify-content-center align-items-center" style="width: 60px"><i class="fas fa-exchange-alt text-muted font-16"></i></div>
                                                    <div class="col d-flex justify-content-center flex-column">
                                                        <div class="input-group-icon input-group-icon-right w-100 my-2">
                                                            <input class="form-control" type="text" placeholder="قیمت به تومان" required name="price_toman" id="pricebuy-toman"><span class="input-icon input-icon-right">تومان</span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-8">
                                                    <ul type="disc">
                                                        <li>قیمت پیشنهادی ما همیشه با توجه نوسانات قیمت جهانی ارزهای دیجیتال و با نسبت ثابت تغییر خواهد کرد</li>
                                                        <li>قیمت پیشنهادی ما همیشه ۲٪ کمتر از قیمت چهانی ارز انتخابی خواهد بود.</li>
                                                    </ul>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <button class="btn btn-danger btn-rounded" type="submit" style="min-width: 200px">تکمیل سفارش</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
                                        <h5 class="box-title mb-2"><i class="ft-download"></i> آخرین پیشنهادات من</h5>
                                    </div>
                                </div>

                                <div class="table-responsive font-11">
                                    <table class="table table-hover compact-table">
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
                                                    <input type="button" class="btn btn-danger" value="لغو پیشنهاد" />
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
    </body>
</html>