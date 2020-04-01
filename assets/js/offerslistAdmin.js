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
sellersTable = $("#sellofferstable").DataTable({
    processing: true,
    serverSide: true,
    ajax: '/admin/getbuyoffers?coin=bitcoin',
    columns: [
        {data: 'name'},
        {data: 'coin'},
        {data: 'amount'},
        {data: 'min_buy'},
        {data: 'price_pre'},
        {data: 'created_at'},
        {data: "adminActions"}
    ],
    "language": {
        "url": "/assets/persian.json"
    },
    drawCallback: function (settings) {
        $('[data-toggle="tooltip"]').tooltip()
    },
    "searching": true,
    "paging": true,
    "info": true,
    "lengthChange": true
});

buyersTable = $("#buyofferstable").DataTable({
    processing: true,
    serverSide: true,
    ajax: '/admin/getselloffers?coin=bitcoin',
    columns: [
        {data: 'name'},
        {data: 'coin'},
        {data: 'amount'},
        {data: 'min_buy'},
        {data: 'price_pre'},
        {data: 'created_at'},
        {data: "adminActions"}
    ],
    drawCallback: function (settings) {
        $('[data-toggle="tooltip"]').tooltip()
    },
    "language": {
        "url": "/assets/persian.json"
    },
    "searching": true,
    "paging": true,
    "info": true,
    "lengthChange": true
});


$(".loadcoinoffers").click(function () {
    var coin = $(this).attr("data-coin");
    var offertype = $(this).attr("data-offer");

    if (offertype === "sell") {
        sellersTable.ajax.url('/dashboard/getbuyoffers?list=1&coin=' + coin).load();
    } else if (offertype === "buy") {
        buyersTable.ajax.url('/dashboard/getselloffers?list=1&coin=' + coin).load();
    }
});

function deactiveOffer(offer, element) {
    $.ajax({
        url: "/admin/deactiveoffer",
        data: {offer_id: offer, _token: $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        beforeSend: function (xhr) {
            $(element).prop("disabled", true);
        },
        complete: function (jqXHR, textStatus) {
            $(element).prop("disabled", false);
        },
        success: function (data, textStatus, jqXHR) {
            $(element).replaceWith("<button class='btn btn-sm rounded-0 btn-outline-success' onclick='activeOffer(" + offer + ",this)' data-toggle='tooltip' title='فعالسازی'><i class='ft-check'></i></button>");
            $(".tooltip").remove();
            $('[data-toggle="tooltip"]').tooltip();
        }
    })
}

function activeOffer(offer, element) {
    $.ajax({
        url: "/admin/activeoffer",
        data: {offer_id: offer, _token: $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        beforeSend: function (xhr) {
            $(element).prop("disabled", true);
        },
        complete: function (jqXHR, textStatus) {
            $(element).prop("disabled", false);
        },
        success: function (data, textStatus, jqXHR) {
            $(element).replaceWith("<button class='btn btn-sm rounded-0 btn-outline-danger' onclick='deactiveUser(" + offer + ",this)' data-toggle='tooltip' title='غیرفعالسازی'><i class='ft-slash'></i></button>");
            $(".tooltip").remove();
            $('[data-toggle="tooltip"]').tooltip();
        }
    }
    )
}