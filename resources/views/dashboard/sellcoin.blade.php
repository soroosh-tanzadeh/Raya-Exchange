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
        <title>Raya-EX | پیشنهاد شماره {{ $offer->id }}</title><!-- GLOBAL VENDORS-->
    </head>
    <body>
        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading"> 
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">خرید از دیجیتال</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="la la-home font-20"></i></a></li>
                    </ol>
                </div>
            </div><!-- BEGIN: Page content-->
            @include("includes.alert")
            <div>
                <div class="card">
                    <div class="card-body invoice px-sm-5">
                        <form method="GET" action="/buycoin">
                            <div class="clearfix">
                                <input type="hidden" name="offer_id" value="{{ $offer->id }}" />
                                <div class="row">
                                    <div class="col-md-6">
                                        <h1 class="text-muted font-20 mb-3">پیشنهاد شماره {{ $offer->id }}</h1>
                                        <label for="amount">مقدار فروش</label>
                                        <input type="number" style="width: 60%" placeholder="مقدار فروش خود را وارد کنید" step="0.00000001" required max="{{ $offer->amount }}" data-price="{{ $offer->price_pre }}" data-max="{{ $offer->max_buy }}" min="{{ $offer->min_buy }}" class="form-control" id="amount" name="amount" value="0" />
                                    </div>
                                    <div class="col-md-6 text-left text-sm-right">
                                        <h2 class="text-danger mb-3"></h2>
                                        <div class="font-15 text-muted">
                                            <div><b>قیمت</b> : {{ $offer->amount }}</div>
                                            <div><b>مبلغ دریافتی</b> : {{ number_format($offer->price_pre) }} تومان</div>
                                            <input type="submit" class="btn btn-primary float-left" value="فروش" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div><!-- BEGIN: Footer-->

        @include("includes.footer")

        <script>
            var variables = {
            fee: {{ $fee }}
            }
        </script>

        <script src="/assets/js/invoice.js"></script>
    </body>
</html>