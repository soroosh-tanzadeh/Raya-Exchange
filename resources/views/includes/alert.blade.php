<?php

use App\Alert;

$alert = Alert::where("active", true)->first();
?>

@if($user->email === null)
<div class="alert alert-warning has-icon text-white" style="direction: rtl;" role="alert"><i class="la la-warning alert-icon"></i> مشخصات شما در سامانه رایا تکمیل نشده است، لطفا از بخش اطلاعات کاربری نسبت به تکمیل آن اقدام کنید.</div>
@else
@if($user->email_verified_at === null)
<div class="alert alert-warning has-icon text-white" style="direction: rtl;" role="alert"><i class="la la-warning alert-icon"></i>ایمیل شما تایید نشده! جهت تایید آن اقدام کنید</div>
@endif
@endif

@if($alert !== null)
<div class="alert alert-{{ $alert->type }} has-icon" style="direction: rtl;" role="alert"><i class="la la-check alert-icon"></i><strong>خوب انجام شده!</strong><br>{{ $alert->text }}</div>
@endif
