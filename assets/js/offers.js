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
    var options = new Array();
    options.push({
        id: "bitcoin",
        text: " Bitcoin " + '<i class="cc BTC-alt font-26 text-warning mb-2"></i>'
    });
    options.push({
        id: "litecoin",
        text: " Litecoin " + '<i class="cc LTC-alt font-26 text-secondary mb-2"></i>'
    });
    $('.coins_select').select2({
        data: options,
        minimumResultsForSearch: -1,
        escapeMarkup: function (markup) {
            return markup;
        },
        width: 'style'
    });

    $(".canceloffer").click(function () {
        $(this).prop("disabled", true);
        var element = this;
        var offer = $(this).attr("data-offer");
        $.ajax("/dashboard/canceloffer", {
            data: {offer_id: offer},
            type: 'POST',
            success: function (data, textStatus, jqXHR) {
                Swal.fire(
                        'با موفقیت لغو شد!',
                        '',
                        'success'
                        );
                $(element).parent().append('<text class="text-danger">لغو شده</text>');
                $(element).remove();
            },
            cache: false,
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire(
                        'خطا در لغو پیشنهاد',
                        'لطفا مجدد تلاش کنید',
                        'error'
                        );
            },
            complete: function (jqXHR, textStatus) {
                $(this).prop("disabled", false);
            }
        });
    });
});