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

    $("#useredit").click(function () {
        $("#userform").submit();
    });

    $(".form-control").change(function () {
        if (this.hasAttribute("pattern")) {
            var regex = new RegExp($(this).attr("pattern"));
            if ((regex.test($(this).val()))) {
                $(this).removeClass("is-invalid");
                $(this).parent().find('.text-danger').remove();
                $(this).addClass("is-valid");
            } else {
                $(this).addClass("is-invalid");
                $(this).parent().find('.text-danger').remove();
                $('<small class="text-danger">' + $(this).attr("title") + '</small>').insertAfter(this);
            }
        } else {
            $(this).removeClass("is-invalid");
            $(this).parent().find('.text-danger').remove();
            $(this).addClass("is-valid");
        }
    });


    $("#pass2").change(function () {
        if ($("#pass1").val() !== $("#pass2").val()) {
            $("#pass2").addClass("is-invalid");
            $("#pass2").parent().find('.text-danger').remove();
            $('<small class="text-danger">رمزعبور با تاییدیه آن برابر نیست.</small>').insertAfter("#pass2");
        }
    });

    $(".changePass").click(function () {

        var canPass = false;

        var pass1 = $("#pass1").val();

        if (pass1 === '') {
            $("#pass1").addClass("is-invalid");
            $("#pass1").parent().find('.text-danger').remove();
            $('<small class="text-danger">این فیلد اجباری است.</small>').insertAfter("#pass1");
            canPass = false;
        } else {
            passwordRegex = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
            if (!(passwordRegex.test(pass1))) {
                $("#pass1").addClass("is-invalid");
                $("#pass1").parent().find('.text-danger').remove();
                $('<small class="text-danger">رمزعبور حداقل از ۸ کاراکتر  و شامل حروف کوچک ، بزرگ و عدد باشد.</small>').insertAfter("#pass1");
                canPass = false;
            }
        }

        if (canPass) {
            $(this).prop("disabled");
            if ($("#pass1").val() === $("#pass2").val()) {
                $.ajax({
                    url: "/dashboard/passchange",
                    type: "POST",
                    data: {currentpass: $("#current").val(), pass: $("#pass1").val()},
                    complete: function (jqXHR, textStatus) {
                        $(".changePass").prop("disabled", false);
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
                $("#pass2").addClass("is-invalid");
                $("#pass2").parent().find('.text-danger').remove();
                $('<small class="text-danger">رمزعبور با تاییدیه آن برابر نیست.</small>').insertAfter("#pass2");
            }
        }
    });
});
