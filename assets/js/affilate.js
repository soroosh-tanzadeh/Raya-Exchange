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
    $(".convert2btc").click(function () {
        var amount = $(this).data("credit");
        Swal.fire({
            title: 'تبدیل درآمد به بیت کوین',
            input: 'number',
            showCancelButton: true,
            confirmButtonText: 'ثبت درخواست',
            cancelButtonText: "لغو",
            showLoaderOnConfirm: true,
            preConfirm: (amount) => {
                return fetch(`/dashboard/convert2btc?amount=${amount}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json();
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                    `خطا در برقراری ارتباط: ${error}`
                                    );
                        })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.value) {
                if (result.value.result) {
                    Swal.fire("با موفقیت انجام شد", result.value.msg, "success");
                } else {
                    Swal.fire("خطا", result.value.msg, "error");
                }
            }
        })
    });
});