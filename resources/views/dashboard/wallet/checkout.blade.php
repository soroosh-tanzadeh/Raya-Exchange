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
                        <form onsubmit="submitAjaxForm(this)" data-action="/payir/pay" method="GET">
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
                    <h1 class="page-title page-title-sep">رمز‌ارزها</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="la la-home font-20"></i></a></li>
                        <li class="breadcrumb-item">کیف پول من</li>
                    </ol>
                </div>
            </div><!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <h3>ثبت درخواست تسویه حساب</h3>
                            </div>
                            <div class="card-body">
                                <form action="javascript:;" onsubmit="checkoutRequest();return false;" id="checkout-request" >
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label>
                                                مقدار
                                            </label>
                                            <input type="text" maxlength="28" name="amount" required value="" id="iban" class="form-control w-100" />
                                        </div>
                                        <div class="col-md-6">
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
                                        <input type="submit" class="btn btn-primary" value="ثبت درخواست" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="mb-3"><i class="badge-lg-primary text-primary ti-wallet" style="height: 54px;width: 54px;font-size: 26px;"></i></div>
                            <div class="mb-3 text-muted font-16">کیف پول ریالی</div>
                            <div class="h3 mb-4"><span>{{ $rialWallet->credit }}</span><span class="font-weight-normal"> تومان</span></div>
                            <div>
                                قابل برداشت : <span>{{ $rialWallet->cashable }}</span><span class="font-weight-normal"> تومان</span></div>
                            <hr>
                            <div class="flexbox"><a data-toggle="modal" data-target="#paymodal" href="#paymodal">واریز</a></div>
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- END: Page content-->
    </div><!-- BEGIN: Footer-->

    @include("includes.footer") 

    <script>
        function checkoutRequest() {
            var form = $("#checkout-request").serialize();
            $.ajax({
                url: "/checkoutrequest",
                data: form,
                type: 'POST',
                cache: false,
                beforeSend: function (xhr) {
                    $("#addaccountbtn").prop("disabled", true);
                },
                success: function (data, textStatus, jqXHR) {
                    if (data.result) {
                        toastr['success'](data.msg, "موفقیت آمیز");
                        window.location = "/dashboard/rials";
                    } else {
                        toastr['error'](data.msg, "خطا");
                    }
                    $("#addaccountbtn").prop("disabled", false);

                }
            });
        }
    </script>

</body>
</html>