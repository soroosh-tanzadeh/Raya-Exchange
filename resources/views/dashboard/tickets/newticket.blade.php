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
            <div class="card p-4" style="border-radius:0px 0px 0px;">
                <div class="card-body">
                    <form action="javascript:;" id="newticket" method="POST" enctype="multipart/form-data">
                        @csrf
                        <select class="form-control border-0 d-none"  name="priority">
                            <option value="1">کم</option>
                        </select>
                        <div class="row">
                            <div class="col-6">
                                <label for="display_name">موضوع تیکت</label>
                                <input class="form-control" name="name" type="text" required="">
                            </div>
                            <div class="col-6">
                                <label for="to">بخش</label>
                                <select class="form-control border-0 w-100" name="to" required="">
                                    <option value="" disabled selected>بخش</option>
                                    <option value="خرید و فروش">خرید و فروش</option>
                                    <option value="تبادل ارز">تبادل ارز</option>
                                    <option value="پشتیبانی فنی">پشتیبانی فنی</option>
                                    <option value="غیره">غیره</option>
                                </select>
                            </div>
                        </div>
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
                            <button class="btn btn-primary float-left" type="submit">ارسال تیکت</button>
                        </div>                        
                    </form>
                </div>
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
            var form = document.querySelector('#newticket');
            form.onsubmit = function () {
                // Populate hidden form on submit
                var html = $('#editor-container').summernote('code');
                $("#tickettext").val(html);
                console.log("Submitted", $(form).serialize(), $(form).serializeArray());
                $.ajax({
                    url: "/dashboard/ticket/newticket",
                    data: $(form).serialize(),
                    type: "POST",
                    success: function (data, textStatus, jqXHR) {
                        window.location = data.redirect;
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        Swal.fire("خطا", "خطا در برقراری ارتباط!", "error");
                    }
                });
                return false;
            };
        </script>
    </body>
</html>