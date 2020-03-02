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
        <title>RayaEx | تیکت شماره - {{ $ticket->id }}</title>
    </head>
    <body>
        @include("includes.header")
        <?php
        $messages = $ticket->getMessages();
        ?>
        <!-- BEGIN: Content-->
        <!-- END: Header-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">داشبورد</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">تیکت شماره 127</li>
                    </ol>
                </div>
                <div class="shadow d-none d-sm-block" style="background:#FDA424;"><h6 class="p-2"><a style="text-align:right;text-decoration:none;color:#ffffff;" href="#">بازگشت به لیست</a></h6></div>
            </div>
            <div class="ticketchat d-none d-md-block"  style="border-radius:0px 0px 0px;background:#F7F7F7;">
                <div class="bodyticketchat">
                    <table class="aboutticket w-100">
                        <thead>
                            <tr>
                                <th>
                                    @if($ticket->type === 1)
                                    <span class="text-warning">
                                        {{ $ticket->status }}
                                    </span>
                                    @elseif($ticket->type === 2)
                                    <span class="text-green">
                                        {{ $ticket->status }}
                                    </span>
                                    @else
                                    <span class="text-green">
                                        {{ $ticket->status }}
                                    </span>
                                    @endif
                                </th>
                                <th>{{ $ticket->to }}</th>
                                <th>{{ $ticket->name }}</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="row chat m-0">
                        @foreach($messages as $message)

                        @if($message->from !== -1)
                        <div class="col-md-2">
                            <div class="img d-flex h-100 flex-column justify-content-center align-items-center">
                                <img src="/assets/img/users/admin-image.png" width="200" class="rounded-circle mt-3" style="max-width: 100px" alt=""/>
                                <h6 class="text-muted d-flex justify-content-center align-items-center mt-2">{{ $user->first_name }} {{ $user->last_name }}‌</h6>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="card-message mr-2 my-2 mt-3"> 
                                <div class="text-message pb-3">
                                    <p class="px-4 pt-4 pb-1">{{ $message->text }}</p>
                                    <div class="d-flex">
                                        @foreach($message->getFiles() as $file)
                                        <a href="{{ $file->link }}?name={{ $file->name }}" class="ml-2 pb-1 text-primary" target="_blank" ><i class="fas mx-1 fa-paperclip"></i>{{ $file->name }} </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-md-10">
                            <div class="card-message-2 mr-2 my-2 mt-3">
                                <div class="text-message-2">
                                    <p class="px-4 pt-4 pb-1">{{ $message->text }}</p>
                                    <div class="d-flex">
                                        @foreach($message->getFiles() as $file)
                                        <a href="{{ $file->link }}?name={{ $file->name }}" class="ml-2 pb-1 text-primary" target="_blank" ><i class="fas mx-1 fa-paperclip"></i>{{ $file->name }} </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="img d-flex h-100 flex-column justify-content-center align-items-center">
                                <img src="/assets/img/users/admin-image.png" width="200" style="max-width: 100px" class="rounded-circle mt-3" alt=""/>
                                <h6 class="text-muted mt-2 d-flex justify-content-center align-items-center">پرسنل</h6>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <form action="/dashboard/ticket/{{ $ticket->id }}/sendmessage" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row m-0">
                        <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-primary d-flex justify-content-center align-items-center"><i class="fas fa-paper-plane"></i></button>
                        </div>
                        <div class="col-10">
                            <textarea class="form-control border-0 my-2" name="text" placeholder="پیام خود را وارد کنید..."></textarea>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <div class=" col-1"><input type="file" name="files[]" multiple id="pin" style="display: none;"><h4 onclick="$('#pin').click();"><i class="fas fa-paperclip"></i></h4></div>
                        </div>
                    </div>
                </form>
            </div>
            <!--- ----------------------------------------------->
            <div class="bodyticketchat-mobo card d-block d-md-none">
                <div class="ticketchat-mobo">
                    <div class="row m-0">
                        <div class="col-3">
                            <div class="img h-100 flex-column d-flex justify-content-center align-items-center">
                                <div class="img d-flex justify-content-center align-items-center">
                                    <img src="/assets/img/users/admin-image.png" width="200" class=" rounded-circle mt-3" alt=""/>
                                </div>
                                <h6 class="text-muted mt-2 d-flex justify-content-center align-items-center ">کاربر</h6>
                            </div>

                        </div>
                        <div class="col-8">
                            <div class="card-mobomessage mt-3">
                                <div class="text-mobomessage">
                                    <p class="p-2">
                                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه 
                                        و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای 

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card-mobomessage2 mt-3">
                                <div class="text-mobomessage">
                                    <p class="p-2">
                                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه 
                                        و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای 

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="img h-100 flex-column d-flex justify-content-center align-items-center">
                                <img src="/assets/img/users/admin-image.png" width="200" class=" rounded-circle mt-3" alt=""/>
                                <h6 class="text-muted mt-2 d-flex justify-content-center align-items-center ">پرسنل</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row m-0">
                    <div class="col-2 pt-4">
                        <button class="btn btn-primary d-flex justify-content-center align-items-center"><i class="fas fa-paper-plane"></i></button>
                    </div>
                    <div class="col-8 my-3">
                        <textarea class="form-control border-0" placeholder="پیام خود را وارد کنید..."></textarea>
                    </div>
                    <div class="col-2 pt-4">
                        <input type="file" id="pin" style="display: none;" ><h4 onclick="$('#pin').click();"><i class="fas fa-paperclip"></i></h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Quick sidebar-->
        @include("includes.footer")

    </body>
</html>