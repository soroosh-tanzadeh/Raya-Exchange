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
        <link href="/assets/css/newticket.css" rel="stylesheet" type="text/css"/>
        <style>
            .note-editor.note-frame .note-editing-area .note-editable {
                min-height: 200px;
            }
        </style>
    </head>
    <body>
        @include("includes.header")
        <?php
        $messages = $ticket->getMessages();

        use Morilog\Jalali\Jalalian;
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


            <div class="card">
                <div class="card-header py-3 d-block">
                    <h5 class="box-title mb-2">تیکت شماره {{ $ticket->id }}</h5>
                    <div class="text-muted font-13"><i class="ft-clock" style="vertical-align: middle"></i> آخرین بروزرسانی :  {{ Jalalian::forge($ticket->updated_at)->ago()}} </div>
                </div>
                <div class="card-body">

                    <div class="row mb-4">
                        <div class="col">
                            <div class="media p-4 align-items-center" style="background-color: #e3e3f2; border-radius: 8px"><i class="ft-mail align-self-center mr-4 font-30"></i>
                                <div class="media-body">
                                    <h6 class="mb-0x font-weight-bold">موضوع</h6>
                                    <div class="text-muted font-13">  
                                        {{ $ticket->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="media p-4 align-items-center" style="background-color: #e3e3f2; border-radius: 8px"><i class="ft-layers align-self-center mr-4 font-30"></i>
                                <div class="media-body">
                                    <h6 class="mb-0x font-weight-bold">بخش</h6>
                                    <div class="text-muted font-13">  
                                        {{ $ticket->to }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="media p-4 align-items-center" style="background-color: #e3e3f2; border-radius: 8px"><i class="ft-user align-self-center mr-4 font-30"></i>
                                <div class="media-body">
                                    <h6 class="mb-0x font-weight-bold">وضعیت</h6>
                                    <div class="text-muted font-13">  
                                        @if($ticket->type === '1')
                                        <span class="text-success">
                                            {{ $ticket->status }}
                                        </span>
                                        @elseif($ticket->type === '2')
                                        <span class="text-warning">
                                            {{ $ticket->status }}
                                        </span>
                                        @else
                                        <span class="text-danger">
                                            {{ $ticket->status }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row chat m-0">
                        @foreach($messages as $message)
                        @if(!$message->is_admin)
                        <div class="col-md-12">

                            <div class="card-message mr-2 my-2 mt-3"> 
                                <div class="text-message pb-3">
                                    <h6>کاربر</h6>
                                    <div class="p-3">
                                        {!! $message->text !!}
                                    </div>
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
                            <div class="card-message-2 mr-2 my-2 mt-3">
                                <div class="text-message-2">
                                    <?php
                                    $sender = $message->getSender();
                                    ?>
                                    <h6 class="p-2">{{ $sender->name }}</h6>
                                    <div class="p-3">
                                        {!! $message->text !!}
                                    </div>
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
                <div class="card-footer">
                    <div class=" text-center w-100">
                        <input type="submit" value="ارسال پاسخ" class="btn btn-success btn-rounded" onclick="$('#sendmsg').slideDown();$(this).hide(1000)" />
                    </div>
                    <form action="javascript:;" method="POST" enctype="multipart/form-data" style="display: none" id='sendmsg'>
                        @csrf
                        <select class="form-control border-0 d-none"  name="priority">
                            <option value="1">کم</option>
                        </select>
                        <label for="text" class="mt-2">متن پیام</label>
                        <input name="text" type="hidden" id="tickettext">
                        <div id="editor-container">
                            <p></p>
                        </div>

                        <div id="startupload" style="display: none">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" id="uploadprogress" role="progressbar" aria-valuenow="70"
                                     aria-valuemin="0" aria-valuenow="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                        <div class="py-2 clickable">
                            <div class="upload-btn-wrapper">
                                <button class="btn btn-rounded" id="file-btn">بارگذاری فایل</button>
                                <input type="file" name="files[]" multiple id="file" accept="image/png, image/jpeg, application/zip, application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                            </div>
                        </div>

                        <div style="display: none;" id="ticketerror">
                            <div class="alert alert-warning alert-bordered has-icon"  role="alert"><i class="la la-warning alert-icon"></i> <span id="errtext"></span></div>
                        </div>

                        <div class="clearfix w-100 border-top p-3 text-center">
                            <button class="btn btn-primary btn-rounded" id="sendbtn" type="button">ارسال پیام</button>
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

            $("#file").change(function (e) {
                var fileName = e.target.files.length;
                $("#file-btn").text(fileName + " فایل انتخاب شده")

            })

            $(".form-control").change(function () {
                if (this.hasAttribute("pattern")) {
                    var regex = new RegExp($(this).attr("pattern"));
                    if ((regex.test($(this).val()))) {
                        $(this).removeClass("is-invalid");
                        $(this).parent().find('.text-danger').remove();
                        $(this).addClass("is-valid");
                    } else {
                        $(this).addClass("is-invalid");
                        $(this).parent().find('.text-danger').remove();
                        $('<small class="text-danger">' + $(this).attr("title") + '</small>').insertAfter(this);
                    }
                } else {
                    $(this).removeClass("is-invalid");
                    $(this).parent().find('.text-danger').remove();

                }
            });

            $("#sendbtn").click(function (e) {
                $("#ticketerror").hide();
                var form = document.querySelector('#sendmsg');
                // Populate hidden form on submit
                var html = $('#editor-container').summernote('code');
                if ($("<p>" + $('#editor-container').summernote('code') + "</p>").text().replace(/\s/g, '') != '') {
                    $("#tickettext").val(html);
                    var data = new FormData(form);
                    $.ajax({
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();

                            xhr.upload.addEventListener("progress", function (e) {
                                if (e.lengthComputable) {
                                    var percetaget = parseInt((e.loaded / e.total) * 100);
                                    $("#uploadprogress").attr("aria-valuenow", percetaget)
                                    $("#uploadprogress").attr("style", "width: " + percetaget + "%");
                                    $("#uploadprogress").text(percetaget + "%");
                                }
                            });

                            return xhr;
                        },
                        url: "/admin/ticket/{{ $ticket->id }}}/sendmessage",
                        data: data,
                        processData: false,
                        contentType: false,
                        type: "POST",
                        beforeSend: function (xhr) {
                            $("#startupload").show();
                            $("#sendbtn").prop("disabled", true);
                        },
                        success: function (data, textStatus, jqXHR) {
                            if (data.result) {
                                window.location = data.redirect;
                            } else {
                                $("#ticketerror").show();
                                $("#errtext").text(data.msg);
                            }
                            $("#sendbtn").prop("disabled", false);

                        },

                        error: function (jqXHR, textStatus, errorThrown) {
                            $("#startupload").hide();
                            $("#ticketerror").hide();
                            Swal.fire("خطا", "خطا در برقراری ارتباط!", "error");
                            $("#sendbtn").prop("disabled", false);
                        }
                    });
                } else {
                    Swal.fire("اخطار", "متن پیام اجباری است", "warning");
                }
                return false;
            });
        </script>
    </body>
</html>