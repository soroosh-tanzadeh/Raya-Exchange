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
            .select2-selection{
                height: 100% !important;
                border-bottom-left-radius: 0 !important;
                border-top-left-radius: 0 !important;
            }
            .select2{
                height: 100%;
            }

            .amount-input{
                border-bottom-left-radius: 0.25rem !important;
                border-top-left-radius: 0.25rem !important;
                border-top-right-radius: 0 !important;
                border-bottom-right-radius: 0 !important;
                height: 45px;
            }
            .select2-selection__rendered{
                height: 100% !important;
                display: flex !important;
                align-items: center !important;
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
            @include("includes.alert")
            <div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="card card-fullheight">
                            <div class="card-header">
                                <h5 class="box-title"><i class="ft-cpu"></i> فرم محاسبه</h5>
                            </div>
                            <div class="card-body position-relative">
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
                                    <div class="float-left" style="text-align: center;position: absolute;left: 16px;top: 1rem;">
                                        مهلت واریز
                                        <div class="counter">
                                            <span id="minute">20</span> : <span id="sec">0</span>
                                        </div>
                                    </div>
                                </div>
                                <form action="javascript:;" id="exchangebox">
                                    <div class="alert alert-primary alert-bordered" role="alert">
                                        <h5>کاربر عزیز</h5>
                                        <ul style="list-style: decimal">
                                            <li>ارز مورد نظر را برای مبادله انتخاب کنید.</li>
                                            <li>نرخ تبدیل ارز را بررسی کنید.</li>
                                            <li>ارز را کمتر از حد مشخص شده ارسال نکنید.</li>
                                            <li>آدرس کیف پول را جهت دریافت ارز مورد نظر وارد کنید.</li>
                                        </ul>
                                    </div>
                                    <ul class="nav nav-pills w-100 mb-2">
                                        <li class="nav-item clickable w-50"><a data-toggle="tab" class="nav-link d-flex w-100 justify-content-center extype active show" data-type="fixed">نرخ ثابت</a></li>
                                        <li class="nav-item clickable w-50"><a data-toggle="tab" class="nav-link d-flex w-100 justify-content-center extype" data-type="floating">نرخ شناور</a></li>
                                    </ul>
                                    <div class="form-group mb-5">
                                        <div class="form-row" style="margin-top: 3rem">
                                            <div class="col-lg my-2">
                                                <div class="input-group">
                                                    <div style="width: 50%">
                                                        <select class="form-control mx-3" required id="from_coin">
                                                            @foreach($currencies as $currency)
                                                            @if($currency->symbol === $from)
                                                            <option value="{{ $currency->symbol }}" selected data-icon="https://simpleswap.io{{ $currency->image }}">{{ $currency->name }}</option>
                                                            @elseif($currency->symbol !== $to)
                                                            <option value="{{ $currency->symbol }}" data-icon="https://simpleswap.io{{ $currency->image }}">{{ $currency->name }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input class="form-control amount-input numeric" id="amount" value="{{ $amount }}" type="text" required placeholder="0" value="1" style="width: 50%;height: 45px;border-top-right-radius: 0;border-bottom-right-radius: 0;">
                                                </div>
                                            </div>
                                            <div class="d-lg-inline-flex d-none justify-content-center align-items-center" style="width: 60px"><i class="fas fa-arrow-left text-muted font-16"></i></div>
                                            <div class="col-lg my-2">
                                                <div class="input-group">  
                                                    <div style="width: 50%">
                                                        <select class="form-control" id="to_coin" required style="width: 50%">
                                                            @foreach($currencies as $currency)
                                                            @if($currency->symbol === $to)
                                                            <option value="{{ $currency->symbol }}" selected data-icon="https://simpleswap.io{{ $currency->image }}">{{ $currency->name }}</option>
                                                            @elseif($currency->symbol !== $from)
                                                            <option value="{{ $currency->symbol }}" data-icon="https://simpleswap.io{{ $currency->image }}">{{ $currency->name }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input class="form-control amount-input numeric" id="target-coin" readonly type="text" placeholder="0" style="width: 50%;height: 45px;border-top-right-radius: 0;border-bottom-right-radius: 0;text-align:left;">

                                                </div>
                                            </div>
                                        </div>    
                                        <div class="row" style="margin-top: 3rem">
                                            <div class="col-md-6" style="max-width: calc(50% - 20px);">
                                                <label class="mt-4">آدرس کیف پول</label>
                                                <input class="form-control" type="text" id="walletAddressInput" style="height: 45px;" required placeholder="آدرس کیف پول مقصد را وارد کنید">
                                            </div>
                                            <div class="col-md-6 text-center">
                                                <img src="/assets/img/exchange-icon.png" style="max-width: 150px"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="card-footer">
                                <div class="text-center">
                                    <button class="btn btn-danger btn-rounded" id="exchangebtn" type="submit" style="min-width: 200px" disabled>
                                        <span>تبادل</span>
                                        <div class="lds-dual-ring float-left" id='loader' style="display: none"></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h5 class="box-title"><i class="ft-download"></i> تاریخچه تبادلات</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive font-11">
                                    <table class="table datatable table-hover compact-table">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- BEGIN: Footer--> 

        @include("includes.footer") 

        <script src="/assets/js/exchange.js"></script>
    </body>
</html> 