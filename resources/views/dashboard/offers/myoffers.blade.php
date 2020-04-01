<!DOCTYPE html>
<!--
Copyright (C) 2019 Soroosh Tanzadeh

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
        <title>Raya-EX | پیشنهاد جدید</title><!-- GLOBAL VENDORS-->
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

        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading"> 
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">پیشنهادات من</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="la la-home font-20"></i></a></li>
                        <li class="breadcrumb-item">خرید و فروش ارز</li>
                    </ol>
                </div>
            </div><!-- BEGIN: Page content-->
            @include("includes.alert")
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="box-title"><i class="ft-download"></i> پیشنهادات من</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive font-11">
                                    <table class="table table-hover compact-table  datatable-full w-100" data-ajax="/dashboard/getmyoffers" data-columns='[{"data": "id"},{"data": "coin"},{"data": "amount"},{"data": "price_in_toman"},{"data": "created_at"},{"data": "type"},{"data": "is_selled"},{"data":"actions"}]'>
                                        <thead class="thead-light">
                                            <tr>
                                                <th>شماره سفارش</th>
                                                <th>نوع ارز</th>
                                                <th>مقدار</th>
                                                <th>قیمت در لحظه سفارش</th>
                                                <th>نوع معامله</th>
                                                <th>تاریخ ایجاد</th>
                                                <th>وضعیت</th>
                                                <th>عملیات</th>
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

            </div>
        </div><!-- BEGIN: Footer-->

        @include("includes.footer")
        <script src="/assets/js/offers.js"></script>
    </body>
</html>