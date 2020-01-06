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
        <link href="/assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" /><!-- THEME STYLES-->

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
                    <div class="col-md-12">
                        <div class="card card-fullheight">
                            <div class="card-body">
                                <form action="javascript:;">
                                    <div class="form-group mb-4">
                                        <h4 class="col-form-label px-3">یک کوین را انتخاب کنید</h4>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <select class="form-control select2_demo mx-3" required id="from_coin" style="width: 40%">
                                                <option></option>
                                                @foreach($currencies as $currency)
                                                <option value="{{ $currency->symbol }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>

                                            <div class="d-inline-flex justify-content-center align-items-center mx-3" style="width: 60px"><i class="fas fa-exchange-alt text-muted font-16"></i></div>

                                            <select class="form-control" id="to_coin" required style="width: 40%">
                                                <option></option>
                                                @foreach($currencies as $currency)
                                                <option value="{{ $currency->symbol }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <h5 class="mb-3 mt-4">مقدار</h5>
                                    <div class="form-group mb-5">
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="input-group-icon input-group-icon-right"><input class="form-control" id="amount" type="text" required placeholder="0.01023000"><span class="input-icon input-icon-right"><i class="cc BCN-alt text-warning font-13"></i></span></div>
                                            </div>
                                            <div class="d-inline-flex justify-content-center align-items-center" style="width: 60px"><i class="fas fa-exchange-alt text-muted font-16"></i></div>
                                            <div class="col">
                                                <div class="input-group">
                                                    <input class="form-control" id="target-coin"  readonly type="text" placeholder="Loading">
                                                </div>
                                            </div>
                                        </div>

                                        <label class="mt-4">آدرس والت</label>
                                        <input class="form-control" type="text" id="walletAddress" required placeholder="آدرس کیف پول مقصد را وارد کنید">
                                    </div>
                                    <div class="text-center"><button class="btn btn-danger btn-rounded" id="exchangebtn" type="submit" style="min-width: 200px">تبادل</button></div>
                                </form>
                                <div class="text-center mt-4" id="msg">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- BEGIN: Footer-->

        @include("includes.footer") 
        <script src="/assets/vendors/select2/dist/js/select2.full.min.js"></script><!-- CORE SCRIPTS-->

        <script>
$("#from_coin").select2({
    placeholder: "یک گزینه را انتخاب کنید",
});
$("#to_coin").select2({
    placeholder: "یک گزینه را انتخاب کنید",
});

$(document).ready(function () {
    $("#from_coin,#to_coin").change(function () {
        var from_coin = $("#from_coin").val();
        var to_coin = $("#to_coin").val();
        var amount = $("#amount").val();
        $.get("/get_estimate?from=" + from_coin + "&to=" + to_coin + "&amount=" + amount, {}, function (data) {
            $("#target-coin").val(data);
        });
    })
    $("#amount").on("input", function () {
        var from_coin = $("#from_coin").val();
        var to_coin = $("#to_coin").val();
        var amount = $("#amount").val();
        $.get("/get_estimate?from=" + from_coin + "&to=" + to_coin + "&amount=" + amount, {}, function (data) {
            $("#target-coin").val(data);
        });
    })
    $("#exchangebtn").click(function () {
        var from_coin = $("#from_coin").val();
        var to_coin = $("#to_coin").val();
        var amount = $("#amount").val();
        var wallet = $("#walletAddress").val();
        $(this).prop("disabled", true);
        $.post("/exchange", {_token: $("meta[name='csrf-token']").attr("content"), from: from_coin, to: to_coin, amount: amount, wallet: wallet}, function (data) {
            if (data.address_from) {
                $("#msg").html("مقدار " + amount + from_coin + " " + "به این کیف پول واریز کنید تا تبادل ارز دیجیتال انجام شود" + "<br>" + data.address_from);
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