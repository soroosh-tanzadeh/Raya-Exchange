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
        <title>Raya-EX | تراکنش‌های ریالی </title><!-- GLOBAL VENDORS-->

    </head>
    <body>
        @include("includes.adminheader")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">تراکنش‌ها</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">تراکنش‌های ریالی </li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive font-11">
                                    <table class="table table-hover compact-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>شماره</th>
                                                <th>شماره کارت</th>
                                                <th>شماره شبا</th>
                                                <th>شماره حساب</th>
                                                <th>تاریخ ثبت</th>
                                                <th>وضعیت تایید</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($bankaccounts as $bankaccount)
                                            <tr>
                                                <td>{{ $bankaccount->id }}</td>
                                                <td>
                                                    <b>{{ $bankaccount->IBAN }}</b>
                                                </td>
                                                <td>
                                                    <b>{{ $bankaccount->card_number }}</b>
                                                </td>
                                                <td>
                                                    <b>{{ $bankaccount->account_number }}</b>
                                                </td>
                                                <td>{{ Jalalian::forge($bankaccount->created_at)->ago() }}</td>
                                                <td>
                                                    @if($bankaccount->is_active)
                                                    <text class="text-success">تایید شده</text>
                                                    @else
                                                    <input type="submit" value="تایید پرداخت" class="btn btn-success comfirmbank" data-bankaccount="{{ $bankaccount->id }}" />
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        {{ $bankaccounts->links() }}
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Page content-->
        <!-- END: Quick sidebar-->
        @include("includes.footer")
    </body>
</html>