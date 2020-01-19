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
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">افزودن حساب بانکی</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:;" onsubmit="addAccount();return false;" id="addAccountForm" >
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label>
                                            شماره شبا
                                        </label>
                                        <input type="text" maxlength="28" name="IBAN" required value="" id="iban" class="form-control w-100" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>
                                            شماره کارت
                                        </label>
                                        <input type="text" maxlength="19" minlength="16" name="card_number" required value="" class="form-control w-100" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>
                                            شماره حساب
                                        </label>
                                        <input type="text" maxlength="20" minlength="5" name="account_number" required value="" class="form-control w-100" />
                                    </div>
                                </div>
                            </div>
                            <input class="btn btn-primary" id="addaccountbtn" type="submit" value="ثبت" />
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
                    <h1 class="page-title page-title-sep">مالی</h1>
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
                                <input class="btn btn-warning text-white" type="submit" value="افزودن حساب" data-target="#addaccountmodal" data-toggle="modal" />
                            </div>
                            <div class="card-body">
                                <div class="table-responsive font-11">
                                    <table class="table table-hover compact-table">
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
            function addAccount() {
                var form = $("#addAccountForm").serialize();
                $.ajax({
                    url: "/addccount",
                    data: form,
                    type: 'POST',
                    cache: false,
                    beforeSend: function (xhr) {
                        $("#addaccountbtn").prop("disabled", true);
                    },
                    success: function (data, textStatus, jqXHR) {
                        if (data.result) {
                            toastr['success'](data.msg, "موفقیت آمیز");
                            location.reload();
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