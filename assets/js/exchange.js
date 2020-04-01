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
var qrcode = new QRCode("walletqrcode");

function reloadamount() {
    if ($("#amount").val() !== '') {
        $("#amount").trigger("change");
        $("#target-coin").val("");
    }
}

function iformat(icon) {
    if (!icon.id) {
        return icon.text;
    }
    var originalOption = icon.element;
    return $('<span><img style="max-width: 12px;" src="' + $(originalOption).attr('data-icon') + '"/> ' + icon.text + '</span>');
}

$("#from_coin").select2({
    placeholder: "از",
    templateSelection: iformat,
    templateResult: iformat,
    allowHtml: true
});
$("#to_coin").select2({
    placeholder: "به",
    templateSelection: iformat,
    templateResult: iformat,
    allowHtml: true
});

var dataType = "fixed";

var prevTO = "eth";

$(".extype").click(function () {
    dataType = $(this).data("type");
    prevTO = $("#to_coin").val(prevTO);
    $.ajax({
        url: "/get_all_coins",
        type: 'GET',
        data: {type: dataType},
        beforeSend: function (xhr) {
            $("#exchangebtn").prop("disabled", true);
            $("#loader").show();
        },
        success: function (data, textStatus, jqXHR) {
            $("#from_coin").html(data);
            $("#to_coin").html(data);
            setTimeout(function () {
                $("#loader").hide();
                $("#exchangebtn").prop("disabled", false);
                $("#from_coin").val("btc");
                $("#to_coin").val("eth");

                $("#amount").val("1");
                
                $("#from_coin").select2("destroy");
                $("#to_coin").select2("destroy");
                $("#from_coin").select2({
                    placeholder: "از",
                    templateSelection: iformat,
                    templateResult: iformat,
                    allowHtml: true
                });
                $("#to_coin").select2({
                    placeholder: "به",
                    templateSelection: iformat,
                    templateResult: iformat,
                    allowHtml: true
                });
                reloadamount();
            }, 1000);
        }

    });

    if ($("#amount").val() !== '') {
        $("#amount").trigger("change");
    }
});


$("#to_coin").change(function () {
    if ($("#from_coin").val() === "") {
        $.ajax({
            url: "/getpairs",
            type: 'GET',
            data: {coin: $(this).val(), type: dataType},
            beforeSend: function (xhr) {
                $("#exchangebtn").prop("disabled", true);
                $("#loader").show();
            },
            complete: function (jqXHR, textStatus) {
                $("#exchangebtn").prop("disabled", false);
                $("#loader").hide();

            },
            success: function (data, textStatus, jqXHR) {
                $("#from_coin").html(data);
                setTimeout(function () {
                    $("#loader").hide();
                    $("#exchangebtn").prop("disabled", false);

                    if ($("#amount").val() !== '') {
                        $("#amount").trigger("change");
                    }

                    $("#from_coin").select2("destroy");
                    $("#from_coin").select2({
                        placeholder: "از",
                        templateSelection: iformat,
                        templateResult: iformat,
                        allowHtml: true
                    });
                }, 1000);

            }

        });
    }
    if ($("#amount").val() !== '') {
        $("#amount").trigger("change");
    }
});




$("#from_coin").change(function () {
    prevTO = $("#to_coin").val();
    $.ajax({
        url: "/getpairs",
        type: 'GET',
        data: {coin: $(this).val(), type: dataType},
        beforeSend: function (xhr) {
            $("#exchangebtn").prop("disabled", true);
            $("#loader").show();
        },
        complete: function (jqXHR, textStatus) {
            $("#exchangebtn").prop("disabled", false);
            $("#loader").hide();
        },
        success: function (data, textStatus, jqXHR) {
            $("#to_coin").html(data);
            setTimeout(function () {
                $("#to_coin").val(prevTO);
                $("#loader").hide();
                $("#exchangebtn").prop("disabled", false);

                if (data !== "") {
                    $("#to_coin").select2("destroy");
                    $("#to_coin").select2({
                        placeholder: "به",
                        templateSelection: iformat,
                        templateResult: iformat,
                        allowHtml: true
                    });

                } else {
                    $("#to_coin").select2("destroy");
                    $("#to_coin").select2({
                        placeholder: "موردی یافت نشد!",
                        templateSelection: iformat,
                        templateResult: iformat,
                        allowHtml: true
                    });
                }
                reloadamount();
            }, 1000);

        }
    });
});

$(document).ready(function () {
//setup before functions
    var typingTimer;                //timer identifier
    var doneTypingInterval = 2000;  //time in ms, 5 second for example

    //on keyup, start the countdown
    $('#amount').on('keyup', function () {
        $("#loader").show();
        $("#exchangebtn").prop("disabled", true);
        $("#target-coin").val("");
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function () {
            $("#amount").trigger("change");
        }, doneTypingInterval);
    });

//on keydown, clear the countdown 
    $('#amount').on('keydown', function () {
        clearTimeout(typingTimer);
    });

    $("#amount").on("change", function () {
        $("#loader").show();
        $("#amount").parent().parent().find('.text-danger').remove();
        $("#amount").removeClass("is-invalid");
        $("#exchangebtn").prop("disabled", true);
        var from_coin = $("#from_coin").val();
        var to_coin = $("#to_coin").val();
        var amount = $("#amount").val();
        if (from_coin !== "" && to_coin !== "") {
            $.get("/get_estimate", {
                from: from_coin,
                to: to_coin,
                amount: amount,
                type: dataType
            }, function (data) {
                if (!isNaN(parseFloat(data.value))) {
                    $("#loader").hide();
                    $("#amount").parent().parent().find('.text-danger').remove();
                    $("#target-coin").val(data.value);
                    $("#amount").addClass("is-valid");
                    $("#exchangebtn").prop("disabled", false);
                } else {
                    if (data.max) {
                        $("#loader").hide();
                        $("#amount").parent().parent().find('.text-danger').remove();
                        $("#amount").addClass("is-invalid");
                        $('<small class="text-danger">حداکثر مقدار تبادل این کوین ' + data.msg + ' است</small>').insertAfter($("#amount").parent());
                        $("#exchangebtn").prop("disabled", true);
                    } else if (data.min) {
                        $("#loader").hide();
                        $("#amount").parent().parent().find('.text-danger').remove();
                        $("#amount").addClass("is-invalid");
                        $('<small class="text-danger">حداقل مقدار تبادل این کوین ' + data.msg + ' است</small>').insertAfter($("#amount").parent());
                        $("#exchangebtn").prop("disabled", false);
                    } else {
                        $("#loader").hide();
                        $("#amount").parent().parent().find('.text-danger').remove();
                        $("#amount").addClass("is-invalid");
                        $('<small class="text-danger">مقدار وارد شده ارزش تبادل ندارد</small>').insertAfter($("#amount").parent());
                        $("#exchangebtn").prop("disabled", true);
                    }
                }
            });
        }
    });
    $("#exchangebtn").click(function () {
        $('.text-danger').remove();
        if (isVerified) {
            var canPass = true;
            if ($("#amount").val() === '') {
                $("#amount").addClass("is-invalid");
                $("#amount").parent().find('.text-danger').remove();
                $('<small class="text-danger">مقدار کوین انتخابی را وارد کنید</small>').insertAfter($("#amount").parent());
                canPass = false;
            }
            if ($("#walletAddressInput").val() === '') {
                $("#walletAddressInput").addClass("is-invalid");
                $("#walletAddressInput").parent().find('.text-danger').remove();
                $('<small class="text-danger">آدرس کیف پول را وارد کنید.</small>').insertAfter("#walletAddressInput");
                canPass = false;
            }



            if (canPass) {
                $('.text-danger').remove();
                var from_coin = $("#from_coin").val();
                var to_coin = $("#to_coin").val();
                var amount = $("#amount").val();
                var wallet = $("#walletAddressInput").val();
                $(this).prop("disabled", true);
                try {
                    $.post("/exchange?time", {_token: $("meta[name='csrf-token']").attr("content"), from: from_coin, to: to_coin, amount: amount, wallet: wallet, type: dataType}, function (data) {
                        if (data.result.address_from) {
                            data = data.result;
                            $("#walletAddress").text(data.address_from);
                            qrcode.makeCode(data.address_from);
                            $("#amoutcoin").text(data.amount_from + "" + from_coin);
                            $("#targetamount").text(data.amount_to + "" + to_coin);
                            $("#paybox").show();
                            $("#exchangebox").hide();
                            setInterval(function () {
                                var sec = parseInt($("#sec").text());
                                var minute = parseInt($("#minute").text());
                                sec--;
                                if (sec < 0) {
                                    sec = 59;
                                    $("#sec").text(sec);
                                    minute--;
                                } else {
                                    $("#sec").text(sec);
                                }

                                if (minute < 0) {
                                    Swal.fire("پایان مهلت پرداخت", "مهلت پرداخت به پایان رسید", "error");
                                    $("#paybox").hide(1000);
                                    $("#exchangebox").show(1000);
                                } else {
                                    $("#minute").text(minute);
                                }

                            }, 1000);
                        } else {
                            $("#exchangebtn").prop("disabled", false);

                            if (data.result) {
                                Swal.fire("حساب شما احراز هویت نشده!", "", "error");
                            } else {
                                if (data.msg === "آدرس کیف‌پول اشتباه است.") {
                                    $("#walletAddressInput").addClass("is-invalid");
                                    $("#walletAddressInput").parent().find('.text-danger').remove();
                                    $('<small class="text-danger">آدرس کیف پول اشتباه است.</small>').insertAfter("#walletAddressInput");
                                } else {
                                    $("#amount").addClass("is-invalid");
                                    $("#amount").parent().find('.text-danger').remove();
                                    $('<small class="text-danger">حداکثر مقدار تبادل این کوین ' + data.msg + ' است</small>').insertAfter($("#amount").parent());
                                }
                            }

                        }
                    }).fail(function (xhr, status, error) {
                        $("#exchangebtn").prop("disabled", false);
                    });
                } catch (e) {
                    Swal.fire("اطلاعات را کامل وارد کنید!", "", "error");
                    $("#exchangebtn").prop("disabled", false);
                }
            }
        } else {
            Swal.fire("خطا", "حساب شما احراز هویت نشده!", "error");
            return false;
        }
    });
});


setTimeout(function () {
    if ($("#amount").val() !== '') {
        $("#amount").trigger("change");
    }
}, 2000);