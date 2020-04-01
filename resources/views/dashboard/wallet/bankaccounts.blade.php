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
        <title>Raya-EX | حساب‌های بانکی</title><!-- GLOBAL VENDORS-->

    </head>
    <body>

        <div class="modal fade" id="addaccountmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="ft-credit-card"></i> افزودن حساب بانکی</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:;" onsubmit="submitAjaxForm(this);" novalidate data-action="/addccount" data-btn="#addaccountbtn" data-target="/dashboard/bankaccounts" id="addAccountForm" >

                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <div class="row m-0">                                    
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group mb-0">
                                            <label>
                                                شماره شبا
                                            </label>
                                            <input type="text" name="IBAN" data-mask='IR 00-0000-0000-0000-0000-0000-00' required value="" style="direction: ltr" id="iban" class="form-control w-100">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-0">
                                            <label> 
                                                شماره کارت 
                                            </label>
                                            <input type="text" name="card_number" required value="" data-mask='0000-0000-0000-0000' style="direction: ltr" class="form-control w-100">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-0">
                                            <label>
                                                شماره حساب
                                            </label>
                                            <input type="text" maxlength="20" name="account_number" required value="" class="form-control w-100">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-0">
                                            <label>
                                                نام مالک حساب
                                            </label>
                                            <input type="text" name="account_owner" required value="" class="form-control w-100">
                                        </div>
                                    </div>
                                </div>
                                <div class="dz-message my-5" style="text-align: center;width: 100%;">
                                    <img src="/assets/img/credit-selfie-guide.png" alt="" style="width: 50vw;align-self: center;">
                                </div>
                                <div class="container-fluid pt-2 px-1 d-flex justify-content-center align-items-center">
                                    <input type="file" class="fileselect" name="creditcardpic" data-binded="#creditcardpicShower" required id="creditcardpic" style="position: absolute;opacity: 0; z-index: -10;"  />
                                    <div class="dropzone openfile w-100" id="creditcardpicShower" data-target="#creditcardpic">
                                        <div class="dz-message d-flex justify-content-center align-items-center flex-column py-3"><i class="ti-import text-primary font-40"></i>
                                            <div class="mt-3 font-20">برای انتخاب فایل کلیک کنید</div>
                                            <div class="text-muted">تصویر کارت بانکی</div>
                                        </div>
                                        <div class="filenames">
                                            <div class="images"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button class="btn btn-secondary btn-rounded" type="button" data-dismiss="modal">انصراف</button>
                            <input class="btn btn-rounded btn-primary" id="addaccountbtn" type="submit" value="ثبت" />
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
                    <h1 class="page-title page-title-sep">امور مالی</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">حساب‌های بانکی</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h2>حساب‌های بانکی </h2>
                                <button class="btn btn-warning btn-rounded d-flex align-items-center" data-target="#addaccountmodal" data-toggle="modal" ><i class="ti-plus mx-1"></i> افزودن حساب</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive font-11">
                                    <table class="table datatable table-hover compact-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>شماره</th>
                                                <th>شماره شبا</th>       
                                                <th>شماره کارت</th>
                                                <th>شماره حساب</th>
                                                <th>وضعیت تایید</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($accounts as $account)
                                            <tr>
                                                <td>{{ $account->id }}</td>
                                                <td>
                                                    <b>{{ $account->IBAN }}</b>
                                                </td>
                                                <td>
                                                    <b>{{ $account->card_number }}</b>
                                                </td>
                                                <td>
                                                    <b>{{ $account->account_number }}</b>
                                                </td>
                                                <td>
                                                    @if($account->is_active)
                                                    <text class="text-success">تایید شده</text>
                                                    @else
                                                    <text class="text-warning">تایید نشده</text>
                                                    @endif
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $accounts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Page content-->
        <!-- END: Quick sidebar-->
        @include("includes.footer")
        <script>
            $(".form-control").each(function () {
                if ($(this)[0].hasAttribute("data-mask")) {
                    var element = this;
                    IMask(
                            $(element)[0], {
                        mask: $(element).attr("data-mask"),
                        lazy: false
                    });
                }
            });

            $(".form-control").on("keyup", function () {
                if ($(this)[0].hasAttribute("data-mask")) {
                    if (/([A-Z]|[a-z]|[0-9])/.test(IMask($(this)[0], {mask: $(this).attr("data-mask")}).unmaskedValue)) {
                        $(this).attr("style", "text-align: left;padding-left: 12px !important;direction: ltr;");
                    }
                } else {
                    if (/([A-Z]|[a-z]|[0-9])/.test($(this).val())) {
                        $(this).attr("style", "text-align: left;padding-left: 12px !important");
                    } else {
                        $(this).attr("style", "text-align: right;");
                    }

                }
            });
        </script>
    </body>
</html>