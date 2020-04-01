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
        <title>Raya-EX | کاربر</title><!-- GLOBAL VENDORS-->

    </head>
    <body>
        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">پروفایل شما</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">پروفایل</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $profile->name }}</h4>
                            </div>
                            <div class="card-body">
                                <form data-action="/admin/edituser" action="javascript:;" data-btn="#useredit" onsubmit="submitAjaxForm(this);" method="POST" id="userform">
                                    @csrf
                                    @if($user->is_admin)
                                    <input type="hidden" name="user_id" value="{{ $profile->id }}">
                                    @endif
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label>نام و نام‌خانوادگی</label>
                                                <input type="text" class="form-control" name="name" required value="{{ $profile->name }}" @if(!$user->is_admin) readonly="readonly" @endif />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <label>کد ملی</label>
                                                <input type="text" class="form-control" name="nationalcode" required value="{{ $profile->nationalcode }}" @if(!$user->is_admin) readonly="readonly" @endif />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">
                                                <label>تلفن ثابت</label>
                                                <input type="text" class="form-control" name="telephone" pattern="^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$" title="تلفن ثابت نامعتبر است." required value="{{ $profile->telephone }}" @if(!$user->is_admin) readonly="readonly" @endif />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">
                                                <label>ایمیل</label>
                                                <input type="email" class="form-control" name="email" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" title="ایمیل نامعتبر است." required value="{{ $profile->email }}" @if(!$user->is_admin) readonly="readonly" @endif />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">
                                                <label>تلفن همراه</label>
                                                <input type="text" class="form-control" name="phone_number" pattern="^(\+98|0)?9\d{9}$" title="شماره تلفن همراه نامعتبر است." required value="{{ $profile->phone_number }}" @if(!$user->is_admin) readonly="readonly" @endif />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">
                                                <label>کدپستی</label>
                                                <input type="text" class="form-control" name="postalcode" required value="{{ $profile->postalcode }}" @if(!$user->is_admin) readonly="readonly" @endif />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">
                                                <label>استان</label>
                                                <input type="text" class="form-control" name="province" required value="{{ $profile->province }}" @if(!$user->is_admin) readonly="readonly" @endif />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">
                                                <label>شهر</label>
                                                <input type="text" class="form-control" name="city" required value="{{ $profile->city }}" @if(!$user->is_admin) readonly="readonly" @endif />
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-4">
                                            <div class="form-group mb-1">
                                                <label>آدرس</label>
                                                <textarea class="form-control" rows="3" cols="20" required name="address" @if(!$user->is_admin) readonly="readonly" @endif>
                                                          {{ $profile->address }}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class=" mt-4">
                                <?php
                                $files = json_decode($profile->files);
                                ?>
                                @if($files !== null)
                                <h4>مدارک</h4>
                                <div class="row">
                                    @foreach($files as $file)
                                    <div class="col-md-4 p-2">
                                        <img src="{{ url($file) }}" style="width: 100%"/>
                                    </div>
                                    @endforeach
                                </div>
                                @endif

                            </div> 
                        </div>
                        @if($user->is_admin)
                        <div class="card-footer justify-content-end d-flex">
                            <input type="button" id="useredit" class="btn btn-dark mx-2 btn-rounded" data-user="{{ $profile->id }}" value="ویرایش مشخصات" />
                            @if($user->id !== $profile->id)
                            <input type="button" class="comfirmuser btn btn-success btn-rounded" data-user="{{ $profile->id }}" value="تایید کاربر" />
                            <a href="/admin/tickets/new?user={{ $profile->id }}" class="btn btn-warning btn-rounded mx-2 text-white" >ارسال تیکت</a>
                            @endif
                        </div>
                        @else
                        <div class="card-footer justify-content-end d-flex">
                            @if($user->verified_at === null && $user->files !== null)
                            <p class="text-warning">اطلاعات شما ثبت شده و در دست بررسی قرار دارد پس از تایید به شما اطلاع داده می‌شود.</p>
                            @elseif($user->verified_at === null)
                            <a type="submit" class="btn btn-primary btn-rounded" href="/dashboard/signup" >تکمیل اطلاعات کاربری</a>
                            @else
                            <a class="btn btn-primary btn-rounded" href="/dashboard/changeinfo">درخواست تغییر اطلاعات</a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <!-- END: Page content-->
    <!-- END: Quick sidebar-->
    @include("includes.footer")
    <script src="/assets/js/profile.js"></script>
</body>
</html>