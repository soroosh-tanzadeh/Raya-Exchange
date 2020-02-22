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
    allowHtml: true
});

$("#from_coin").select2({
    placeholder: "انتخاب یک کوین برای ارسال",
    templateSelection: iformat,
    templateResult: iformat,
    allowHtml: true
});
$("#to_coin").select2({
    placeholder: "انتخاب کوین دریافتی",
    templateSelection: iformat,
    templateResult: iformat,
    allowHtml: true
});

var sellersTable;
var buyersTable;
$(document).ready(function () {
    sellersTable = $("#buyofferstable").DataTable({
        processing: true,
        serverSide: true,
        ajax: '/dashboard/getbuyoffers',
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
        "searching": false,
        "paging": false,
        "info": false,
        "lengthChange": false
    });

    buyersTable = $("#sellofferstable").DataTable({
        processing: true,
        serverSide: true,
        ajax: '/dashboard/getselloffers',
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
        "searching": false,
        "paging": false,
        "info": false,
        "lengthChange": false
    });


    $(".loadcoinoffers").click(function () {
        var coin = $(this).attr("data-coin");
        var offertype = $(this).attr("data-offer");

        if (offertype === "sell") {
            sellersTable.ajax.url('/dashboard/getbuyoffers?coin=' + coin).load();
        } else if (offertype === "buy") {
            buyersTable.ajax.url('/dashboard/getselloffers?coin=' + coin).load();
        }
    });
    
   $(".coins_select").change(function(){
       var el = this;
      $(this).parent().find(".coinicon").html('<img style="max-width: 25px;" src="' + $(this).find(":selected").attr('data-icon') + '"/>'); 
   });

});