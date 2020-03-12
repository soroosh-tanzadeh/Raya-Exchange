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
        <title>Raya-EX | آموزش‌ها </title><!-- GLOBAL VENDORS-->

    </head>
    <body>
        @include("includes.adminheader")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">آموزش‌ها</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">آموزش‌ها</li>
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
                                                <th>نام</th>
                                                <th>دسته‌بندی</th>
                                                <th>تاریخ انتشار</th>
                                                <th>آخرین ویرایش</th>

                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($posts as $post)
                                            <tr>
                                                <td>{{ $post->id }}</td>
                                                <td><a href="/dashboard/post/{{ $post->id}}" class="link">{{ $post->name }}</a></td>
                                                <td>{{ $post->getCategory() }}</td>
                                                <td>{{ Jalalian::forge($post->created_at)->ago() }}</td>
                                                <td>{{ Jalalian::forge($post->updated_at)->ago() }}</td>

                                                <td>
                                                    <a class="btn btn-primary" href="/admin/posts/edit/{{ $post->id }}">ویرایش</a>
                                                    <a class="btn btn-danger" href="/admin/posts/delete?id={{ $post->id }}">حذف</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        {{ $posts->links() }}
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