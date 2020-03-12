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
        <title>Raya-EX | آموزش جدید</title><!-- GLOBAL VENDORS-->
        <style>
            .note-editable{
                min-height: 450px;
            }
        </style>
    </head>
    <body>
        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">آموزش</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/index"><i class="ft-home font-20"></i></a></li>
                        <li class="breadcrumb-item">آموزش جدید</li>
                    </ol>
                </div>
            </div>
            <!-- BEGIN: Page content-->
            <div>
                @if(isset($post))
                <form action="javascript:;" data-action="/admin/posts/edit/{{ $post->id }}" method="POST" id="newpost">
                    @csrf
                    <div class="row flex-column justify-content-center align-items-center">
                        <div class="col-md-8 my-2">
                            <input class="form-control" placeholder="عنوان آموزش" type="text" name="name" value="{{ $post->name }}" />
                        </div>
                        <div class="col-md-8 my-2">
                            <select class="form-control" name="category" required>
                                <option>انتخاب دسته بندی</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($post->category === "$category->id") selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8 my-2">
                            <input type="hidden" id="posttext" name="text" value="" />
                            <div id="editor-container">
                                {!! $post->text !!}
                            </div>
                        </div>
                        <div class="col-md-8 my-2">
                            <input type="submit" id="submitPost" class="btn btn-primary" value="انتشار" />
                        </div>
                    </div>
                </form>
                @else
                <form  action="javascript:;" data-action="/admin/posts/new" method="POST" id="newpost">
                    @csrf
                    <div class="row flex-column justify-content-center align-items-center">
                        <div class="col-md-8 my-2">
                            <input class="form-control" placeholder="عنوان آموزش" type="text" name="name" value="" />
                        </div>
                        <div class="col-md-8 my-2">
                            <select class="form-control" name="category">
                                <option>انتخاب دسته بندی</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8 my-2">
                            <input type="hidden" id="posttext" name="text" value="" />
                            <div id="editor-container"></div>
                        </div>
                        <div class="col-md-8 my-2">
                            <input type="submit" id="submitPost" class="btn btn-primary" value="انتشار" />
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
        @include("includes.footer")

        <script>
            $('#editor-container').summernote();
            var form = document.querySelector('#newpost');
            form.onsubmit = function () {
                $("#submitPost").prop("disabled", true);
                // Populate hidden form on submit
                var html = $('#editor-container').summernote('code');
                $("#posttext").val(html);
                var action = $(form).data("action");
                $("#submitPost").prop("disabled");
                $.ajax({
                    url: action,
                    data: $(form).serialize(),
                    type: "POST",
                    complete: function (jqXHR, textStatus) {
                        $("#submitPost").prop("disabled", false);
                    },
                    success: function (data, textStatus, jqXHR) {
                        if (data.result) {
                            Swal.fire("موفقیت آمیز بود!", data.msg, "success").then(() => {
                                window.location = "/admin/posts/";
                            });
                        } else {
                            Swal.fire("خطا", data.msg, "error");
                        }
                    }
                })
                return false;
            };
        </script>
    </body>
</html>