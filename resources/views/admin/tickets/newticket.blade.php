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
        @include("includes.adminheader")
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">تیکت ها</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">ایجاد تیکت</li>
                    </ol>
                </div>
            </div>
            <div class="card ticket-upload" style="border-radius:0px 0px 0px;">
                <div class="show-tickets card border-0">

                </div>
                <div class="specitickets">
                    <form action="/admin/ticket/newticket" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $touser }}" />
                        <div class="row m-0">
                            <div class="d-none d-sm-flex justify-content-center col-sm-2 align-items-center">
                                <button class="btn btn-primary d-flex justify-content-center align-items-center" style="height: fit-content;"><i class="fas fa-paper-plane" style="font-size: 210%;"></i></button>
                            </div>

                            <div class="col-12 col-sm-8">
                                <div class="row">
                                    <div class="col-6 px-0 py-2">
                                        <input class="form-control border-0" name="name" placeholder="موضوع تیکت">
                                    </div>
                                    <div class="col-6 px-0 py-2">
                                        <select class="form-control border-0" name="priority">
                                            <option value="-1">اولویت تیکت</option>
                                            <option value="1">کم</option>
                                            <option value="2">متوسط</option>
                                            <option value="3">بالا</option>
                                            <option value="4">بسیار بالا</option>
                                        </select>
                                    </div>
                                    <div class="col-12 px-0 py-2">
                                        <div class="part">
                                            <select class="form-control border-0 w-100" name="to">
                                                <option value="-1">بخش</option>
                                                <option value="crypto">پبشتیبانی ارز دیجیتال</option>
                                                <option value="tech">پبشتیبانی فنی</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 px-0 pt-2 pb-4">
                                        <div class="message ">
                                            <textarea class="form-control border-0" name="text" placeholder="پیام خود را وارد کنید..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-2 justify-content-center align-items-center d-flex py-sm-0 py-3">
                                <input type="file" id="pin" name="files[]" multiple style="display: none;"><p onclick="$('#pin').click();" class="mx-2 mx-sm-0"><i class="fas fa-paperclip" style="font-size: 210%;"></i></p>
                                <div class="d-block d-sm-none">
                                    <button class="btn btn-primary d-flex justify-content-center align-items-center" id="sendTicket" type="submit"><i class="fas fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include("includes.footer")

    </body>
</html>