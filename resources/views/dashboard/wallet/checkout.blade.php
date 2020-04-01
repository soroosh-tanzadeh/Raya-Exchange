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

        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading"> 
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">امور مالی</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="la la-home font-20"></i></a></li>
                        <li class="breadcrumb-item">تسویه حساب</li>
                    </ol>
                </div>
            </div><!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <h3>تسویه حساب</h3>
                            </div>
                            <form action="javascript:;" onsubmit="submitAjaxForm(this);" method="POST" data-action="/checkoutrequest" data-btn="#requestpay" novalidate id="checkout-request" >
                                <div class="card-body">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="from-group">
                                                <label>
                                                    مقدار
                                                </label>
                                                <input type="text" maxlength="28" name="amount" required value="" class="form-control numberic w-100" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="from-group">
                                                <label>
                                                    حساب بانکی
                                                </label>
                                                <select name="bankaccount" required class="form-control">
                                                    <option value="" disabled selected>یک حساب را انتخاب کنید</option>
                                                    @foreach($bankaccounts as $bankaccount)
                                                    <option value="{{ $bankaccount->id }}">{{ $bankaccount->IBAN }} - {{ $bankaccount->owner }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <input type="submit" id="requestpay" class="btn btn-rounded btn-primary" value="ثبت درخواست" />
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="col-md-5">

                        <div class="card">
                            <div class="card-body text-center">
                                <div class="mb-4 py-2"><i class="badge-lg-primary text-primary ti-wallet" style="height: 54px;width: 54px;font-size: 26px;"></i></div>
                                <div class="mb-3 text-muted font-16">کیف پول ریالی</div>
                                <div class="mb-5">
                                    <div class="h3">
                                        <span>{{ $rialWallet->credit }}</span><span class="font-weight-normal text-muted" style="font-size: 14px"> تومان</span>
                                    </div>
                                    <small style="font-size: 14px">
                                        <b class="bold">قابل برداشت</b> <span class="font-16">{{ $rialWallet->cashable }}</span><span class="font-weight-normal text-muted"  style="font-size: 12px"> تومان</span>
                                    </small>
                                </div>

                                <a class="btn btn-outline-primary btn-rounded btn-block" data-toggle="modal" data-target="#paymodal" href="#paymodal">شارژ کیف پول</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!-- END: Page content-->
        </div><!-- BEGIN: Footer-->

        @include("includes.footer") 

    </body>
</html>