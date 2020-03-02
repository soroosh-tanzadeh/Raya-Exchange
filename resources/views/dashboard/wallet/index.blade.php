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
        <title>Raya-EX | کیف پول</title><!-- GLOBAL VENDORS-->

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


        <div class="modal fade" id="newwallet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">کیف پول جدید</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form data-action="/dashboard/newwallet" data-btn="#newwalletbtn" onsubmit="submitAjaxForm(this)" action="javascript:;" method="POST">
                            <label>مبلغ شارژ (تومان)</label> 
                            <select id="walletcoins" required style="width: 100%" name="type">
                                <option value=""></option>
                                @foreach($coins as $key => $value)
                                <option value="{{ strtolower($key)  }}" data-icon="{{ url("/assets/icons/".strtolower($key).".png") }}">{{ $value['name'] }}</option>
                                @endforeach
                            </select>
                            <br>
                            <input type="hidden" name="name" id="coinname" />
                            <input class="btn btn-primary my-2" id="newwalletbtn" type="submit" value="ایجاد" />
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="paycoinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">شارژ کیف‌پول ارزی </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/paycoin" method="GET">
                            <label>میزان کوین</label>
                            <input id="targetcoin" type="hidden" name="target" value="" />
                            <input id="coinamount" type="number" step="0.000000001" min="0.0001" max="100000000" name="amount" class="form-control" value="" style="width: 100%;margin-bottom: 10px;" placeholder="میزان کوین مورد نظر خود را وارد کنید" />
                            <input class="btn btn-primary" type="submit" value="پرداخت" />
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="checkoutcoinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">شارژ کیف‌پول ارزی </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:;" onsubmit="submitAjaxForm(this);" method="POST" data-action="/coin/checkoutrequest">
                            @csrf
                            <input id="checkouttargetcoin" type="hidden" name="target" value="" />
                            <label>میزان کوین</label>
                            <input id="checkoutcoinamount" type="number" step="0.000000001" required min="0.01" max="100000000" name="amount" class="form-control" value="" style="width: 100%;margin-bottom: 10px;" placeholder="میزان کوین مورد نظر خود را وارد کنید" />
                            <label>آدرس کیف پول</label>
                            <input id="coinwalletAddress" type="text" name="token" class="form-control" required value="" style="width: 100%;margin-bottom: 10px;" placeholder="آدرس کیف پول خود را وارد کنید" />
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
                            <div  class="card-body">
                                <h6>تخمین ارزش دارایی</h6>
                                <p class="text-muted"> <span class="mx-2">{{ number_format($wealth * $usdprice) }} تومان</span> <span class="mx-3">{{ number_format($wealth,2) }} $</span> <span class="mx-3">{{ number_format($wealth / $coinsprice['BTC']->priceUsd,4) }} BTC</span></p>
                                <div class="table-responsive">
                                    <table class="table table-hover table-inbox w-100" id="market-table">
                                        <thead>
                                            <tr>
                                                <th>نوع ارز</th>
                                                <th>قیمت به تومان</th>
                                                <th>موجودی (تومان)</th>
                                                <th>موجودی (دلار)</th>
                                                <th>موجودی (BTC)</th>
                                                <th>قابل برداشت</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center"> <img src="{{ url("/assets/img/money.png") }}" style="max-width: 40px;">  <p>تومان</p></td>
                                                <td>1 تومان</td>
                                                <td>{{ number_format($rialWallet->credit) }}<br><span class="text-muted"> تومان </span></td>
                                                <td>{{ number_format($rialWallet->credit / $usdprice,2) }}</td>
                                                <td>{{ number_format($rialWallet->credit / $coinsprice['BTC']->price_in_toman_int,4) }}</td>
                                                <td>{{ number_format($rialWallet->cashable) }}</td>
                                                <td>
                                                    <a class="btn btn-danger btn-sm btn-rounded ml-2 text-white" href="/dashboard/checkouts">برداشت</a>
                                                    <a class="btn btn-primary btn-sm btn-rounded ml-2 text-white" data-toggle="modal" data-target="#paymodal" href="#paymodal">واریز</a>
                                                </td>
                                            </tr>

                                            @foreach($coinWallets as $coinWallet)
                                            <tr>
                                                <td class="text-center"> <img src="{{ url("/assets/icons/". strtolower($coinWallet->type_name) .".png") }}" style="max-width: 40px;"> <p>{{ $coinWallet->name }}</p></td>
                                                @if(isset($coinsprice[strtoupper($coinWallet->type_name)]))
                                                <td>{!! $coinsprice[strtoupper($coinWallet->type_name)]->price_in_toman !!}</td>
                                                <td>{{ number_format($coinsprice[strtoupper($coinWallet->type_name)]->price_in_toman_int * $coinWallet->credit) }}<br><span class="text-muted"> تومان </span></td>
                                                <td>{{ number_format($coinsprice[strtoupper($coinWallet->type_name)]->priceUsd * $coinWallet->credit,2) }}</td>
                                                <td>{{ number_format(($coinsprice[strtoupper($coinWallet->type_name)]->priceUsd / $coinsprice['BTC']->priceUsd) * $coinWallet->credit,4) }}</td>
                                                @else
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                @endif
                                                <td>{{ $coinWallet->cashable }}</td>
                                                <td>
                                                    <a class="btn btn-success btn-sm btn-rounded ml-2 text-white" href="/dashboard/myoffers">خرید و فروش</a>
                                                    <a class="btn btn-warning btn-sm btn-rounded ml-2 text-white" href="/dashboard/exchange">تبادل</a>
                                                    <a class="btn btn-danger btn-sm btn-rounded ml-2 text-white recievecoin"  data-coin="{{ $coinWallet->type_name }}">برداشت</a>
                                                    <a class="btn btn-primary btn-sm btn-rounded ml-2 text-white paycoin" data-coin="{{ $coinWallet->type_name }}">واریز</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <a href="#newwallet" data-toggle="modal" data-target="#newwallet" >
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        افزودن کیف‌پول جدید 
                                        <text class="my-1 font-40 btn btn-primary rounded-circle p-1" style="height: 60px;width:60px;text-align: center;vertical-align: middle;">+</text>
                                    </div>
                                </a> 
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-4">
                                    <div>
                                        <h5 class="box-title mb-0">آخرین تراکنش ها</h5>
                                    </div><a class="text-muted" href="#"><i class="ti-more-alt"></i></a>
                                </div>
                                <div class="card-fullwidth-block">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="pl-4">واحد پول</th>
                                                    <th>مبلغ</th>
                                                    <th class="pr-4">نوع</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transactions as $transaction)
                                                <tr>
                                                    <td class="pl-4"><b>{{ $transaction->coin }}</b></td>
                                                    <td>{{ $transaction->amount}}</td>
                                                    <td class="text-success">{{ $transaction->type }}</td>
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
                placeholder: "انتخاب یک کوین برای ارسال",
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