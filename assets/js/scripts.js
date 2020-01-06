/* 
 * Copyright (C) 2019 Maxivity
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
    var pathname = window.location.pathname;
    $("#theulsidebar li").each(function () {
        var href = $(this).children("a").attr("href");
        if (href === pathname) {
            $(this).addClass("mm-active");
        }
    });

    if (pathname === "/dashboard/market") {
        var market_table = $('#market-table').DataTable({
            "processing": true,
            "serverSide": true,
            ajax: "/api/market",
            columns: [
                {data: 'rank'},
                {data: 'icon'},
                {data: 'name'},
                {data: 'priceUsd'},
                {data: 'price_in_toman'},
                {data: 'supply'}
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Persian.json"
            }
        });
        setInterval(function () {
            market_table.ajax.reload();
        }, 60000);
    }

    $("#coin-num").on("input", function () {
        var coin = parseFloat($("#coin-num").val());
        var toman = coin * parseInt($(".dcurrency-select").children("a.active").attr("data-price"));
        $("#price-toman").val(toman);
    });
    $(".dcurrency-select").click(function () {
        var coin = parseFloat($("#coin-num").val());
        var toman = coin * parseInt($(this).children("a").attr("data-price"));
        $("#coin-type").val($(this).children("a").attr("data-coin"));
        $("#price-toman").val(toman);
    });
    $("#price-toman").on("input", function () {
        var toman = parseFloat($("#price-toman").val());
        var coin = toman / parseInt($(".dcurrency-select").children("a.active").attr("data-price"));
        $("#coin-num").val(coin);
    });
});