/* 
 * Copyright (C) 2020 Webflax
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

function comfirmPay(element) {
    theresult = false;
    var checkout = $(element).attr("data-checkout");
    Swal.fire({
        title: 'آیا از تایید این پرداخت اطمینان دارید؟',
        text: "!این عملیات غیرقابل بازگشت است",
        icon: 'warning',
        showLoaderOnConfirm: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'بله، تایید شود',
        cancelButtonText: 'انصراف',
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.ajax({
                    url: '/admin/comfirmpayment',
                    type: 'POST',
                    data: {_token: $('meta[name="csrf-token"]').attr('content'), id: checkout},
                }).done(function (response) {
                    $(element).remove();
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
}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".editAdmin").click(function () {
        var user = $(this).data("user");
        var name = $(this).data("name");
        $("#user_edit_id").val(user);
        $("#user_name").val(name);
        $("#editUser").modal();
    });

    $(".removeAdmin").click(function () {
        theresult = false;
        thebtn = this;
        var user = $(this).attr("data-user");
        Swal.fire({
            title: 'آیا از حذف این کاربر اطمینان دارید؟',
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
                        url: '/admin/admins/delete',
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


    setInterval(function () {
        $("#adminnotifcations").load("/adminnotifications");
    }, 15000);

    $(".deactivealert").click(function () {
        theresult = false;
        thebtn = this;
        var alert = $(this).attr("data-id");
        Swal.fire({
            title: 'آیا از غیرفعالسازی این اعلان اطمینان دارید؟',
            text: "!این عملیات غیرقابل بازگشت است",
            icon: 'warning',
            showLoaderOnConfirm: true,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'بله، تایید شود',
            cancelButtonText: 'انصراف',
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        url: '/admin/alerts/delete',
                        type: 'POST',
                        data: {_token: $('meta[name="csrf-token"]').attr('content'), id: alert},
                    }).done(function (response) {
                        swal('با موفقیت غیرفعال شد', response.message, response.status);
                        $(thebtn).parent().html('<text>غیرفعال</text>');
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

    $(".comfirmuser").click(function () {
        theresult = false;
        thebtn = this;
        var user = $(this).attr("data-user");
        Swal.fire({
            title: 'آیا از تایید این کاربر اطمینان دارید؟',
            text: "!این عملیات غیرقابل بازگشت است",
            icon: 'warning',
            showLoaderOnConfirm: true,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'بله، تایید شود',
            cancelButtonText: 'انصراف',
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        url: '/admin/verifyuser',
                        type: 'POST',
                        data: {_token: $('meta[name="csrf-token"]').attr('content'), id: user},
                    }).done(function (response) {
                        swal('با موفقیت تایید شد', response.message, response.status);
                        $(thebtn).parent().html('<text class="text-success">تایید شده</text>');
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
});

function comfirmBank(element) {
    theresult = false;
    thebtn = element;
    var bank = $(element).attr("data-bankaccount");
    Swal.fire({
        title: 'آیا از تایید این حساب بانکی اطمینان دارید؟',
        text: "!این عملیات غیرقابل بازگشت است",
        icon: 'warning',
        showLoaderOnConfirm: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'بله، تایید شود',
        cancelButtonText: 'انصراف',
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.ajax({
                    url: '/admin/comfirmbankaccount',
                    type: 'POST',
                    data: {_token: $('meta[name="csrf-token"]').attr('content'), id: bank},
                }).done(function (response) {
                    swal('با موفقیت تایید شد', response.message, response.status);
                    $(thebtn).remove();
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
}