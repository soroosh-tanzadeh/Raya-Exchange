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
        <title>RayaEx | تیکت جدید</title>
        <link href="/assets/css/newticket.css" rel="stylesheet" type="text/css"/>
        <style>
            .note-editor.note-frame .note-editing-area .note-editable {
                min-height: 200px;
            }
        </style>
    </head>
    <body>
        @include("includes.header")
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
            @include("includes.alert")

            <div class="card">
                <form action="javascript:;" id="newticket" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        <select class="form-control d-none"  name="priority">
                            <option value="1">کم</option>
                        </select>
                        <div class="row">
                            <div class="col-6">
                                <label for="display_name">موضوع تیکت</label>
                                <input class="form-control" id="ticketname" name="name" type="text" required>
                            </div>
                            <div class="col-6">
                                <label for="to">بخش</label>
                                <select class="form-control w-100" name="to" required="">
                                    <option value="خرید و فروش ارز">خرید و فروش</option>
                                    <option value="تبادل ارز">تبادل ارز</option>
                                    <option value="کیف پول">کیف پول</option>
                                    <option value="پشتیبانی فنی" selected>پشتیبانی فنی</option>
                                    <option value="غیره">غیره</option>
                                </select>   
                            </div>
                        </div>
                        <label for="text" class="mt-2">متن پیام</label>
                        <input name="text" type="hidden" id="tickettext">
                        <div id="editor-container">
                            <p></p>
                        </div>
                        <div class="upload-btn-wrapper">
                            <button class="btn btn-rounded" id="file-btn">بارگذاری فایل</button>
                            <input type="file" name="files[]" multiple id="file" accept="image/png, image/jpeg, application/zip, application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                        </div>

                        <div id="startupload" style="display: none">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" id="uploadprogress" role="progressbar" aria-valuenow="70"
                                     aria-valuemin="0" aria-valuenow="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <div style="display: none;" id="ticketerror">
                            <div class="alert alert-warning alert-bordered has-icon"  role="alert"><i class="la la-warning alert-icon"></i> <span id="errtext"></span></div>
                        </div>                        
                    </div>

                    <div class="card-footer text-center">
                        <button class="btn btn-primary btn-rounded px-4 mb-4" type="button" id="newTicket">ارسال تیکت</button>
                    </div>
                </form>
            </div>
        </div>
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

            $("#newTicket").click(function (e) {
                if ($("#ticketname").val() === "") {
                    $("#ticketname").addClass("is-invalid");
                    $("#ticketname").parent().find('.text-danger').remove();
                    $('<small class="text-danger">این فیلد اجباری است</small>').insertAfter("#ticketname");
                    return;
                }
                var form = document.querySelector('#newticket');
                // Populate hidden form on submit
                var html = $('#editor-container').summernote('code');
                if ($("<p>"+$('#editor-container').summernote('code')+"</p>").text().replace(/\s/g, '') != '') {
                    $("#tickettext").val(html);
                    var data = new FormData(form);
                    console.log("Submitted", $(form).serialize(), $(form).serializeArray());
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
                        url: "/dashboard/ticket/newticket",
                        data: data,
                        processData: false,
                        contentType: false,
                        type: "POST",
                        beforeSend: function (xhr) {
                            $("#startupload").show();
                            $("#newTicket").prop("disabled", true);
                        },
                        success: function (data, textStatus, jqXHR) {
                            if (data.result) {
                                window.location = data.redirect;
                            } else {
                                $("#ticketerror").show();
                                $("#errtext").text(data.msg);
                            }
                            $("#newTicket").prop("disabled", false);

                        },

                        error: function (jqXHR, textStatus, errorThrown) {
                            Swal.fire("خطا", "خطا در برقراری ارتباط!", "error");
                            $("#newTicket").prop("disabled", false);
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