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
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-full-width",
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
    
    $(function () {
        $("#ticker").csTicker({interval: 20});
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
    });

    $("#coin-num").on("input", function () {
        var coin = parseFloat($("#coin-num").val());
        var toman = coin * parseInt($(".dcurrency-select").children("a.active").attr("data-price"));
        $("#price-toman").val(toman);
    });
    $("#coinbuy-num").on("input", function () {
        var coin = parseFloat($("#coin-num").val());
        var toman = coin * parseInt($(".dcurrency-select").children("a.active").attr("data-price"));
        $("#pricebuy-toman").val(toman);
    });
    $("#coinamount").on("input", function () {
        var coin = parseFloat($(this).val());
        var toman = (coin * parseInt($(this).attr("data-price"))) / parseFloat($(this).attr("max"));
        $("#coinprice").text(toman);
    });
    $(".dcurrency-select").click(function () {
        var coin = parseFloat($("#coin-num").val());
        var toman = coin * parseInt($(this).children("a").attr("data-price"));
        $("#coin-type").val($(this).children("a").attr("data-coin"));
        $("#coinbuy-type").val($(this).children("a").attr("data-coin"));
        $("#price-toman").val(toman);

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
        $("#checkouttargetcoin").val(coin);
        $("#checkoutcoinModal").modal();
    });

    $(".paycoin").click(function () {
        var coin = $(this).attr("data-coin");
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

});

function submitAjaxForm(form) {
    var data = $(form).serialize();
    var method = $(form).attr("method");
    var action = $(form).attr("data-action");
    var submitbtn = $(form).attr("data-btn");
    var target = $(form).attr("data-target");
    $.ajax({
        data: data,
        url: action,
        type: method,
        beforeSend: function (xhr) {
            $(submitbtn).prop("disable", true);
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
            $(submitbtn).prop("disable", false);
        }
    });
    return false;
}