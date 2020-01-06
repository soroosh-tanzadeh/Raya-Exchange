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
                            <div class="card-body">
                                <div class="media w-100"><i class="cc BTC-alt font-40 text-warning mr-4"></i>
                                    <div class="media-body">
                                        <div class="mb-2 text-muted font-16">کیف پول بیت کوین</div> 
                                        <div class="d-flex" style="word-break:break-word"><span class="h5 mb-0 font-20"><span>{{ $coinWallets['BTC']->credit }}</span><span class="font-weight-normal">BTC</span></span><span class="mx-3"></span>قابل برداشت : ‌{{ $coinWallets['BTC']->cashable }}</div>
                                        <hr>
                                        <div><a class="btn btn-danger btn-sm btn-rounded ml-4" href="#">برداشت</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="media w-100"><i class="cc ETH-alt font-40 text-primary mr-4"></i>
                                    <div class="media-body">
                                        <div class="mb-2 text-muted font-16">کیف پول اتریم</div>
                                        <div class="d-flex" style="word-break:break-word"><span class="h5 mb-0 font-20"><span>{{ $coinWallets['ETH']->credit }}</span><span class="font-weight-normal">ETH</span></span><span class="mx-3">قابل برداشت : ‌{{ $coinWallets['ETH']->cashable }}</span></div>
                                        <hr>
                                        <div><a class="btn btn-danger btn-sm btn-rounded ml-4" href="#">برداشت</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body media">
                                <div class="media w-100"><i class="cc LTC-alt font-40 text-secondary mr-4"></i>
                                    <div class="media-body">
                                        <div class="mb-2 text-muted font-16">کیف پول لایت کوین</div>
                                        <div class="d-flex" style="word-break:break-word"><span class="h5 mb-0 font-20"><span>{{ $coinWallets['LTC']->credit }}</span><span class="font-weight-normal">LTC</span></span><span class="mx-3">قابل برداشت : ‌{{ $coinWallets['LTC']->cashable }}</span></div>
                                        <hr>
                                        <div><a class="btn btn-danger btn-sm btn-rounded ml-4" href="#">برداشت</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body media">
                                <div class="media w-100"><i class="cc XRP-alt font-40 text-primary mr-4"></i>
                                    <div class="media-body">
                                        <div class="mb-2 text-muted font-16">کیف پول ریپل</div>
                                        <div class="d-flex" style="word-break:break-word"><span class="h5 mb-0 font-20"><span>{{ $coinWallets['XRP']->credit }}</span><span class="font-weight-normal">XRP</span></span><span class="mx-3">قابل برداشت : ‌{{ $coinWallets['XRP']->cashable }}</span></div>
                                        <hr>
                                        <div><a class="btn btn-danger btn-sm btn-rounded ml-4" href="#">برداشت</a></div>
                                    </div>
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
                                <hr>
                                <div class="flexbox"><a data-toggle="modal" data-target="#paymodal" href="#paymodal">واریز</a><a class="text-warning" href="#">درخواست تسویه</a></div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-4">
                                    <div>
                                        <h5 class="box-title mb-0">آخرین تراکنش ها</h5>
                                    </div><a class="text-muted" href="#"><i class="ti-more-alt"></i></a>
                                </div>
                                <div class="card-fullwidth-block">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="pl-4">واحد پول</th>
                                                    <th>مبلغ</th>
                                                    <th class="pr-4">نوع</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transactions as $transaction)
                                                <tr>
                                                    <td class="pl-4"><b>{{ $transaction->coin }}</b></td>
                                                    <td>{{ $transaction->amount}}</td>
                                                    <td class="text-success">{{ $transaction->type }}</td>
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
            </div><!-- END: Page content-->
        </div><!-- BEGIN: Footer-->

        @include("includes.footer") 
    </body>
</html>