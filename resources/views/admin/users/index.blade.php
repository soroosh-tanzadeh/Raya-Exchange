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
        <title>Raya-EX | تراکنش‌های ریالی </title><!-- GLOBAL VENDORS-->

    </head>
    <body>
        @include("includes.adminheader")
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
                            <div class="card-body">
                                <div class="table-responsive font-11">
                                    <table class="table table-hover compact-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>شماره</th>
                                                <th>نام و نام‌خانوادگی</th>
                                                <th>شماره موبایل</th>
                                                <th>شماره ایمیل</th>
                                                <th>تاریخ ثبت‌نام</th>
                                                <th>وضعیت تایید</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>
                                                    <a href="/admin/users/{{ $user->id }}"> <b>{{ $user->name }}</b> </a>
                                                </td>
                                                <td>
                                                    <b>{{ $user->phone_number }}</b>
                                                </td>
                                                <td>
                                                    <b>{{ $user->email }}</b>
                                                </td>
                                                <td>{{ Jalalian::forge($user->created_at)->ago() }}</td>
                                                <td>
                                                    @if($user->verified_at != null)
                                                    <text class="text-success">تایید شده</text>
                                                    @else
                                                    <text class="text-warning">تایید نشده</text>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        {{ $users->links() }}
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Page content-->
        <!-- END: Quick sidebar-->
        @include("includes.footer")
    </body>
</html>