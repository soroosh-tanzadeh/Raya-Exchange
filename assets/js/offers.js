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



function iformat(icon) {
    if (!icon.id) {
        return icon.text;
    }
    var originalOption = icon.element;
    return $('<span><img style="max-width: 30px;" src="' + $(originalOption).data('icon') + '"/> ' + icon.text + '</span>');
}

$(".coins_select").select2({
    placeholder: "انتخاب یک کوین برای پیشنهاد",
    templateSelection: iformat,
    templateResult: iformat,
    allowHtml: true,
});

$(document).ready(function () {

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