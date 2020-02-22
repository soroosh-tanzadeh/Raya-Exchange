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
        <link href="/assets/css/pages/form-wizard.css" rel="stylesheet" />
        <link href="/assets/vendors/feather-icons/feather.css" rel="stylesheet" />
        <link href="/assets/vendors/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
        <link href="/assets/vendors/themify-icons/themify-icons.css" rel="stylesheet" />
        <link href="/assets/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" />
        <link href="/assets/vendors/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" /><!-- PAGE LEVEL VENDORS-->
        <title>Raya-EX | آموزش</title><!-- GLOBAL VENDORS-->
        <style>
            .kbase-heading {
                position: relative;
                background-image: url({{ url("/assets/img/blog/19.jpeg") }});
            background-repeat: no-repeat;
            background-size: cover;
            }
            .kbase-heading:before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                background-color: rgba(0, 0, 0, .4);
            }

        </style>
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
            
            <div>
                <div class="mb-5 p-5 kbase-heading content-top-heading">    
                    <div class="position-relative">
                        <h2 class="mb-5 text-center text-white">چگونه ما میتوانیم به شما کمک کنیم؟</h2>
                        <div class="input-group-icon input-group-icon-left input-group-lg"><span class="input-icon input-icon-left"><i class="ti-search"></i></span><input class="form-control font-weight-left border-0" type="text" placeholder="جستجو ..." style="box-shadow:0 3px 6px rgba(10,16,20,.15);"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-4 articles-list-title">حساب شما</h5>
                                <div class="nav flex-column articles-list mb-3"><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>راهنمای ثبت نام</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>چگونه نام کاربری خود را تغییر دهم؟</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>چگونه می توانم رمز عبور خود را بازنشانی کنم؟</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>چگونه آدرس ایمیل من تغییر کند؟</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>چگونه ایمیل خود را تأیید کنم؟</a></div><a class="btn btn-link" href="javascript:;">تمام مقالات را ببینید — 7</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-4 articles-list-title">خرید</h5>
                                <div class="nav flex-column articles-list mb-3"><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>چگونه یک آیتم را خریداری کنم؟</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>چگونه با نویسنده تماس بگیریم؟</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>سیاست انحصاری</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>بررسی مجوزها</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>کجا کد خرید من است؟</a></div><a class="btn btn-link" href="javascript:;">تمام مقالات را ببینید — 9</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-4 articles-list-title">نصب و API</h5>
                                <div class="nav flex-column articles-list mb-3"><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>لورم ایپسوم متن ساختگی با تولید</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>لورم ایپسوم متن ساختگی با تولید</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>لورم ایپسوم متن ساختگی با تولید</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>لورم ایپسوم متن ساختگی با تولید</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>لورم ایپسوم متن ساختگی با تولید</a></div><a class="btn btn-link" href="javascript:;">تمام مقالات را ببینید — 12</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-4 articles-list-title">سفارشی سازی</h5>
                                <div class="nav flex-column articles-list mb-3"><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>لورم ایپسوم متن ساختگی با تولید</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>لورم ایپسوم متن ساختگی با تولید</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>لورم ایپسوم متن ساختگی با تولید</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>لورم ایپسوم متن ساختگی با تولید</a><a class="nav-link d-flex align-items-center" href="#"><i class="ti-angle-right font-12 mr-3"></i>لورم ایپسوم متن ساختگی با تولید</a></div><a class="btn btn-link" href="javascript:;">تمام مقالات را ببینید — 8</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- END: Page content-->

        </div><!-- BEGIN: Footer-->

        @include("includes.footer")
    </body>
</html>