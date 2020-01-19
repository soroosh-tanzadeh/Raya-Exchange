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
        <!-- BEGIN: Content-->
        <div class="page-content fade-in-up">
            <!-- BEGIN: Page heading-->
            <div class="page-heading">
                <div class="page-breadcrumb">
                    <h1 class="page-title page-title-sep">تیکت</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="la la-home font-20"></i></a></li>
                        <li class="breadcrumb-item">برگه ها</li>
                        <li class="breadcrumb-item">تیکت</li>
                    </ol>
                </div>
            </div><!-- BEGIN: Page content-->
            <div>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <div class="nav flex-column mt-5 mb-4">
                            <a class="flexbox py-2 hover-link mb-1" href="#"><span class="d-flex align-items-center"><i class="ft-inbox mr-3 font-16"></i>همه تیکت&zwnj;ها</span></a>
                            <a class="flexbox py-2 hover-link mb-1" href="#"><span class="d-flex align-items-center"><i class="ft-star mr-3 font-16"></i>نیاز به پاسخ کاربر</span></a>
                            <a class="flexbox py-2 hover-link mb-1" href="#"><span class="d-flex align-items-center"><i class="ft-send mr-3 font-16"></i>پاسخ از طرف پیشتیبانی</span></a>
                            <a class="flexbox py-2 hover-link mb-1" href="#"><span class="d-flex align-items-center"><i class="ft-mail mr-3 font-16"></i>بسته شده</span></a>
                        </div>
                        <hr class="my-4">

                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="box-title">تیکیت&zwnj;های شما</h5>
                            </div>
                            <div class="p-3">
                                <div class="input-group-icon input-group-icon-left input-group-lg"><span class="input-icon input-icon-left"><i class="ti-search"></i></span><input id="searchticket" class="form-control font-weight-light border-0 d-none" type="text" placeholder="جستجو ..."  data-table="#table-inbox" style="box-shadow:0 3px 6px rgba(10,16,20,.15);"></div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="card-fullwidth-block">
                                    <div class="flexbox px-4 py-3 mb-3" style="background-color: #e9ecef;">

                                    </div>
                                    <div class="table-responsive">
                                        @if(count($tickets) > 0)
                                        <table class="table table-hover table-inbox" id="table-inbox">
                                            <thead class="rowlinkx" data-link="row">
                                                <tr>
                                                    <th>#</th>
                                                    <th>عنوان تیکت</th>
                                                    <th>وضعیت</th>
                                                    <th>تاریخ ایجاد</th>

                                                </tr>
                                            </thead>
                                            <tbody class="rowlinkx" data-link="row">
                                                @foreach($tickets as $ticket)
                                                <tr data-id="1" class="filterable">
                                                    <td class="check-cell rowlink-skip text-center"><label class="checkbox checkbox-danger check-single"><input class="mail-check" type="checkbox"><span></span></label></td>
                                                    <td class="text-center"><a href="/admin/ticket/{{$ticket->id}}" class="link text-black">{{ $ticket->name }}</a></td>
                                                    <td class="text-center"><i class="badge-point text-center badge-{{ $ticket->status }}"></i></td>
                                                    <td class="text-center">{{ $ticket->created_at }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else 
                                        <p class="px-5 m-0 text-center">هیچ تیکتی ثبت نشده.</p>
                                        @endif
                                    </div>
                                    <!--                                <ul class="pagination pagination-circle justify-content-end p-4">
                                                                        <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><i class="ti-angle-left" aria-hidden="true"></i><span class="sr-only">Previous</span></a></li>
                                                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                                        <li class="page-item"><a class="page-link" href="#"><i class="la la-ellipsis-h"></i></a></li>
                                                                        <li class="page-item"><a class="page-link" href="#" aria-label="Next"><i class="ti-angle-right" aria-hidden="true"></i><span class="sr-only">Next</span></a></li>
                                                                    </ul>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- END: Page content-->
        </div><!-- BEGIN: Footer-->

        @include("includes.footer") 
    </body>
</html>