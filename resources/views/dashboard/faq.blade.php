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
        <link href="/assets/css/pages/form-wizard.css" rel="stylesheet" />
        <link href="/assets/vendors/feather-icons/feather.css" rel="stylesheet" />
        <link href="/assets/vendors/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
        <link href="/assets/vendors/themify-icons/themify-icons.css" rel="stylesheet" />
        <link href="/assets/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" />
        <link href="/assets/vendors/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" /><!-- PAGE LEVEL VENDORS-->
        <title>Raya-EX | آموزش</title><!-- GLOBAL VENDORS-->

    </head>
    <body>
        <div class="modal fade" id="paymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">شارژ کیف‌پول ریالی</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/payir/pay" method="GET">
                            <label>مبلغ شارژ (تومان)</label>
                            <input type="number" name="amount" class="form-control" value="" style="width: 100%;margin-bottom: 10px;" placeholder="مبلغ مورد نظر خود را وارد کنید" />
                            <input class="btn btn-primary" type="submit" value="پرداخت" />
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($user->is_admin)
        <div class="modal fade" id="new-question-dialog" aria-labelledby="new-question-dialog" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form class="modal-content" method="POST" action="/admin/newfaq">
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
            <div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="box-title">دسته بندی ها</h5>
                                <div class="card-fullwidth-block px-3">
                                    <div class="nav nav-pills flex-column faq-tabs" role="tablist">
                                        @if(count($categories) > 0)
                                        @foreach($categories as $category)
                                        <a class="nav-link media align-items-center" data-toggle="pill" href="#faq-group-{{ $category->id }}" role="tab">
                                            <i class="ti-{{ $category->icon }} font-26 mr-3"></i>
                                            <div class="media-body">
                                                <div class="mb-1 h6">{{ $category->name }}</div>
                                            </div>
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
                            <div class="card-body">
                                <div class="flexbox mb-4">
                                    <h5 class="mb-0">سوالات متداول</h5>
                                    @if($user->is_admin)
                                    <button class="btn btn-danger btn-rounded" data-toggle="modal" data-target="#new-question-dialog"><span class="btn-icon"><i class="ti-plus"></i>سوال جدید</span></button>
                                    @endif
                                </div>
                                <div class="input-group-icon input-group-icon-left input-group-lg mb-5">
                                    <span class="input-icon input-icon-left"><i class="ti-search"></i></span>
                                    <input class="form-control border-0" type="text" placeholder="جستجو ..." style="box-shadow:0 3px 6px rgba(10,16,20,.15);"></div>
                                <div class="tab-content">
                                    @foreach($categories as $category)
                                    <?php
                                    $questions = $category->getQuestions();
                                    ?>
                                    <div class="tab-pane" id="faq-group-{{ $category->id }}">
                                        <ul class="list-unstyled faq-list">
                                            @if(count($questions) > 0)
                                            @foreach($questions as $question)
                                            <li>
                                                <a data-toggle="collapse" href="#faq1-1" aria-expanded="true"> 
                                                    {{ $question->question }}
                                                </a>
                                                <div class="collapse show" id="faq1-1">
                                                    <div class="faq-answer">
                                                        {{ $question->answer }}
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @else
                                        هیچ دسته وجود ندارد
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
    </body>
</html>