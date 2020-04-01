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
                <div class="row my-2">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="/admin/save-settings" method="POST" enctype="multipart/form-data" id="savesettings">
                                    @csrf
                                    <div class="form-row">
                                        @foreach($options as $option)
                                            @if($option->key !== "laws")
                                        <div class="col-md-4">
                                            <label>{{ $option->label }}</label>
                                            <input class="form-control" type='number' step="0.01" name="key[{{ $option->key }}]" value="{{ $option->value }}" required />
                                        </div>
                                        @else
                                        <div class="col-md-12 my-2">
                                            <label for="text" class="mt-2">{{ $option->label }}</label>
                                            <input type="hidden" id="lawstext" name="key[{{ $option->key }}]">
                                            <div id="editor-container">
                                                {!! $option->value !!}
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    <input class="btn btn-primary mt-2" type="submit" id="sendbtn" value="ثبت اطلاعات" />
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
            var form = document.querySelector('#savesettings');
            form.onsubmit = function () {
                // Populate hidden form on submit
                var html = $('#editor-container').summernote('code');
                $("#lawstext").val(html);
                console.log("Submitted", $(form).serialize(), $(form).serializeArray());
                $.ajax({
                    url: "/admin/save-settings",
                    data: $(form).serialize(),
                    type: "POST",
                    beforeSend: function (xhr) {
                        $("#sendbtn").prop("disabled", true);
                    },
                    complete: function (jqXHR, textStatus) {
                        $("#sendbtn").prop("disabled", false);

                    },
                    success: function (data, textStatus, jqXHR) {
                        toastr["success"]("اطلاعات با موفقیت ثبت شد");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        toastr["error"]("خطا در برقراری ارتباط");
                    }
                });
                return false;
            };
        </script>
    </body>
</html>