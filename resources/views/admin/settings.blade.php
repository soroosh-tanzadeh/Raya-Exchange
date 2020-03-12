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
use App\Activity;

$activities = Activity::getActivities();
?>
<html lang="en">
    <head>
        @include("includes.head")
        <title>Raya-EX | داشبورد</title><!-- GLOBAL VENDORS-->
    </head>
    <body>
        @include("includes.adminheader")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">داشبورد</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">تنطیمات</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="/admin/save-settings" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        @foreach($options as $option)
                                        <div class="col-md-4 my-2">
                                            <label>{{ $option->label }}</label>
                                            <input class="form-control" type='number' step="0.01" name="key[{{ $option->key }}]" value="{{ $option->value }}" required />
                                        </div>
                                        @endforeach
                                    </div>
                                    <input class="btn btn-primary mt-2" type="submit" value="ثبت اطلاعات" />
                                </form>
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