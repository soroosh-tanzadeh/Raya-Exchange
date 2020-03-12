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
                    <h1 class="page-title page-title-sep">کابران</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">کاربران</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>کاربر شماره {{ $profile->id }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>نام و نام‌خانوادگی</label>
                                        <input type="text" class="form-control" name="" value="{{ $profile->name }}" readonly="readonly" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>شماره ملی</label>
                                        <input type="text" class="form-control" name="" value="{{ $profile->nationalcode }}" readonly="readonly" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>شماره تماس</label>
                                        <input type="text" class="form-control" name="" value="{{ $profile->phone_number }}" readonly="readonly" />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <label>استان</label>
                                        <input type="text" class="form-control" name="" value="{{ $profile->province }}" readonly="readonly" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>شهر</label>
                                        <input type="text" class="form-control" name="" value="{{ $profile->city }}" readonly="readonly" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>آدرس</label>
                                        <textarea class="form-control" rows="3" cols="20" readonly="readonly">
                                            {{ $profile->address }}
                                        </textarea>
                                    </div>
                                </div>
                                <div class=" mt-4">
                                    <h4>مدارک</h4>
                                    <div class="row">
                                        <?php
                                        $files = json_decode($profile->files);
                                        ?>
                                        @foreach($files as $file)
                                        <div class="col-md-4 p-2">
                                            <img src="{{ url($file) }}" style="width: 100%"/>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @if($user->is_admin)
                            <div class="card-footer justify-content-end d-flex">
                                <input type="submit" class="comfirmuser btn btn-success" data-user="{{ $profile->id }}" value="تایید کاربر" />
                                <a href="/admin/tickets/new?user={{ $profile->id }}" class="btn btn-warning mx-2 text-white" >ارسال تیکت</a>
                            </div>
                            @else
                            <div class="card-footer">
                                @if($user->verified_at === null)
                                <p class="text-warning">اطلاعات شما ثبت شده و در دست بررسی قرار دارد پس از تایید به شما اطلاع داده می‌شود.</p>
                                @endif
                                <input type="submit" class="editInfo btn btn-success" data-user="{{ $profile->id }}" value="درخواست تغییر اطلاعات" />
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