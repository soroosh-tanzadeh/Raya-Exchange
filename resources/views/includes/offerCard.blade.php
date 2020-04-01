<?php

use App\Wallet;

$offerablecoins = Wallet::where("type", "coin")->where("user_id", session()->get("user")->id)->get();
$wcoins = Wallet::getCoins();
?>

<style>
    .left-toman{
        padding-left: 68px !important;
    }
</style>

<div class="card card-fullheight">
    <div class="card-header p-0">
        <ul class="nav line-tabs nav-justified line-tabs-2x line-tabs-solid w-100">
            <li class="nav-item"><a data-toggle="tab" href="#menu1" class="nav-link w-100 justify-content-center active show" style="border-top-right-radius: 0.6rem;">پیشنهاد فروش</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#menu2" class="nav-link w-100 justify-content-center" style="border-top-left-radius: 0.6rem;">پیشنهاد خرید</a></li>
        </ul>                                
    </div>

    <div class="card-body">
        <div class="tab-content h-100">
            <div id="menu1" class="tab-pane fade active h-100 show"> 
                <form action='javascript:;' data-btn=".new-offer" onsubmit="submitAjaxForm(this);" novalidate id="selloffercoinform" method="POST" data-action="/dashboard/newoffer" style="display: flex;flex-direction: column;height: 100%;" method="POST">
                    <div style="flex: 1 1 auto;">
                        <div class="alert alert-primary alert-bordered" role="alert">
                            <h5>کاربر عزیز</h5>
                            <p class="mb-0">
                                1- قیمت پیشنهادی ما همیشه با توجه نوسانات قیمت جهانی ارزهای  دیجیتال و با نسبت ثابت تغییر خواهد کرد

                                .
                            </p><p class="mb-0">
                                2- قیمت پیشنهادی ما همیشه ۱٪ بیشتر از قیمت جهانی ارز انتخابی خواهد بود.

                            </p>
                        </div>
                        @csrf
                        <input type="hidden"  value="sell" name="type"/>
                        <div class="form-group mb-5">
                            <div class="form-row mt-1">
                                <div class="col-md">
                                    <div style="width: 100%;" class="mt-2 mb-3">
                                        <select required name="coin" class="form-control coins_select" style="width: 100%">
                                            <option value=""></option>
                                            @foreach($offerablecoins as $offerablecoin)
                                            @if(isset($wcoins[strtoupper($offerablecoin->type_name)]))

                                            @if($offerablecoin->type_name === "btc")
                                            <option value="{{ strtolower($offerablecoin->name) }}" selected data-symbol="{{ strtoupper($offerablecoin->type_name) }}" data-price="{{ $wcoins[strtoupper($offerablecoin->type_name)]->price_in_toman_int }}" data-icon="{{ url("/assets/icons/".strtolower($offerablecoin->type_name).".png") }}">{{ $offerablecoin->name }}</option>
                                            @else
                                            <option value="{{ strtolower($offerablecoin->name) }}" data-symbol="{{ strtoupper($offerablecoin->type_name) }}" data-price="{{ $wcoins[strtoupper($offerablecoin->type_name)]->price_in_toman_int }}" data-icon="{{ url("/assets/icons/".strtolower($offerablecoin->type_name).".png") }}">{{ $offerablecoin->name }}</option>
                                            @endif

                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control numeric" type="text" name="coinـnum" required id="coin-num" placeholder="مقدار">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control numeric" type="text"  name="mincoin" required placeholder="حداقل سفارش">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group-icon input-group-icon-right w-100 my-2">
                                            <div class="input-group">
                                                <input class="form-control price-seprator left-toman" type="text" placeholder="قیمت پیشنهادی شما" required name="price_toman" id="offerprice">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" style="background: #0db7ba;color: white;position: absolute;left: 0px;z-index: 999;border: none;top: 1px;border-top-left-radius: 3px;border-bottom-left-radius: 3px;">تومان</span>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted" id="priceINTOMAN" style="visibility: hidden;font-family: Robotic;"> 
                                                <span style="float:right;">قیمت پیشنهادی ما برای</span> <span id="price-toman"></span>
                                            </small>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-1 d-inline-flex justify-content-center align-items-center"><i class="fas fa-exchange-alt text-muted font-16"></i></div>
                                <div class="col-md d-flex justify-content-center align-items-center"> 
                                    <div class="form-group mb-0 w-100" style="margin-top: calc(17px + 0.25rem)"> 
                                        <input class="form-control price-seprator" id="totalsellprice" type="text" placeholder="مبلغی که شما از RayaEX دریافت می‌کنید" readonly>
                                        <small class="form-text text-success">   مبلغی که شما از فروش <span id="selloffercoin" style="font-family: Robotic;"></span>  دریافت می‌کنید</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center border-top" style="padding: 1.3rem 1.8rem;padding-bottom: 0;margin-left: -1.8rem;margin-right: -1.8rem;border-color: rgba(0,0,0,.125);">
                        <div>
                            <button class="btn btn-danger btn-rounded new-offer" type="submit" style="min-width: 200px">ایجاد پیشنهاد</button>
                        </div>
                    </div>                                       
                </form>
            </div>
            <div id="menu2" class="tab-pane h-100">
                <form action='javascript:;' data-btn=".new-offer" onsubmit="submitAjaxForm(this);" id="buyoffercoinform" novalidate method="POST" data-action="/dashboard/newoffer" style="display: flex;flex-direction: column;height: 100%;" method="POST">
                    <div style="flex: 1 1 auto;">
                        <div class="alert alert-primary alert-bordered" role="alert">
                            <h5>کاربر عزیز</h5>
                            <p class="mb-0">
                                1- قیمت پیشنهادی ما همیشه با توجه نوسانات قیمت جهانی ارزهای  دیجیتال و با نسبت ثابت تغییر خواهد کرد.
                            </p><p class="mb-0">
                                2- قیمت پیشنهادی ما همیشه ۱٪ کمتر از قیمت جهانی ارز انتخابی خواهد بود.
                            </p>
                        </div>
                        @csrf
                        <input type="hidden"  value="buy" name="type"/>
                        <div class="form-group mb-5">
                            <div class="form-row mt-1">
                                <div class="col-md">                                                        
                                    <div style="width: 100%;" class="mt-2 mb-3">
                                        <select required name="coin" class="form-control coins_select" style="width: 100%">
                                            <option value=""></option>
                                            @foreach($offerablecoins as $offerablecoin)

                                            @if($offerablecoin->type_name === "btc")
                                            <option value="{{ strtolower($offerablecoin->name) }}" selected data-symbol="{{ strtoupper($offerablecoin->type_name) }}" data-price="{{ $wcoins[strtoupper($offerablecoin->type_name)]->price_in_toman_int }}" data-icon="{{ url("/assets/icons/".strtolower($offerablecoin->type_name).".png") }}">{{ $offerablecoin->name }}</option>
                                            @else
                                            <option value="{{ strtolower($offerablecoin->name) }}" data-symbol="{{ strtoupper($offerablecoin->type_name) }}" data-price="{{ $wcoins[strtoupper($offerablecoin->type_name)]->price_in_toman_int }}" data-icon="{{ url("/assets/icons/".strtolower($offerablecoin->type_name).".png") }}">{{ $offerablecoin->name }}</option>
                                            @endif

                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control numeric" type="text" name="coinـnum" required id="coinbuy-num" placeholder="مقدار">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control numeric" type="text"  name="mincoin" required placeholder="حداقل سفارش">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 d-inline-flex justify-content-center align-items-center"><i class="fas fa-exchange-alt text-muted font-16"></i></div>
                                <div class="col-md d-flex justify-content-center align-items-center"> 
                                    <div class="form-group mb-0 w-100" style="margin-top: 17px">
                                        <div class="input-group">
                                            <input class="form-control price-seprator left-toman" type="text" placeholder="قیمت پیشنهادی شما" required name="price_toman">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="background: #0db7ba;color: white;position: absolute;left: 0px;z-index: 999;border: none;top: 1px;border-top-left-radius: 3px;border-bottom-left-radius: 3px;">تومان</span>
                                            </div>
                                        </div>
                                        <small class="form-text text-success" id="priceINTOMANBUY" style="visibility: hidden;font-family: Robotic;">
                                            <span style="float:right;">قیمت پیشنهادی ما برای</span> <span id="pricebuy-toman"></span>
                                        </small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row border-top justify-content-center align-items-center" style="padding: 1.3rem 1.8rem;padding-bottom: 0;margin-left: -1.8rem;margin-right: -1.8rem;border-color: rgba(0,0,0,.125);">
                        <div>
                            <button class="btn btn-danger btn-rounded new-offer" type="submit" style="min-width: 200px">ایجاد پیشنهاد</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
