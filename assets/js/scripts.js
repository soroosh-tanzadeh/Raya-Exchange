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

(function ($) {

    $.fn.csTicker = function (options) {

        if (typeof (options) == 'undefined') {
            options = {};
        }

        var settings = $.extend({}, $.fn.csTicker.defaults, options);

        var $ticker = $(this);

        settings.tickerID = $ticker[0].id;

        $.fn.csTicker.settings[settings.tickerID] = {};

        var $wrap = null;

        if (!$ticker.parent().eq(0).hasClass('wrap')) {
            $wrap = $ticker.wrap("<div class='wrap'></div>");
        }

        var $tickerContainer = null;

        if (!$ticker.parent().parent().eq(0).hasClass('container')) {
            $tickerContainer = $ticker.parent().wrap(
                    "<div class='trickercontainer'></div>");
        }

        var node = $ticker[0].firstChild;
        var next;

        while (node) {
            next = node.nextSibling;
            if (node.NodeType == 3) {
                $ticker[0].removeChild(node);
            }
            node = next;
        }

        var shiftLeftAt = $ticker.children().eq(0).outerWidth(true);

        $.fn.csTicker.settings[settings.tickerID].shiftLeftAt = shiftLeftAt;
        $.fn.csTicker.settings[settings.tickerID].left = 0;
        $.fn.csTicker.settings[settings.tickerID].runid = null;

        $ticker.width(2 * screen.availWidth);

        function startTicker() {
            stopTicker();

            var params = $.fn.csTicker.settings[settings.tickerID];
            params.left -= settings.speed;
            if (params.left <= params.shiftLeftAt * -1) {
                params.left = 0;
                $ticker.append($ticker.children().eq(0));
                params.shiftLeftAt = $ticker.children().eq(0).outerWidth(true);
            }

            var leftPos = (params.left < 0) ? (-1 * params.left) : params.left;
            $tickerContainer.scrollLeft(leftPos);
            params.runId = setTimeout(arguments.callee, settings.interval);

            $.fn.csTicker.settings[settings.tickerID] = params;
        }

        function stopTicker() {
            var params = $.fn.csTicker.settings[settings.tickerID];
            if (params.runId)
                clearTimeout(params.runId);

            params.runId = null;

            $.fn.csTicker.settings[settings.tickerID] = params;
        }

        function updateTicker() {

            stopTicker();
            startTicker();
        }

        if (settings.pauseOnHover) {
            $ticker.hover(stopTicker, startTicker);
        }

        startTicker();
    };


    $.fn.csTicker.settings = {};

    $.fn.csTicker.defaults = {
        tickerID: null,
        url: null,
        speed: 1,
        pauseOnHover: false,
        interval: 20
    };
})(jQuery);


toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-bottom-left",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}


$(document).ready(function () {

    $("#notifcations").load("/notifications");

    $(".datatable").DataTable({
        "language": {
            "url": "/assets/persian.json"
        },
        "searching": false,
        "paging": false,
        "info": false,
        "lengthChange": false
    });


    $(".datatable-full").each(function () {
        var url = $(this).attr("data-ajax");
        var columns = JSON.parse($(this).attr("data-columns"));

        $(this).DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: columns,
            "language": {
                "url": "/assets/persian.json"
            }, drawCallback: function (settings) {
                $('[data-toggle="tooltip"]').tooltip()
            }
        });
    });

    $(".numeric").on("keyup", function () {
        var validChars = /[0-9 .]/;
        var strIn = this.value;
        var strOut = '';
        for (var i = 0; i < strIn.length; i++) {
            strOut += (validChars.test(strIn.charAt(i))) ? strIn.charAt(i) : '';
        }
        this.value = strOut;
    });

    $("button[type='submit']").click(function () {
        if (!isVerified) {
            Swal.fire("خطا", "حساب شما احراز هویت نشده!", "error");
            return false;
        }
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

    var pathname = window.location.pathname;
    $("#theulsidebar li").each(function () {
        var href = $(this).children("a").attr("href");
        if (href === pathname) {
            $(this).addClass("mm-active");
            $(this).parent().addClass("mm-show");
            $(this).parent().parent().addClass("mm-active");
        }
    });

    $(".buycoin").click(function () {
        var input = $("#coinamount");
        input.attr("data-price", $(this).attr("data-price"));
        input.attr("data-coin", $(this).attr("data-coin"));
        input.attr("min", $(this).attr("data-min"));
        input.attr("max", $(this).attr("data-max"));
        $("#offeridIN").val($(this).attr("data-offer"))
        $("#buycoinform").attr("action", "/buycoin?offer=" + $(this).attr("data-offer"));
        $("#buycoinmodal").modal();
    })

    $(".coins_select").change(function () {
        if ($("#coin-num").val() !== "") {
            $("#coin-num").trigger("input");
        }
        if ($("#coinbuy-num").val() !== "") {
            $("#coinbuy-num").trigger("input");
        }
    });

    $("#coin-num").on("input", function () {
        $("#offerprice").trigger('input');
        var coin = parseFloat($("#coin-num").val());
        var coinsymbol = $("#coin-num").parent().parent().parent().parent().find(".coins_select :selected").data("symbol");
        if (coinsymbol !== undefined) {
            var toman = coin * parseFloat($("#coin-num").parent().parent().parent().parent().find(".coins_select :selected").attr("data-price"));
            if (!isNaN(toman)) {
                toman = (toman * 0.02) + toman;
                var total = toman - (toman * adminfee);
                $("#priceINTOMAN").attr("style", "visibility: visible");
                $("#selloffercoin").text(coin + "" + coinsymbol.toUpperCase());
                $("#price-toman").html("<span style='float:right' class='mx-1'>" + coin + "" + coinsymbol + " : </span> <span style='float:right;'>" + numeral(parseInt(toman)).format('0,0') + "</span");
            }
        }
    });

    $("#offerprice").on("input", function () {
        var coinsymbol = $("#coin-num").parent().parent().parent().parent().find(".coins_select :selected").data("symbol");
        if (coinsymbol != undefined && parseFloat($("#coin-num").val())) {
            toman = parseFloat(numeral($(this).val()).value());
            if (!isNaN(toman)) {
                var total = toman - (toman * adminfee);
                $("#totalsellprice").val(numeral(parseInt(total)).format('0,0') + " تومان");
            }
        }
    });

    $("#coinbuy-num").on("input", function () {
        $("#coinprice").trigger('input');
        var coin = parseFloat($("#coinbuy-num").val());
        var coinsymbol = $("#coinbuy-num").parent().parent().parent().parent().find(".coins_select :selected").data("symbol");
        if (coinsymbol !== undefined) {
            var toman = coin * parseInt($("#coinbuy-num").parent().parent().parent().parent().find(".coins_select :selected").attr("data-price"));
            if (!isNaN(toman)) {
                $("#priceINTOMANBUY").attr("style", "visibility: visible");
                toman = toman - (toman * 0.02);
                $("#pricebuy-toman").html("<span style='float:right' class='mx-1'>" + coin + "" + coinsymbol + " : </span> <span style='float:right;'>" + numeral(parseInt(toman)).format('0,0') + "</span");
            }
        }
    });

    $("#coinamount").on("input", function () {
        var coin = parseFloat($(this).val());
        var toman = (coin * parseInt($(this).attr("data-price"))) / parseFloat($(this).attr("max"));
        $("#coinprice").text(toman);
    });

    $(".sellcoin").click(function () {
        var input = $("#coinamount");
        input.attr("data-price", $(this).attr("data-price"));
        input.attr("data-coin", $(this).attr("data-coin"));
        input.attr("min", $(this).attr("data-min"));
        input.attr("max", $(this).attr("data-max"));
        $("#sellofferid").val($(this).attr("data-offer"))
        $("#sellcoinform").attr("data-action", "/buycoin?offer=" + $(this).attr("data-offer"));
        $("#sellcoinmodal").modal();
    });


    $(".recievecoin").click(function () {
        var coin = $(this).attr("data-coin");
        var name = $(this).attr("data-name");

        $("#checkouttargetcoin").val(coin);
        $("#recievecoinsymbol").text(name)
        $("#recievecoinimg").attr("src", "/assets/icons/" + coin + ".png");

        $("#checkoutcoinModal").modal();
    });

    $(".paycoin").click(function () {
        var coin = $(this).attr("data-coin");
        var name = $(this).attr("data-name");
        $("#paycoinsymbol").text(name)
        $("#paycoinimg").attr("src", "/assets/icons/" + coin + ".png");
        $("#targetcoin").val(coin);
        $("#paycoinModal").modal();
    });

// SIDEBAR TOGGLE
    $('#sidebar-toggler').on('click', function (e) {
        e.preventDefault();
        if ($('body').hasClass('drawer-sidebar')) {
            $('#sidebar').backdrop();
        } else if ($('body').hasClass('sidebar-collapsed-mode')) {
            $('body').toggleClass('sidebar-hidden');
        } else {
            $('body').toggleClass('mini-sidebar');
        }
    });

    // QUICK SIDEBAR TOGGLE
    $('.quick-sidebar-toggler').on('click', function (e) {
        e.preventDefault();
        $('#quick-sidebar').backdrop();
    });




    jQuery.validator.addMethod("coinWallet", function (value, element) {
        return WAValidator.validate(value, $("#checkouttargetcoin").val());
    }, "آدرس کیف پول ورودی نامعتبر است.");

    $("#receiveform").validate({
        rules: {
            token: {
                required: true,
                coinWallet: true
            }
        }
    });


    $("#coinexchange").validate({
        rules: {
            from: {
                required: true,
            },
            to: {
                required: true
            },
            amount: {
                required: true
            }
        },
        errorPlacement: function errorPlacement(error, element) {
            error.insertAfter($(element).parent());
        }
    });



    $("#paycoinform").validate();
    $("#payrialform").validate();

    setInterval(function () {
        $(".coinpriceToman").each(function () {
            var coin_id = $(this).attr("data-coin");
            var element = this;
            $.ajax({
                type: 'POST',
                url: "/getcoinIndex",
                data: {_token: $('meta[name="csrf-token"]').attr('content'), id: coin_id.toLowerCase()},
                processData: false,
                cache: false,
                error: function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 401) {
                        window.location = "/";
                    }
                },
                complete: function (jqXHR, textStatus) {

                },
                success: function (data, textStatus, jqXHR) {
                    if (data.result) {
                        $(element).text(data.price_in_toman);
                    } else {

                    }
                }
            });
        });
    }, 15000);


    setInterval(function () {
        $("#notifcations").load("/notifications");
    }, 15000);
});

$(".price-seprator").each(function () {
    var element = this;
    IMask(
            $(element)[0], {
        mask: Number,
        thousandsSeparator: ','
    });
});


$(".form-control").on("input", function () {
    if (/([A-Z]|[a-z]|[0-9])/.test($(this).val())) {
        $(this).attr("style", "text-align: left !important;");
    } else {
        $(this).attr("style", "text-align: right !important;");
    }
});

function submitAjaxForm(form) {
    var data = new FormData(form);
    var method = $(form).attr("method");
    var action = $(form).attr("data-action");
    var submitbtn = $(form).attr("data-btn");
    var target = $(form).attr("data-target");

    var canPass = true;

    $(form).find("label.error").remove();
    $(form).find("input").each(function () {
        if (this.hasAttribute("required")) {
            if ($(this).val() === "") {
                $(this).addClass("is-invalid");
                $('<label class="error text-danger active" for="amount" style=""> این فیلد اجباری است.</label>').insertAfter($(this).parent());
                canPass = false;
            }
        }
        if (this.hasAttribute("equal")) {
            var equal = $(this).attr("equal");
            if ($(this).val() !== $(equal).val()) {
                $(this).addClass("is-invalid");
                $('<label class="error text-danger active" for="amount" style=""> رمزعبور با تاییدیه آن برابر نیست!</label>').insertAfter($(this).parent());
                canPass = false;
            }
        }
    });
    $(form).find("select").each(function () {
        if (this.hasAttribute("required")) {
            if ($(this).val() === null) {
                $(this).addClass("is-invalid");
                $('<label id="amount-error" class="error text-danger active" for="amount" style=""> این فیلد اجباری است.</label>').insertAfter($(this).parent());
                canPass = false;
            }
        }
    });
    if (canPass) {
        $.ajax({
            data: data,
            url: action,
            type: method,
            processData: false,
            contentType: false,
            beforeSend: function (xhr) {
                $(submitbtn).prop("disabled", true);
            },
            success: function (data, textStatus, jqXHR) {
                if (data.result) {
                    toastr['success'](data.msg);
                    setTimeout(function () {
                        if (target !== "" && target !== null && target !== undefined) {
                            window.location = target;
                        } else {
                            location.reload();
                        }
                    }, 2000);
                } else {
                    toastr['error'](data.msg);
                }
            },
            complete: function (jqXHR, textStatus) {
                $(submitbtn).prop("disabled", false);
            }
        });
    }
    return false;
}