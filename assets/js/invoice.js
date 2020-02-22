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
    $("#amount").change(function () {
        var price_pre = $(this).attr("data-price");
        var max_buy = $(this).attr("data-max");
        var amount = $(this).val();

        var price = (price_pre * amount) / max_buy;
        var fee = (price * variables.fee);
        var fullprice = price + fee;

        $("#price").text(numeral(price).format('0,0') + "تومان  ");
        $("#pricefee").text(numeral(fee).format('0,0') + "تومان  ");
        $("#fullprice").text(numeral(fullprice).format('0,0') + " تومان");
    });
});