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


<div class="page-wrapper">
    <div class="content-wrapper">
        <!-- BEGIN: Sidebar-->
        <div class="page-sidebar custom-scroll" id="sidebar">
            <div class="sidebar-header"><a class="sidebar-brand" href="/dashboard">Raya-EX</a><a class="sidebar-brand-mini" href="/index">RX</a><span class="sidebar-points"><span class="badge badge-success badge-point mr-2"></span><span class="badge badge-danger badge-point mr-2"></span><span class="badge badge-warning badge-point"></span></span></div>
            <ul class="sidebar-menu metismenu" id="theulsidebar">
                <li><a href="/admin"><i class="sidebar-item-icon ft-home"></i><span class="nav-label">داشبورد</span></a></li>
                <li><a href="/admin/users"><i class="sidebar-item-icon ft-users"></i><span class="nav-label">کاربران</span></a></li>
                <li><a href="/admin/bankaccounts"><i class="sidebar-item-icon fas fa-credit-card"></i><span class="nav-label">حساب‌های بانکی</span></a></li>
                <li><a href="javascript:;"><i class="sidebar-item-icon ft-dollar-sign"></i><span class="nav-label">درخواست‌ها</span><i class="arrow la la-angle-right"></i></a>
                    <ul class="nav-2-level">
                        <li><a href="/dashboard/cryptopays"><i class="cc sidebar-item-icon BTC-alt"></i><span class="nav-label">برداشت از کیف‌پول ارزی</span></a></li>
                        <li><a href="/admin/rialpays"><i class="sidebar-item-icon ft-dollar-sign"></i><span class="nav-label">برداشت از کیف‌پول ریالی </span></a></li>
                    </ul>
                </li>
                <li><a href="/admin/tickets"><i class="sidebar-item-icon ft-inbox"></i><span class="nav-label">تیکت‌ها</span></a></li>
                <li><a href="/admin/faq"><i class="sidebar-item-icon ft-book-open"></i><span class="nav-label">آموزش</span></a></li>

            </ul>
        </div>
        <!-- END: Sidebar-->

        <div class="content-area">
            <!-- BEGIN: Header-->
            <nav class="navbar navbar-expand navbar-light fixed-top header">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link navbar-icon sidebar-toggler" id="sidebar-toggler" href="#"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a></li>
                </ul>
                <ul class="navbar-nav">
                    <?php
                    $notifications = \App\Notification::getNotifications();
                    ?>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle navbar-icon" data-toggle="dropdown" href="#">
                            <i class="ft-bell position-relative"></i>
                            @if(count($notifications) > 0)
                            <span class="notify-signal bg-danger"></span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pt-0" style="min-width: 350px">
                            <div class="py-4 px-3 text-center text-white mb-3" style="background-color: #2c2f48;">
                                <h5 class="m-0">اعلان ها</h5>
                            </div>
                            <div class="custom-scroll position-relative mb-3" style="height:320px;">
                                <div class="list-group list-group-flush">
                                    @if(count($notifications) > 0)
                                    @foreach($notifications as $notification)
                                    <a class="list-group-item list-group-item-action px-4 py-3" href="{{ $notification->getTarget() }}">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <div class="flexbox">
                                                    <h6 class="mb-0 font-weight-bold">{{ $notification->title }}</h6>
                                                    <div class="text-muted font-13">{{ \Morilog\Jalali\Jalalian::forge($notification->created_at)->ago() }}</div>
                                                </div>
                                                <div class="font-13 text-muted">{{ $notification->text }}</div>
                                            </div>
                                        </div>
                                    </a>
                                    @endforeach
                                    @else
                                    <div class="text-center">
                                        هیچ اعلانی وجود ندارد.
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="px-3 py-2 text-center"><a class="hover-link font-13" href="javascript:;">مشاهده همه</a></div>
                        </div>
                    </li>
                    <li class="nav-divider"></li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle no-arrow d-inline-flex align-items-center" data-toggle="dropdown" href="#"><span class="d-none d-sm-inline-block mr-2">{{ $user->first_name }} {{ $user->last_name}}</span><span class="position-relative d-inline-block"><img class="rounded-circle" src="/assets/img/users/admin-image.png" alt="image" width="36" /></span></a>
                        <div class="dropdown-menu dropdown-menu-right pt-0 pb-4" style="min-width: 280px;">
                            <div class="p-4 mb-4 media align-items-center text-white" style="background-color: #2c2f48;"><img class="rounded-circle mr-3" src="/assets/img/users/admin-image.png" alt="image" width="55" />
                                <div class="media-body">
                                    <h5 class="mb-1">{{ $user->name }}</h5>
                                </div>
                            </div><a class="dropdown-item d-flex align-items-center" href="#"><i class="ft-user mr-3 font-18 text-muted"></i>اطلاعات کاربری</a><a class="dropdown-item d-flex align-items-center" href="#"><i class="ft-lock mr-3 font-18 text-muted"></i>تغییر رمز عبور</a>
                            <div class="dropdown-divider my-3"></div>
                            <div class="mx-4"><a class="btn btn-link p-0" href="/logout"><span class="btn-icon"><i class="ft-power mr-2 font-18"></i>خروج</span></a></div>
                        </div>
                    </li>
                    <li><a class="nav-link navbar-icon quick-sidebar-toggler" href="javascript:;"><span class="ft-align-left"></span></a></li>
                </ul>
            </nav>
            <!-- END: Header-->