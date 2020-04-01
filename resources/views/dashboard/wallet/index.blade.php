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

use Morilog\Jalali\Jalalian;
?>

<html lang="en">
    <head>
        @include("includes.head")
        <title>Raya-EX | کیف پول</title><!-- GLOBAL VENDORS-->

    </head>
    <body>

        <div class="modal fade" id="newwallet" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">کیف پول جدید</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form data-action="/dashboard/newwallet" data-btn="#newwalletbtn" onsubmit="submitAjaxForm(this)" action="javascript:;" method="POST">

                        <div class="modal-body">
                            <label>نوع کیف پول</label> 
                            <select id="walletcoins" required style="width: 100%;margin-bottom: 25px" name="type">
                                <option value=""></option>
                                @foreach($coins as $coin)
                                <option value="{{ $coin->symbol  }}" data-icon="{{ url("/assets/icons/".strtolower($coin->symbol).".png") }}">{{ $coin->name }}</option>
                                @endforeach
                            </select>
                            <br>
                            <input type="hidden" name="name" id="coinname" />
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary btn-rounded" type="button" data-dismiss="modal">انصراف</button>
                            <input class="btn btn-primary btn-rounded my-2" id="newwalletbtn" type="submit" value="ایجاد" />
                        </div>

                    </form>

                </div>
            </div>
        </div>

        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading"> 
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">کیف پول</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="la la-home font-20"></i></a></li>
                        <li class="breadcrumb-item">کیف پول من</li>
                    </ol>
                </div>
            </div><!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header justify-content-between">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="box-title mb-0"><i class="ti-wallet"></i> کیف پول‌ها</h5>
                                    </div>
                                </div>

                                <a href="#newwallet" onclick="$('#newwallet').modal()" data-toggle="tooltip" title="ایجاد کیف پول جدید" class="btn btn-success btn-rounded rounded-circle d-flex align-items-center justify-content-center p-1" style="height: 40px;width: 40px;"><i class="ti-plus"></i></a>
                            </div>
                            <div  class="card-body">
                                <div class="w-100 d-flex justify-content-center align-items-center mb-4">
                                    <div class="card">
                                        <div class="card-body text-white" style="background-image: linear-gradient(45deg,#f39c12 0,#e91e63 100%);">
                                            <div class="d-flex justify-content-between mb-5">
                                                <div>
                                                    <h5 class="box-title mb-2">تخمین میزان دارایی شما</h5>
                                                </div><i class="ft-dollar-sign text-white-50 font-40"></i>
                                            </div>
                                            <div class="flexbox mb-2">
                                                <div class="h1 mb-0">{{ number_format($wealth / $coinsprice['BTC']->priceUsd,8) }} BTC</div>
                                                <span class="text-white font-18">

                                                </span>
                                            </div>
                                            <div class="text-light">{{ number_format($wealth * $usdprice) }} تومان
                                                <span class="float-left"> {{ number_format($wealth,2) }} $</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-inbox w-100" id="market-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th> ارز</th>
                                                <th style="white-space: nowrap;">قیمت به تومان</th>
                                                <th style="white-space: nowrap;">موجودی (تومان)</th>
                                                <th style="white-space: nowrap;">موجودی (دلار)</th>
                                                <th style="white-space: nowrap;">موجودی (BTC)</th>
                                                <th style="white-space: nowrap;">قابل برداشت</th>
                                                <th>عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">
                                                    <img src="{{ url("/assets/img/money.png") }}" style="max-width: 40px;" data-toggle="tooltip" title="تومان">  
                                                </td>
                                                <td>1 <span class="text-muted font-12 text-right"> تومان </span></td>
                                                <td style="white-space: nowrap;">{{ number_format($rialWallet->credit) }} <span class="text-muted font-12"> تومان </span></td>
                                                <td>{{ number_format($rialWallet->credit / $usdprice,2) }}</td>
                                                <td>{{ number_format($rialWallet->credit / $coinsprice['BTC']->price_in_toman_int,8) }}</td>
                                                <td>{{ number_format($rialWallet->cashable) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-outline-primary btn-sm d-flex justify-content-center align-items-center" data-toggle="tooltip" title="واریز" onclick="$('#paymodal').modal()" data-target="" href="#paymodal"><i class="ti-download"></i></a>
                                                        <a class="btn btn-outline-danger btn-sm d-flex justify-content-center align-items-center" data-toggle="tooltip" title="برداشت" href="/dashboard/checkouts"><i class="ti-upload"></i></a>
                                                    </div>
                                                </td>
                                            </tr>

                                            @foreach($coinWallets as $coinWallet)
                                            <tr>
                                                <td class="text-center"> 
                                                    <img src="{{ url("/assets/icons/". strtolower($coinWallet->type_name) .".png") }}" style="max-width: 40px;" data-toggle="tooltip" title="{{ $coinWallet->name }}">
                                                </td>
                                                @if(isset($coinsprice[strtoupper($coinWallet->type_name)]))
                                                <td>{!! $coinsprice[strtoupper($coinWallet->type_name)]->price_in_toman !!}</td>
                                                <td style="white-space: nowrap;">{{ number_format($coinsprice[strtoupper($coinWallet->type_name)]->price_in_toman_int * $coinWallet->credit) }} <span class="text-muted font-12" style="white-space: nowrap"> تومان </span></td>
                                                <td>{{ number_format($coinsprice[strtoupper($coinWallet->type_name)]->priceUsd * $coinWallet->credit,2) }}</td>
                                                <td>{{ number_format(($coinsprice[strtoupper($coinWallet->type_name)]->priceUsd / $coinsprice['BTC']->priceUsd) * $coinWallet->credit,8) }}</td>
                                                @else
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                @endif
                                                <td>{{ $coinWallet->cashable }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a class="btn btn-outline-success btn-sm d-flex justify-content-center align-items-center" data-toggle="tooltip" title="خرید و فروش" href="/dashboard/myoffers"><i class="ti-shopping-cart"></i></a>
                                                        <a class="btn btn-outline-warning btn-sm d-flex justify-content-center align-items-center" data-toggle="tooltip" title="تبادل" href="/dashboard/exchange" style="border-radius: 0"><i class="ti-exchange-vertical"></i></a>
                                                        <a class="btn btn-outline-primary btn-sm d-flex justify-content-center align-items-center paycoin" data-toggle="tooltip" title="واریز" data-coin="{{ $coinWallet->type_name }}" data-name="{{ $coinWallet->name }}" style="border-radius: 0"><i class="ti-download"></i></a>
                                                        <a class="btn btn-outline-danger btn-sm d-flex justify-content-center align-items-center recievecoin" data-toggle="tooltip" title="برداشت" data-coin="{{ $coinWallet->type_name }}" data-name="{{ $coinWallet->name }}"><i class="ti-upload"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="box-title mb-0"><i class="ft-menu"></i> تراکنش‌ها</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table datatable-full table-hover w-100" data-ajax="/dashboard/gettransacions" data-columns='[{"data": "coin"},{"data": "amount"},{"data": "type"},{"data": "status"},{"data": "created_at"}]'>
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="pl-4">نوع ارز</th>
                                                <th>میزان</th>
                                                <th class="pr-4">عملیات</th>
                                                <th class="pr-4">وضعیت</th>
                                                <th class="pr-4">تاریخ</th>
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
            </div><!-- END: Page content-->
        </div><!-- BEGIN: Footer-->

        @include("includes.footer") 
        <script>
            function iformat(icon) {
                if (!icon.id) {
                    return icon.text;
                }
                var originalOption = icon.element;
                return $('<span><img style="max-width: 25px;" src="' + $(originalOption).attr('data-icon') + '"/> ' + icon.text + '</span>');
            }

            $("#walletcoins").select2({
                placeholder: "انتخاب کوین",
                templateSelection: iformat,
                templateResult: iformat,
                allowHtml: true
            });

            $("#walletcoins").change(function () {
                var coinname = $("#walletcoins :selected").text();
                $("#coinname").val(coinname);
            });
        </script>

    </body>
</html>