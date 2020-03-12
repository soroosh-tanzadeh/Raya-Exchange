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
$(document).ready(function () {
    $(".editInfo").click(function () {
        Swal.fire({
            title: 'آیا اطمینان دارید؟',
            text: "در صورت تغییر در اطلاعات حساب شما نیاز به تایید مجدد دارد.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'تایید',
            cancelButtonText: "انصراف",
            rtl: true
        }).then((result) => {
            if (result.value) {
                window.location = "/dashboard/signup";
            }
        })
    });

    $(".changePass").click(function () {
        $(this).prop("disabled");
        if ($("#pass1").val() === $("#pass2").val()) {
            $.ajax({
                url: "/dashboard/passchange",
                type: "POST",
                data: {currentpass: $("#current").val(), pass: $("#pass1").val()},
                complete: function (jqXHR, textStatus) {
                    $(".changePass").prop("disabled",false);
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
        } else {
            Swal.fire("خطا", "رمزعبور و تاییدیه آن برابر نیست!", "error");
        }
    });
});