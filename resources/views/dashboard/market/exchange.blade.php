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
        <title>Raya-EX | تبادل ارز دیجیتال</title>
        <style>
            #walletAddressInput{
                width: calc(50% - 37px);
            }

            @media (max-width: 760px){
                #walletAddressInput{
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>
        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading"> 
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">تبادل ارز دیجیتال</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="la la-home font-20"></i></a></li>
                        <li class="breadcrumb-item">معاملات ارزی</li>
                    </ol>
                </div>
            </div><!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-fullheight">
                            <div class="card-body">
                                <div id="paybox" style="display: none">
                                    <div class="text-center my-3">
                                        جهت دریافت <span id="targetamount"></span> دقیقا به مقدار <span id="amoutcoin"></span> به والت زیر واریز کنید
                                        <br>
                                        <b class="text-warning">  پس از انجام پرداخت صفحه‌ را رفرش کنید.</b>
                                    </div>
                                    <div class="d-flex w-100 flex-column justify-content-center  align-items-center">
                                        <div id="walletqrcode"> </div>
                                        <div id="walletAddress" class="my-3"></div>
                                    </div>
                                    <span> ارز مورد نظر را به آدرس مشخص شده ارسال نماید</span>
                                    <div class="float-left">
                                        مهلت واریز
                                        <div class="counter">
                                            <span id="minute">20</span> : <span id="sec">0</span>
                                        </div>
                                    </div>
                                </div>
                                <form action="javascript:;" id="exchangebox">
                                    <div class="form-group mb-5">
                                        <div class="form-row">
                                            <div class="col-lg my-2">
                                                <div class="input-group">
                                                    <input class="form-control" id="amount" type="text" required placeholder="0.01023000" style="width: 50%;height: 45px">
                                                    <div style="width: 50%">
                                                        <select class="form-control mx-3" required id="from_coin">
                                                            <option value="" data-icon="/assets/icons/raya"></option>
                                                            @foreach($currencies as $currency)
                                                            <option value="{{ $currency->symbol }}" data-icon="https://simpleswap.io{{ $currency->image }}">{{ $currency->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-lg-inline-flex d-none justify-content-center align-items-center" style="width: 60px"><i class="fas fa-arrow-left text-muted font-16"></i></div>
                                            <div class="col-lg my-2">
                                                <div class="input-group">  
                                                    <input class="form-control" id="target-coin" readonly type="text" placeholder="0" style="width: 50%;height: 45px">
                                                    <div style="width: 50%">
                                                        <select class="form-control" id="to_coin" required style="width: 50%">
                                                            <option value="" data-icon="/assets/icons/raya"></option>
                                                            @foreach($currencies as $currency)
                                                            <option value="{{ $currency->symbol }}" data-icon="https://simpleswap.io{{ $currency->image }}">{{ $currency->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        <label class="mt-4">آدرس والت</label>
                                        <input class="form-control" type="text" id="walletAddressInput" required placeholder="آدرس کیف پول مقصد را وارد کنید">
                                    </div>
                                    <div>
                                        <ul style="list-style: decimal">
                                            <li>ارز مورد نظر را برای مبادله انتخاب کنید</li>
                                            <li>نرخ تبدیل ارز را بررسی کنید</li>
                                            <li>ارز را کمتر از حد مشخص شده ارسال نکنید</li>
                                            <li>آدرس کیف پول را جهت دریافت ارز مورد نظر وارد کنید</li>
                                        </ul>
                                    </div>
                                </form>

                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button class="btn btn-danger btn-rounded" id="exchangebtn" type="submit" style="min-width: 200px">تبادل</button>
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
                                        <h5 class="box-title mb-2"><i class="ft-download"></i> تاریخچه تبادلات</h5>
                                    </div>
                                </div>
                                @if(count($exchanges) > 0)
                                <div class="table-responsive font-11">
                                    <table class="table table-hover compact-table">
                                        <thead class="thead-light">
                                            <tr>  
                                                <th>شناسه تبادل</th>
                                                <th>از ارز</th>
                                                <th>به ارز</th>
                                                <th>مقدار</th>
                                                <th>به کیف‌پول</th>
                                                <th>آدرس انتقال</th>
                                                <th>وضعیت</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($exchanges as $exchange)
                                            <tr>
                                                <td>{{ $exchange->exchange_id }}</td>
                                                <td>{{ $exchange->from }}</td>
                                                <td>{{ $exchange->to }}</td>
                                                <td>{{ $exchange->amount }} {{ $exchange->from }}</td>
                                                <td>{{ $exchange->to_address }}</td>
                                                <td>{{ $exchange->payment_address }}</td>
                                                <td>
                                                    @if($exchange->status === 0)
                                                    <text class="text-warning">در انتظار ارسال ارز</text>
                                                    @elseif($exchange->status === -5)
                                                    <text class="text-danger">لغو شده</text>
                                                    @else
                                                    <text class="text-danger">انجام شده</text>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $exchanges->links() }}
                                @else 
                                <h4 class="text-center">تا کنون هیچ تبادلی انجام نداده‌اید</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- BEGIN: Footer-->

        @include("includes.footer") 

        <script>
            var qrcode = new QRCode("walletqrcode");

            function iformat(icon) {
                if (!icon.id) {
                    return icon.text;
                }
                var originalOption = icon.element;
                return $('<span><img style="max-width: 25px;" src="' + $(originalOption).attr('data-icon') + '"/> ' + icon.text + '</span>');
            }

            $("#from_coin").select2({
                placeholder: "انتخاب یک کوین برای ارسال",
                templateSelection: iformat,
                templateResult: iformat,
                allowHtml: true
            });
            $("#to_coin").select2({
                placeholder: "انتخاب کوین دریافتی",
                templateSelection: iformat,
                templateResult: iformat,
                allowHtml: true
            });

            $(document).ready(function () {
                $("#from_coin,#to_coin").change(function () {
                    var from_coin = $("#from_coin").val();
                    var to_coin = $("#to_coin").val();
                    if (from_coin !== to_coin) {
                        var amount = $("#amount").val();
                        $.get("/get_estimate?from=" + from_coin + "&to=" + to_coin + "&amount=" + amount, {}, function (data) {
                            $("#target-coin").val(data.value);
                        });
                    } else {
                        Swal.fire(
                                'خطا!',
                                'نمی‌توان یک کوین را به خودش تبادل کرد',
                                'error'
                                );
                        $("#to_coin").val(null);
                        $("#from_coin").val(null);
                        $("#from_coin").trigger('change.select2');
                        $("#to_coin").trigger('change.select2');

                    }

                });
                $("#amount").on("input", function () {
                    var from_coin = $("#from_coin").val();
                    var to_coin = $("#to_coin").val();
                    var amount = $("#amount").val();
                    if (from_coin !== "" && to_coin !== "") {
                        $.get("/get_estimate?from=" + from_coin + "&to=" + to_coin + "&amount=" + amount, {}, function (data) {
                            $("#target-coin").val(data.value);
                        });
                    } else {
                        Swal.fire(
                                'خطا!',
                                'ارز مبدا و مقصد را انتخاب کنید',
                                'error'
                                );
                        $(this).val("");
                    }
                });
                $("#exchangebtn").click(function () {
                    var from_coin = $("#from_coin").val();
                    var to_coin = $("#to_coin").val();
                    var amount = $("#amount").val();
                    var wallet = $("#walletAddressInput").val();
                    $(this).prop("disabled", true);
                    try {
                        $.post("/exchange", {_token: $("meta[name='csrf-token']").attr("content"), from: from_coin, to: to_coin, amount: amount, wallet: wallet}, function (data) {
                            if (data.address_from) {
                                $("#walletAddress").text(data.address_from);
                                qrcode.makeCode(data.address_from);
                                $("#amoutcoin").text(data.amount_from + "" + from_coin);
                                $("#targetamount").text(data.amount_to + "" + to_coin);
                                $("#paybox").show();
                                $("#exchangebox").hide();
                                setInterval(function () {
                                    var sec = parseInt($("#sec").text());
                                    var minute = parseInt($("#minute").text());
                                    sec--;
                                    if (sec < 0) {
                                        sec = 59;
                                        $("#sec").text(sec);
                                        minute--;
                                    } else {
                                        $("#sec").text(sec);
                                    }

                                    if (minute < 0) {
                                        Swal.fire("پایان مهلت پرداخت", "مهلت پرداخت به پایان رسید", "error");
                                        $("#paybox").hide(1000);
                                        $("#exchangebox").show(1000);
                                    } else {
                                        $("#minute").text(minute);
                                    }

                                }, 1000);
                            } else {
                                $("#exchangebtn").prop("disabled", false);
                                if (data.result) {
                                    Swal.fire("حساب شما احراز هویت نشده!", "", "error");
                                } else {
                                    Swal.fire("آدرس کیف‌پول اشتباه است! ", "", "error");
                                }

                            }
                        }).fail(function (xhr, status, error) {
                            Swal.fire("اطلاعات را کامل وارد کنید!", "", "error");
                            $("#exchangebtn").prop("disabled", false);
                        });
                    } catch (e) {
                        Swal.fire("اطلاعات را کامل وارد کنید!", "", "error");
                        $("#exchangebtn").prop("disabled", false);
                    }
                });
            });
        </script>
    </body>
</html>