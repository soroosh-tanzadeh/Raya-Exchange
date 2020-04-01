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
<?php

use App\Wallet;
?>
<html lang="en">
    <head>
        @include("includes.head")
        <title>RayaEx | کسب درآمد</title>
        <style>
            .data-widget-icon {
                position: absolute;
                top: 20px;
                right: 20px;
                font-size: 40px;
                color: #6a89d7;
            }
        </style>
    </head>
    <body data-cache="null">


        <div class="modal fade" id="checkoutmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            انتقال درآمد به کیف پول
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="javascript:;" onsubmit="submitAjaxForm(this);" data-btn="#btnmovetowallet" novalidate method="GET" data-action="/dashboard/movetowallet">
                        <div class="modal-body">
                            @csrf
                            <input id="checkouttargetcoin" type="hidden" name="target" value="" />
                            <div class="form-group w-100">
                                <label>مقدار مورد نظر</label>
                                <input type="text" required name="amount" class="form-control numeric" value="" style="width: 100%;margin-bottom: 10px;" placeholder="مقدار مورد نظر خود وارد کنید" />
                                <small class="text-success">حداقل مقدار برداشت ۱۵ هزار تومان است.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary btn-rounded" type="button" data-dismiss="modal">انصراف</button>
                            <input class="btn btn-primary btn-rounded" id="btnmovetowallet" type="submit" value="انتقال" />
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="convertToBTC" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            تبدیل درآمد به بیت کوین
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="javascript:;" onsubmit="submitAjaxForm(this);" data-btn="#convert2btc" novalidate method="GET" data-action="/dashboard/convert2btc">
                        <div class="modal-body">
                            @csrf
                            <input id="checkouttargetcoin" type="hidden" name="target" value="" />
                            <div class="form-group w-100">
                                <label>مقدار مورد نظر</label>
                                <input type="text" required name="amount" class="form-control numeric" value="" style="width: 100%;margin-bottom: 10px;" placeholder="مقدار مورد نظر خود وارد کنید" />
                                <small class="text-success">حداقل مقدار تبدیل ۵۰۰ هزار تومان است.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary btn-rounded" type="button" data-dismiss="modal">انصراف</button>
                            <input class="btn btn-primary btn-rounded" type="submit" id="convert2btc" value="ثبت درخواست" />
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
                    <h1 class="page-title page-title-sep">کسب درآمد</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">زیرمجموعه‌ها</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            @include("includes.alert")
            <div>


                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-muted font-weight-normal">کاربران</h6>
                                <div class="h2 mb-0 font-weight-normal">{{ $users }}</div><i class="ft-user data-widget-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-muted font-weight-normal">سفارشات</h6>
                                <div class="h2 mb-0 font-weight-normal">{{ count($transactions) }}</div><i class="ft-shopping-cart data-widget-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-muted font-weight-normal">درآمد به تومان</h6>
                                <div class="h2 mb-0 font-weight-normal">{{ $wallet->cashable }}</div><i class="ft-dollar-sign data-widget-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-muted font-weight-normal">درآمد به بیت‌کوین</h6>
                                <div class="h2 mb-0 font-weight-normal">{{ number_format(($wallet->cashable / Wallet::getCoin("bitcoin")->price_in_toman_int),8) }}</div><i class="cc mx-2 BTC-alt data-widget-icon"></i></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">



                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-center"><i class="ft-users"></i> تیم خود را گسترش دهید</h5>

                            </div>
                            <div class="card-body">
                                <h5 class="box-title text-primary">لینک دعوت</h5>
                                <p class="text-muted mb-4">
                                    با ارسال لینک زیر به دوستان خود از سفارشات موفق آنها کسب درآمد کنید.
                                </p>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <input type="submit"  class="btn btn-success" value="کپی" onclick="copy(this)" style="border-radius: 0 5px 5px 0;"/>
                                    </div>
                                    <input type="text" class="form-control text-right" name="" id="affilateurl" value="{{ url("/?user_referral_id=".$user->id) }}" readonly="readonly" style="border-radius: 5px 0 0 5px;" />
                                </div>
                                <hr class="my-4">
                                <h5 class="box-title" >اشتراک گذاری در شبکه‌های اجتماعی</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <a class="resp-sharing-button__link" href="https://facebook.com/sharer/sharer.php?u={{ url("/?user_referral_id=".$user->id) }}" target="_blank" rel="noopener" aria-label="Share on Facebook">
                                            <div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/></svg>
                                                </div>Facebook</div>
                                        </a>
                                    </div>

                                    <div class="col-6">
                                        <!-- Sharingbutton Twitter -->
                                        <a class="resp-sharing-button__link" href="https://twitter.com/intent/tweet/?text=%D8%AF%D8%B1%20%D8%B1%D8%A7%DB%8C%D8%A7%20%D8%AB%D8%A8%D8%AA%E2%80%8C%D9%86%D8%A7%D9%85%20%DA%A9%D9%86%DB%8C%D8%AF%20&amp;url={{ url("/?user_referral_id=".$user->id) }}" target="_blank" rel="noopener" aria-label="Share on Twitter">
                                            <div class="resp-sharing-button resp-sharing-button--twitter resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z"/></svg>
                                                </div>Twitter</div>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <!-- Sharingbutton E-Mail -->
                                        <a class="resp-sharing-button__link" href="mailto:?subject=%D8%AF%D8%B1%20%D8%B1%D8%A7%DB%8C%D8%A7%20%D8%AB%D8%A8%D8%AA%E2%80%8C%D9%86%D8%A7%D9%85%20%DA%A9%D9%86%DB%8C%D8%AF%20&amp;body={{ url("/?user_referral_id=".$user->id) }}" target="_self" rel="noopener" aria-label="Share by E-Mail">
                                            <div class="resp-sharing-button resp-sharing-button--email resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 4H2C.9 4 0 4.9 0 6v12c0 1.1.9 2 2 2h20c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM7.25 14.43l-3.5 2c-.08.05-.17.07-.25.07-.17 0-.34-.1-.43-.25-.14-.24-.06-.55.18-.68l3.5-2c.24-.14.55-.06.68.18.14.24.06.55-.18.68zm4.75.07c-.1 0-.2-.03-.27-.08l-8.5-5.5c-.23-.15-.3-.46-.15-.7.15-.22.46-.3.7-.14L12 13.4l8.23-5.32c.23-.15.54-.08.7.15.14.23.07.54-.16.7l-8.5 5.5c-.08.04-.17.07-.27.07zm8.93 1.75c-.1.16-.26.25-.43.25-.08 0-.17-.02-.25-.07l-3.5-2c-.24-.13-.32-.44-.18-.68s.44-.32.68-.18l3.5 2c.24.13.32.44.18.68z"/></svg></div>Email</div>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <!-- Sharingbutton LinkedIn -->
                                        <a class="resp-sharing-button__link" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{ url("/?user_referral_id=".$user->id) }}&amp;title=%D8%AF%D8%B1%20%D8%B1%D8%A7%DB%8C%D8%A7%20%D8%AB%D8%A8%D8%AA%E2%80%8C%D9%86%D8%A7%D9%85%20%DA%A9%D9%86%DB%8C%D8%AF%20&amp;summary=%D8%AF%D8%B1%20%D8%B1%D8%A7%DB%8C%D8%A7%20%D8%AB%D8%A8%D8%AA%E2%80%8C%D9%86%D8%A7%D9%85%20%DA%A9%D9%86%DB%8C%D8%AF%20&amp;source=http%3A%2F%2Fdashboard.raya.webflaxco.ir%2F%3Fuser_referral_id%3D5" target="_blank" rel="noopener" aria-label="Share on LinkedIn">
                                            <div class="resp-sharing-button resp-sharing-button--linkedin resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.5 21.5h-5v-13h5v13zM4 6.5C2.5 6.5 1.5 5.3 1.5 4s1-2.4 2.5-2.4c1.6 0 2.5 1 2.6 2.5 0 1.4-1 2.5-2.6 2.5zm11.5 6c-1 0-2 1-2 2v7h-5v-13h5V10s1.6-1.5 4-1.5c3 0 5 2.2 5 6.3v6.7h-5v-7c0-1-1-2-2-2z"/></svg>
                                                </div>Linkedin</div>
                                        </a>
                                    </div>

                                    <div class="col-6">
                                        <!-- Sharingbutton WhatsApp -->
                                        <a class="resp-sharing-button__link" href="whatsapp://send?text=%D8%AF%D8%B1%20%D8%B1%D8%A7%DB%8C%D8%A7%20%D8%AB%D8%A8%D8%AA%E2%80%8C%D9%86%D8%A7%D9%85%20%DA%A9%D9%86%DB%8C%D8%AF%20%20{{ url("/?user_referral_id=".$user->id) }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp">
                                            <div class="resp-sharing-button resp-sharing-button--whatsapp resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.1 3.9C17.9 1.7 15 .5 12 .5 5.8.5.7 5.6.7 11.9c0 2 .5 3.9 1.5 5.6L.6 23.4l6-1.6c1.6.9 3.5 1.3 5.4 1.3 6.3 0 11.4-5.1 11.4-11.4-.1-2.8-1.2-5.7-3.3-7.8zM12 21.4c-1.7 0-3.3-.5-4.8-1.3l-.4-.2-3.5 1 1-3.4L4 17c-1-1.5-1.4-3.2-1.4-5.1 0-5.2 4.2-9.4 9.4-9.4 2.5 0 4.9 1 6.7 2.8 1.8 1.8 2.8 4.2 2.8 6.7-.1 5.2-4.3 9.4-9.5 9.4zm5.1-7.1c-.3-.1-1.7-.9-1.9-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.1-.2.2-.3.2-.6.1s-1.2-.5-2.3-1.4c-.9-.8-1.4-1.7-1.6-2-.2-.3 0-.5.1-.6s.3-.3.4-.5c.2-.1.3-.3.4-.5.1-.2 0-.4 0-.5C10 9 9.3 7.6 9 7c-.1-.4-.4-.3-.5-.3h-.6s-.4.1-.7.3c-.3.3-1 1-1 2.4s1 2.8 1.1 3c.1.2 2 3.1 4.9 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.7-.7 1.9-1.3.2-.7.2-1.2.2-1.3-.1-.3-.3-.4-.6-.5z"/></svg>
                                                </div>Whatsapp</div>
                                        </a>
                                    </div>

                                    <div class="col-6">
                                        <!-- Sharingbutton Telegram -->
                                        <a class="resp-sharing-button__link" href="https://telegram.me/share/url?text=%D8%AF%D8%B1%20%D8%B1%D8%A7%DB%8C%D8%A7%20%D8%AB%D8%A8%D8%AA%E2%80%8C%D9%86%D8%A7%D9%85%20%DA%A9%D9%86%DB%8C%D8%AF%20&amp;url=http%3A%2F%2Fdashboard.raya.webflaxco.ir%2F%3Fuser_referral_id%3D5" target="_blank" rel="noopener" aria-label="Share on Telegram">
                                            <div class="resp-sharing-button resp-sharing-button--telegram resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M.707 8.475C.275 8.64 0 9.508 0 9.508s.284.867.718 1.03l5.09 1.897 1.986 6.38a1.102 1.102 0 0 0 1.75.527l2.96-2.41a.405.405 0 0 1 .494-.013l5.34 3.87a1.1 1.1 0 0 0 1.046.135 1.1 1.1 0 0 0 .682-.803l3.91-18.795A1.102 1.102 0 0 0 22.5.075L.706 8.475z"/></svg>
                                                </div>Telegram</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="ft-menu"></i> خلاصه تراکنش‌های مجموعه شما</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table  table-hover table-inbox datatable-full w-100" data-ajax='/dashboard/affilatetransactions' data-columns='[{"data":"from_user"}, {"data":"amount"},{"data":"created_at"}]'>
                                        <thead class="rowlinkx thead-light">
                                            <tr>
                                                <th>کابر</th>
                                                <th>مقدار تراکنش</th>
                                                <th>تاریخ</th>
                                            </tr>
                                        </thead>
                                        <tbody class="rowlinkx" data-link="row">

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header text-center d-flex justify-content-between">
                                <h4 class="text-center"><i class="ft-dollar-sign"></i> درآمد شما</h4>

                                <div>
                                    <button type="submit" class="btn btn-warning btn-rounded convert2btc" data-toggle="modal" data-target="#convertToBTC" data-credit="{{ $wallet->cashable }}">تبدیل درآمد به بیت‌کوین</button>
                                    <button class="btn btn-primary btn-rounded deposit" data-toggle="modal" data-target="#checkoutmodal" >واریز درآمد به کیف پول</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5>درخواست‌های تبدیل درآمد به بیت‌کوین</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover table-inbox datatable-full w-100" data-ajax='/dashboard/affilatetransactions' data-columns='[{"data":"id"}, {"data":"amount"},{"data":"status"}]'>
                                        <thead class="rowlinkx thead-light" data-link="row">
                                            <tr>
                                                <th>شماره</th>
                                                <th>مقدار</th>
                                                <th>وضعیت</th
                                            </tr>
                                        </thead>
                                        <tbody class="rowlinkx" data-link="row">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include("includes.footer") 
        <script src="/assets/js/affilate.js"></script>
    </body>
</html>