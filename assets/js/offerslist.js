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
sellersTable = $("#buyofferstable").DataTable({
    processing: true,
    serverSide: true,
    ajax: '/dashboard/getbuyoffers?list=1',
    columns: [
        {data: 'name'},
        {data: 'coin'},
        {data: 'min_buy'},
        {data: 'amount'},
        {data: 'price_pre'},
        {data: 'created_at'},
        {data: 'action', orderable: false, searchable: false}
    ],
    "language": {
        "url": "/assets/persian.json"
    },
    "searching": true,
    "paging": true,
    "info": true,
    "lengthChange": true
});

buyersTable = $("#sellofferstable").DataTable({
    processing: true,
    serverSide: true,
    ajax: '/dashboard/getselloffers?list=1',
    columns: [
        {data: 'name'},
        {data: 'coin'},
        {data: 'min_buy'},
        {data: 'amount'},
        {data: 'price_pre'},
        {data: 'created_at'},
        {data: 'action', orderable: false, searchable: false}
    ],
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