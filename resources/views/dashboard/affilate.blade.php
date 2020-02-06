<!DOCTYPE html>
<!--
Copyright (C) 2020 Webflax

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
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <link href="/assets/vendors/feather-icons/feather.css" rel="stylesheet" />
        <link href="/assets/vendors/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
        <link href="/assets/vendors/themify-icons/themify-icons.css" rel="stylesheet" />
        <link href="/assets/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" />
        <link href="/assets/vendors/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" /><!-- PAGE LEVEL VENDORS-->
        <!-- THEME STYLES-->
        <link href="/assets/css/app.min.css" rel="stylesheet" /><!-- PAGE LEVEL STYLES-->
        <link href="/assets/css/style.css" rel="stylesheet" /><!-- PAGE RTL STYLES-->
        <link href="/assets/css/pages/form-wizard.css" rel="stylesheet" />
        <link href="/assets/vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet" /><!-- THEME STYLES-->

    </head>
    <body data-cache="null">
        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">داشبورد</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../index.html"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">داشبورد</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center">
                                    <h2>{{ $users }}</h2>
                                </div>
                                <div class="d-flex justify-content-center align-items-center my-5">
                                    <i class="fa fa-bullhorn text-primary fa-10x"></i>
                                </div>
                                <div class="d-flex justify-content-center align-items-center" style="font-size: 1.5rem;">
                                    کاربران ثبت‌نام کرده
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center">
                                    <h2>{{ $users }}</h2>
                                </div>
                                <div class="d-flex justify-content-center align-items-center my-5">
                                    <i class="fas fa-users text-primary fa-10x"></i>
                                </div>
                                <div class="d-flex justify-content-center align-items-center" style="font-size: 1.5rem;">
                                    کاربرانی که خرید کرده‌اند
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center">
                                    <h2>{{ $wallet->credit }}</h2>
                                </div>
                                <div class="d-flex justify-content-center align-items-center my-5">
                                    <i class="fas fa-money-bill text-primary fa-10x"></i>
                                </div>
                                <div class="d-flex justify-content-center align-items-center" style="font-size: 1.5rem;">
                                    درآمد ریال
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center">
                                    <h2>{{ count($checkouts)}}</h2>
                                </div>
                                <div class="d-flex justify-content-center align-items-center my-5">
                                    <i class="fab fa-bitcoin text-warning fa-10x"></i>
                                </div>
                                <div class="d-flex justify-content-center align-items-center" style="font-size: 1.5rem;">
                                    درخواست‌های کوین
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <h3 class="text-center">  تیم خود را گسترش دهید</h3>
                            </div>
                            <div class="card-body">
                                <h4 class="text-center">کد معرفی شما</h4>
                                <div class="container">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <input type="submit"  class="btn btn-success" value="کپی" style="border-radius: 0 5px 5px 0;"/>
                                        </div>
                                        <input type="text" class="form-control" name="" value="{{ $user->id }}" readonly="readonly" style="border-radius: 5px 0 0 5px;" />
                                    </div>
                                </div>
                                <hr class="mb-4">
                                <h4>خلاصه تراکنش‌های مجموعه شما</h4>
                                <div class="table-responsive">
                                    @if(count($transactions) <= 0)
                                    <h4 class="text-center">هیچ تراکنشی وجود ندارد</h4>
                                    @else
                                    <table class="table table-hover table-inbox w-100">
                                        <thead class="rowlinkx" data-link="row">
                                            <tr>
                                                <th>کابر</th>
                                                <th>مقدار تراکنش</th>
                                            </tr>
                                        </thead>
                                        <tbody class="rowlinkx" data-link="row">
                                            @foreach($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->from_user }}</td>
                                                <td>{{ $transaction->amount }} تومان</td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                    @endif
                                </div>
                                <hr>
                                <div>
                                    <input type="submit" class="btn btn-warning text-white" value="تبدیل درآمد به بیت‌کوین" />
                                    <input type="submit" class="btn btn-primary text-white" value="واریز به کیف‌پول" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include("includes.footer") 
        <script src="/assets/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="/assets/vendors/jquery-steps/build/jquery.steps.min.js"></script><!-- CORE SCRIPTS-->
        <script src="/assets/js/app.js"></script><!-- PAGE LEVEL SCRIPTS-->
        <script src="/assets/js/signup.js" type="text/javascript"></script>

    </body>
</html>