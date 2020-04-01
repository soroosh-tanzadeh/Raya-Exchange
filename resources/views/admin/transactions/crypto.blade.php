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
        <title>Raya-EX | تراکنش‌های ارزی </title><!-- GLOBAL VENDORS-->

    </head>
    <body>
        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">تراکنش‌ها</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">تراکنش‌های ارزی </li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h4>درخواست برداشت</h4>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div id="menu1" class="tab-pane fade active show">
                                        <div class="table-responsive font-11">
                                            <table class="table table-hover compact-table datatable-full w-100" data-ajax="/admin/datatable/getcoindeposits" data-columns='[{"data": "id"},{"data": "coin"},{"data": "amount"},{"data": "token"},{"data":"created_at"},{"data":"is_payed"}]'>
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>شماره</th>
                                                        <th>ارز</th>
                                                        <th>مقدار</th>
                                                        <th>به کیف پول</th>
                                                        <th>تاریخ</th>
                                                        <th>وضعیت پرداخت</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($checkouts as $checkout)
                                                    <tr>
                                                        <td>{{ $checkout->id }}</td>

                                                        <td>
                                                            <b>{{ $checkout->coin }}</b>
                                                        </td>
                                                        <td>{{ $checkout->amount }}</td>
                                                        <td>{{ $checkout->token }}</td>
                                                        <td>{{ $checkout->created_at }}</td>                       
                                                        <td>
                                                            @if($checkout->is_payed)
                                                            <text class="text-success">پرداخت شده</text>
                                                            @else
                                                            <input type="submit" value="تایید پرداخت" class="btn btn-success comfirmpay" data-checkout="{{ $checkout->id }}" />
                                                            @endif
                                                        </td>

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
                </div>
            </div>
            <!-- END: Page content-->
        </div>
        <!-- END: Quick sidebar-->
        @include("includes.footer")
    </body>
</html>