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
                        <li class="breadcrumb-item">تیکت شماره  {{ $ticket->id }}</li>
                    </ol>
                </div>
            </div>
            <div class="my-2">
                <a class="btn btn-danger mx-3" href="/admin/ticket/close?ticket={{ $ticket->id   }}">بستن تیکت</a>
            </div>
            <div class="ticketchat"  style="border-radius:0px 0px 0px;background:#F7F7F7;">
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
                                    <span class="text-warning">
                                        {{ $ticket->status }}
                                    </span>
                                    @else
                                    <span class="text-danger">
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

                        @if($message->from !== '-1')
                        <div class="col-md-12">
                            <div class="card-message my-2 pr-0"> 
                                <div class="p-3">
                                    {!! $message->text !!}
                                </div>
                                <div class="d-flex">
                                    @foreach($message->getFiles() as $file)
                                    <a href="{{ $file->link }}?name={{ $file->name }}" class="ml-2 pb-1 text-primary" target="_blank" ><i class="fas mx-1 fa-paperclip"></i>{{ $file->name }} </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-md-12">
                            <div class="card-message-2 my-2 pr-0"> 
                                <div class="p-3">
                                    {!! $message->text !!}
                                </div>
                                <div class="d-flex">
                                    @foreach($message->getFiles() as $file)
                                    <a href="{{ $file->link }}?name={{ $file->name }}" class="ml-2 pb-1 text-primary" target="_blank" ><i class="fas mx-1 fa-paperclip"></i>{{ $file->name }} </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="bg-white p-3">
                    <input type="submit" value="ارسال پاسخ" class="btn btn-success" onclick="$('#sendmsg').slideDown();$(this).hide(1000)" />
                    <form action="/admin/ticket/{{ $ticket->id }}/sendmessage" method="POST" enctype="multipart/form-data" style="display: none" id='sendmsg' class="bg-white p-3">
                        @csrf
                        <select class="form-control border-0 d-none"  name="priority">
                            <option value="1">کم</option>
                        </select>
                        <label for="text" class="mt-2">پیام</label>
                        <input name="text" type="hidden" id="tickettext">
                        <div id="editor-container">
                            <p></p>
                        </div>
                        <div class="col-12 py-2">
                            <h4>ضمینه</h4>
                            <p class="text-muted">امکان انتخاب چند فایل وجود دارد</p>
                            <input type="file" id="pin" name="files[]" multiple>
                            <div class="d-block d-sm-none">
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary float-left" type="submit">ارسال پیام</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- END: Quick sidebar-->
        @include("includes.footer")
        <script>
            $('#editor-container').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]
            });
            var form = document.querySelector('#sendmsg');
            form.onsubmit = function () {
                // Populate hidden form on submit
                var html = $('#editor-container').summernote('code');
                $("#tickettext").val(html);
                return true;
            };
        </script>
    </body>
</html>