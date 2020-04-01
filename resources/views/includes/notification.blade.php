<?php
$notifications = \App\Notification::getNotifications();
?>
<a class="nav-link dropdown-toggle navbar-icon" data-toggle="dropdown" href="#">
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
</div>