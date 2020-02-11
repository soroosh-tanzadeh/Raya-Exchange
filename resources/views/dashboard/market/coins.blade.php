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
<?php

use App\Currency;

$usdprice = Currency::where("code", "USD")->first()->price;
?>
<html lang="en">
    <head>
        @include("includes.head")
        <title>Raya-EX | قیمت ارز دیجیتال</title>

    </head>
    <body>
        <div class="modal fade" id="coinmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg"  role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">اطلاعات رمز ارز</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="loadingcoin" class="w-100 h-100 text-center">
                            درحال دریافت اطلاعات
                        </div>
                        <div id="area_datetime">
                            <div id="timeline-chart"></div>
                        </div>
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
                    <h1 class="page-title page-title-sep">رمز‌ارزها</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="la la-home font-20"></i></a></li>
                        <li class="breadcrumb-item">برگه ها</li>
                        <li class="breadcrumb-item">قیمت لحظه‌ای</li>
                    </ol>
                </div>
            </div><!-- BEGIN: Page content-->
            <div>
                <div class="card">
                    <div class="card-body px-5">
                        <div class="card-fullwidth-block">
                            <div class="table-responsive">
                                <table class="table table-hover table-inbox w-100" id="market-table">
                                    <thead class="rowlinkx" data-link="row">
                                        <tr>
                                            <th>رتبه</th>
                                            <th>#</th>
                                            <th>نام ارز</th>
                                            <th>قیمت به دلار</th>
                                            <th>قیمت به تومان</th>
                                            <th>حجم بازار (دلار)</th>
                                            <th>میزان عرضه</th>
                                            <th>تغییرات قیمت نسبت به روز گذشته</th>
                                            <th>نمودار تعییرات / هفتگی</th>
                                            <th>تبادل</th>
                                        </tr>
                                    </thead>
                                    <tbody class="rowlinkx" data-link="row">
                                        @foreach($coins as $coin)
                                        <tr class="coinrow clickable" data-coin="{{ $coin->id }}">
                                            <td>{{ $coin->rank }}</td>
                                            <td><img src="{{ $coin->icon }}" style="max-width: 30px"/></td>
                                            <td class="showCoin">{{ $coin->name }}</td>
                                            <td class="coinprice" data-price="{{ round($coin->priceUsd,5) }}">{{ number_format(round($coin->priceUsd,5),5) }}$</td>
                                            <td class="coinprice-toman"><?php
                                                $priceInToman = (int) ($coin->priceUsd * $usdprice);
                                                if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                                                    $price = $priceInToman / 1000;
                                                    echo $price . "<br>".  "<div class='priceunit'>" ." هزار تومان" . "</div>";
                                                } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                                                    $price = $priceInToman / 1000000;
                                                    echo $price . "<br>".  "<div class='priceunit'>" ." میلیون تومان". "</div>";
                                                } elseif ($priceInToman >= 1000000000) {
                                                    $price = $priceInToman / 1000000000;
                                                    echo $price . "<br>".  "<div class='priceunit'>" ." میلیارد تومان". "</div>";
                                                } else {
                                                    $price = $priceInToman;
                                                    echo $price . "<br>".  "<div class='priceunit'>" ." تومان". "</div>";
                                                }
                                                ?></td>
                                            <td>
                                                <?php
                                                $marketCapUsd = round($coin->marketCapUsd, 3);
                                                if (($marketCapUsd >= 1000) & ($marketCapUsd < 1000000)) {
                                                    $cap = $marketCapUsd / 1000;
                                                    echo $cap . "<br>".  "<div class='priceunit'>" ." هزار دلار". "</div>";
                                                } elseif ($marketCapUsd >= 1000000 & ($marketCapUsd < 1000000000)) {
                                                    $cap = $marketCapUsd / 1000000;
                                                    echo $cap . "<br>".  "<div class='priceunit'>" ." میلیون دلار". "</div>";
                                                } elseif ($marketCapUsd >= 1000000000) {
                                                    $cap = $marketCapUsd / 1000000000;
                                                    echo $cap . "<br>".  "<div class='priceunit'>" ." میلیارد دلار". "</div>";
                                                } else {
                                                    $cap = $marketCapUsd;
                                                    echo $cap . "<br>".  "<div class='priceunit'>" ." تومان". "</div>";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $supply = round($coin->supply, 4);
                                                if (($supply >= 1000) & ($supply < 1000000)) {
                                                    $asupply = $supply / 1000;
                                                    echo $asupply .  "<br>".  "<div class='priceunit'>" ." هزار $coin->symbol". "</div>";
                                                } elseif ($supply >= 1000000 & ($supply < 1000000000)) {
                                                    $asupply = $supply / 1000000;
                                                    echo $asupply .  "<br>".  "<div class='priceunit'>" ." میلیون $coin->symbol". "</div>";
                                                } elseif ($supply >= 1000000000) {
                                                    $asupply = $supply / 1000000000;
                                                    echo $asupply .  "<br>".  "<div class='priceunit'>" ." میلیارد $coin->symbol". "</div>";
                                                } else {
                                                    $asupply = $supply;
                                                    echo $asupply .  "<br>".  "<div class='priceunit'>" ." $coin->symbol". "</div>";
                                                }
                                                ?>
                                            </td>
                                            <td class="coinchange">
                                                @if($coin->changePercent24Hr < 0)
                                                <text class="text-danger change">{{ number_format(round($coin->changePercent24Hr,2),2) }}%</text>
                                                @else
                                                <text class="text-success change">{{ round($coin->changePercent24Hr,2) }}%</text>
                                                @endif
                                            </td>
                                            <td class="spark-line">{{ $coin->history }}</td>
                                            <td><button class="btn btn-outline-primary"><i class="fas fa-exchange-alt font-16"></i></button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>                          
                            </div>

                            <ul class="pagination justify-content-center">
                                @for($i = 1;$i<=10;$i++)
                                <li class="page-item @if($i==$page) active @endif"><a class="page-link"href="/dashboard/market?page={{ $i }}">{{ $i }}</a></li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!-- END: Page content-->
        </div><!-- BEGIN: Footer-->

        @include("includes.footer") 
        <style>
            canvas{
                max-width: 150px !important;
            }
            td{
                text-align: center;
            }


        </style>
        <script src="/assets/vendors/apexcharts/dist/apexcharts.min.js"></script><!-- CORE SCRIPTS-->
        <script>
function loadChart(dateSeries1) {
    $("#timeline-chart").html("");
    var options = {
        annotations: {
            yaxis: [{
                    y: 30,
                    borderColor: '#999',
                }],
            xaxis: [{
                    x: new Date(dateSeries1[0][0]).getTime(),
                    borderColor: '#999',
                    yAxisIndex: 0,
                    label: {
                        show: true,
                        text: 'Rally',
                        style: {
                            color: "#fff",
                            background: '#775DD0'
                        }
                    }
                }]
        },
        chart: {
            type: 'area',
            height: 350,
        },
        dataLabels: {
            enabled: false
        },
        series: [{
                name: 'Price',
                data: dateSeries1
            }, ],
        markers: {
            size: 0,
            style: 'hollow',
        },
        xaxis: {
            type: 'datetime',
            min: new Date(dateSeries1[0][0]).getTime(),
            tickAmount: 6,
        },
        tooltip: {
            x: {
                format: 'dd MMM yyyy'
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 100]
            }
        },
    }
    var chart = new ApexCharts(
            document.querySelector("#timeline-chart"),
            options
            );
    chart.render();
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
//    $(".coinrow").each(function () {
//        var row = this;
//        var coin = $(this).attr("data-coin");
////        $.get("/getcoinhis/?coin="+coin, {}, function (data) {
////          //  $(row).children(".spark-line").html(data.data);
////        });
//    });
    $(".spark-line").sparkline('html', {changeRangeMin: 0, chartRangeMax: 1});
    $(".coinrow").click(function () {
        var coin = $(this).attr("data-coin");
        $.ajax({
            url: "/coindetail",
            data: {coin: coin},
            type: "POST",
            beforeSend: function (xhr) {
                $("#area_datetime").hide();
                $("#loadingcoin").show();
                $("#coinmodal").modal();
            },
            success: function (data, textStatus, jqXHR) {
                if (data.result) {
                    $("#area_datetime").show();
                    $("#loadingcoin").hide();
                    loadChart(data.data);
                } else {
                    $("#area_datetime").hide();
                    $("#loadingcoin").html("هیچ داده‌ای موجود نیست!");
                }
            }
        });
    });
    $("#market-table").dataTable({
        "language": {
            "url": "{{ url('/assets/persian.json') }}"
        },
        "searching": false,
        "paging": false,
        "info": false,
        "lengthChange": false
    })
    setInterval(function () {
        $(".coinrow").each(function () {
            var coin_id = $(this).attr("data-coin");
            var row = $(this);
            $.post("/getcoin", {_token: $('meta[name="csrf-token"]').attr('content'), id: coin_id}, function (data) {
                var cprice = row.children(".coinprice");
                var tprice = row.children(".coinprice-toman");

                if (parseFloat(cprice.attr("data-price")) !== parseFloat(data.priceUsd)) {
                    if (data.priceUsd > cprice.attr("data-price")) {
                        row.addClass("bg-change-green");
                        setTimeout(function () {
                            row.removeClass("bg-change-green");
                        }, 500);
                    } else if (data.priceUsd < cprice.attr("data-price")) {
                        row.addClass("bg-change-red");
                        setTimeout(function () {
                            row.removeClass("bg-change-red");
                        }, 500);
                    }

                    cprice.attr("data-price", data.priceUsd);
                    cprice.html(data.priceUsd + " $");
                    tprice.html(data.price_in_toman);
                    row.children(".coinvwap").html(parseFloat(data.vwap24Hr).toFixed(5));
                    var percentage = parseFloat(data.changePercent24Hr).toFixed(2);
                    if (percentage > 0) {
                        row.children(".coinchange").children(".change").removeClass("text-danger");
                        row.children(".coinchange").children(".change").addClass("text-success");
                        row.children(".coinchange").children(".change").html(percentage + "%");
                    } else {
                        row.children(".coinchange").children(".change").addClass("text-danger");
                        row.children(".coinchange").children(".change").removeClass("text-success");
                        row.children(".coinchange").children(".change").html(percentage + "%");
                    }
                }
            });
        });
    }, 5000);
});
        </script>
    </body>
</html>