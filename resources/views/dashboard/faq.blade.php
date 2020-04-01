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
        <title>Raya-EX | سوالات متداول</title><!-- GLOBAL VENDORS-->
        <style>
            .faq-tabs .nav-link {
                min-width: 100px;
                padding: 1rem;
                border: 1px dashed;
                margin-bottom: 1rem;
                background-color: #fff;
                box-shadow: 0 1px 15px 1px rgba(62,57,107,.07);
            }
            .faq-tabs .nav-link.active {
                color: #fff;
                border-color: #2949ef;
                background-color: #2949ef;
            }
            .faq-tabs .nav-link.active .faq-item-text {
                color: rgba(255,255,255,.5)!important;
            }
            .faq-tabs .nav-link.active i {
                color: #fff !important;
            }
            .faq-list>li {
                padding: .75rem 0;
            }
            .faq-list>li>a {
                display: block;
                position: relative;
                color: inherit;
                font-weight: 500;
                font-size: 16px;
            }
            .faq-list>li>a:after {
                position: absolute;
                right: 0;
                top: 50%;
                transform: translateY(-50%);
                font-family: 'themify';
                content: "\e61a";
                speak: none;
                font-style: normal;
                font-weight: normal;
                font-variant: normal;
                text-transform: none;
                line-height: 1;
                -webkit-font-smoothing: antialiased;
            }
            .faq-list>li>a[aria-expanded=true] {
                color: #2949ef;
            }
            .faq-list>li>a[aria-expanded=true]:after {
                content: "\e622";
            }
            .faq-answer {
                padding: 1rem 0;
                margin-top: 1rem;
                color: #6c757d;
            }
        </style>
    </head>
    <body>
        @if($user->is_admin)
        <div class="modal fade" id="newCat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">دسته‌بندی جدید</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:;" data-btn="#submitcat" onsubmit="submitAjaxForm(this)" data-action="/admin/categories/new" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label>نام</label>
                                    <input type="text" name="name" value="" class="form-control" required/>
                                </div>
                                <div class="col-md-6">
                                    <label>آیکون</label>
                                    <input type="text" name="icon" value="" class="form-control" required />
                                </div>
                            </div>
                            <div class="text-muted">
                                برای انتخاب آیکون به وبسایت <a href="https://themify.me/themify-icons" target="_blank">Themify</a> مراجعه کنید و نام آیکون انتخابی را بدون پسوند ti- در فیلد آیکون وارد کنید.
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" id="submitcat" value="ایجاد" class="btn btn-primary" />
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="new-question-dialog" aria-labelledby="new-question-dialog" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form class="modal-content" method="POST" id="newfaq" action="javascript:;" data-action="/admin/newfaq">
                    @csrf
                    <div class="modal-header p-4">
                        <h5 class="modal-title">سوال جدید</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="form-group mb-4"><label class="text-muted mb-3">دسته بندی</label>
                            <div>
                                @foreach($categories as $category)
                                <label class="radio radio-primary radio-inline check-single" data-toggle="tooltip" data-original-title="{{ $category->name }}">
                                    {{ $category->name }} 
                                    <input type="radio" name="category" required value="{{ $category->id }}">
                                    <span></span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="md-form mb-4">
                            <input class="md-form-control validate" type="text" name="question" required>
                            <label>سوال</label>
                        </div>
                        <div class="md-form mb-4">
                            <textarea class="md-form-control auto-resize validate" name="answer" required></textarea>
                            <label>جواب سوال</label>
                        </div>
                        <button class="btn btn-primary btn-rounded mr-3" type="submit">ارسال</button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        @include("includes.header")
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading"> 
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">سوالات متداول</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="la la-home font-20"></i></a></li>
                    </ol>
                </div>
            </div><!-- BEGIN: Page content-->
            @include("includes.alert")
            <div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-header justify-content-between">
                                <h5 class="box-title">دسته بندی ها</h5>
                                @if($user->is_admin)
                                <button class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#newCat">+</button>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="card-fullwidth-block px-3">
                                    <div class="nav nav-pills flex-column faq-tabs" role="tablist">
                                        @if(count($categories) > 0)
                                        @foreach($categories as $category)
                                        <a class="tablinks nav-link media align-items-center" data-toggle="pill" href="#faq-group-{{ $category->id }}" role="tab">
                                            <i class="ti-{{ $category->icon }} font-26 mr-3"></i>
                                            <div class="media-body">
                                                <div class="mb-1 h6">{{ $category->name }}</div>
                                            </div>
                                            @if($user->is_admin)
                                            <button class="btn btn-danger deleteC" data-id="{{ $category->id }}">حذف</button>
                                            @endif
                                        </a>
                                        @endforeach
                                        @else
                                        هیچ دسته وجود ندارد
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <i class="ft-help-circle" style="font-size: 34px"></i>
                                    @if($user->is_admin)
                                    <button class="btn btn-danger btn-rounded" data-toggle="modal" data-target="#new-question-dialog"><span class="btn-icon"><i class="ti-plus"></i>سوال جدید</span></button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    @foreach($categories as $category)
                                    <?php
                                    $questions = $category->getQuestions();
                                    ?>
                                    <div class="tab-pane" id="faq-group-{{ $category->id }}">
                                        <ul class="list-unstyled faq-list">
                                            @if(count($questions) > 0)
                                            @foreach($questions as $question)

                                            @if($user->is_admin)
                                            <li class="row">
                                                <div class="col-1">
                                                    <button class="btn btn-danger btn-rounded mx-2 deleteQ" data-id="{{ $question->id }}">x</button>
                                                </div>
                                                <div class="col">
                                                    <a data-toggle="collapse" href="#faq1-{{ $question->id }}" class="collapsed"> 
                                                        {{ $question->question }}
                                                    </a>
                                                    <div class="collapse" id="faq1-{{ $question->id }}">
                                                        <div class="faq-answer">
                                                            {{ $question->answer }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @else
                                            <li>
                                                <a data-toggle="collapse" href="#faq1-{{ $question->id }}" class="collapsed"> 
                                                    {{ $question->question }}
                                                </a>
                                                <div class="collapse" id="faq1-{{ $question->id }}">
                                                    <div class="faq-answer">
                                                        {{ $question->answer }}
                                                    </div>
                                                </div>
                                            </li>
                                            @endif

                                            @endforeach
                                        </ul>
                                        @else
                                        هیچ سوالی وجود ندارد
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- BEGIN: Footer-->
        @include("includes.footer")

        @if ($user->is_admin)
        <script>
            $(".deleteQ").click(function () {
                theresult = false;
                thebtn = this;
                var user = $(this).attr("data-id");
                Swal.fire({
                    title: 'آیا از حذف این سوال اطمینان دارید؟',
                    text: "!این عملیات غیرقابل بازگشت است",
                    icon: 'warning',
                    showLoaderOnConfirm: true,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله، حذف شود',
                    cancelButtonText: 'انصراف',
                    showLoaderOnConfirm: true,
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            $.ajax({
                                url: '/admin/questions/delete',
                                type: 'POST',
                                data: {_token: $('meta[name="csrf-token"]').attr('content'), id: user},
                            }).done(function (response) {
                                swal('با موفقیت حذف شد', response.message, response.status);
                                $(thebtn).parent().parent().remove();
                            }).fail(function () {
                                swal('خطا..', 'مشکلی در ارتباط با سرور به وجود اومده!', 'error');
                            });
                        });
                    }
                }).then((result) => {
                    if (result.value) {
                        theresult = true;
                    }
                });
            });

            $(".deleteC").click(function () {
                theresult = false;
                thebtn = this;
                var user = $(this).attr("data-id");
                Swal.fire({
                    title: 'آیا از حذف این دسته بندی اطمینان دارید؟',
                    text: "!این عملیات غیرقابل بازگشت است",
                    icon: 'warning',
                    showLoaderOnConfirm: true,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله، حذف شود',
                    cancelButtonText: 'انصراف',
                    showLoaderOnConfirm: true,
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            $.ajax({
                                url: '/admin/categories/delete',
                                type: 'POST',
                                data: {_token: $('meta[name="csrf-token"]').attr('content'), id: user},
                            }).done(function (response) {
                                swal('با موفقیت حذف شد', response.message, response.status);
                                $(thebtn).parent().remove();
                            }).fail(function () {
                                swal('خطا..', 'مشکلی در ارتباط با سرور به وجود اومده!', 'error');
                            });
                        });
                    }
                }).then((result) => {
                    if (result.value) {
                        theresult = true;
                    }
                });
            });

        </script>
        @endif
        <script>
            $(".tablinks:first").click();

            var form = document.querySelector('#newfaq');
            form.onsubmit = function () {
                var action = $(form).data("action");
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
                                window.location.reload();
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