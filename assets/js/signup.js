/* 
 * Copyright (C) 2020 Soroosh Tanzadeh
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
function enterOnclick() {
    x = $("#phonenumber").val();
    if (x !== "") {
        $("#entervcode").show();
        $("#enterphone").hide();
    }
}
function enterphone() {
    $("#entervcode").hide();
    $("#enterphone").show();
}

$(document).ready(function () {
    $.validator.addMethod("regex",
            function (value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            }, "مقدار ورودی را بررسی کنید"
            );
    $("#form,#ok,#timerbox,#form-title").hide();
    var form = $("#form-wizard-responsive");
    var bankValidator = new BankValidator();
    bankValidator.construct();
    form.steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        stepsOrientation: "vertical",
        onStepChanging: function (event, currentIndex, newIndex) {
            $(".text-danger").remove();
            // Always allow going backward even if the current step contains invalid fields!
            if (currentIndex > newIndex) {
                return true;
            }
            var validation = form.valid();
            // Clean up if user went backward before
            if (currentIndex < newIndex) {
                // To remove error styles
                $(".body:eq(" + newIndex + ") label.invalid-feedback", form).remove();
                $(".body:eq(" + newIndex + ") .invalid-feedback", form).removeClass(".invalid-feedback");
            }
            // Disable validation on fields that are disabled or hidden. 
            form.validate().settings.ignore = ":disabled,:hidden";

            if (!(/\b(?!(\d)\1{3})[13-9]{4}[1346-9][013-9]{5}\b/.test($("#inputZip").val()))) {
                $("#inputZip").addClass("is-invalid");
                if ($("#inputZip").val() !== "") {
                    $('<small class="text-danger">کدپستی نامعتبر است.</small>').insertAfter("#inputZip");
                }
                validation = false;
            }

            var phoneValidation = /^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/;



            if ($("input[name='nationalcode']").val() !== "") {
                if (!isValidNationalCode($("input[name='nationalcode']").val())) {
                    $("input[name='nationalcode']").addClass("is-invalid");
                    if ($("input[name='nationalcode']").val() !== "") {
                        $('<small class="text-danger">کدملی نامعتبر است.</small>').insertAfter("input[name='nationalcode']");
                    }
                    validation = false;
                }
            }

            if ($("input[name='telephone']").val() !== "") {
                if (!phoneValidation.test($("input[name='telephone']").val().substr(1))) {
                    $("input[name='telephone']").addClass("is-invalid");
                    if ($("input[name='telephone']").val() !== "") {
                        $('<small class="text-danger">تلفن ثابت نامعتبر است.</small>').insertAfter("input[name='telephone']");
                    }
                    validation = false;
                }
            }
            var validation = form.valid();
            $(".text-danger").remove();
            if (IMask($("input[name='card_number']")[0], {mask: $("input[name='card_number']").attr("data-mask")}).unmaskedValue !== "") {
                if (!bankValidator.validateCard($("input[name='card_number']").val())) {
                    $("input[name='card_number']").addClass("is-invalid");
                    if ($("input[name='card_number']").val() !== "") {
                        $('<small class="text-danger">شماره کارت ورودی نامعتبر است.</small>').insertAfter("input[name='card_number']");
                    }
                    validation = false;
                } else {

                }
            }

            if (IMask($("input[name='IBAN']")[0], {mask: $("input[name='IBAN']").attr("data-mask")}).unmaskedValue !== "") {
                if (!IBAN.isValid($("input[name='IBAN']").val())) {
                    $("input[name='IBAN']").addClass("is-invalid");
                    if ($("input[name='card_number']").val() !== "") {
                        $('<small class="text-danger">شماره شبا نامعتبر است.</small>').insertAfter("input[name='IBAN']");
                    }
                    validation = false;
                }
            }

            // Start validation; Prevent going forward if false
            return validation;
        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            if ($('#verifyLaws').is(':checked')) {

            } else {
                $(".text-danger").remove();
                $('<small class="text-danger">موافقت با قوانین و مقررات اجباری است</small>').insertAfter($("#verifyLaws").parent());
                return false;
            }
        },
        onFinished: function (event, currentIndex) {
            if ($('#verifyLaws').is(':checked')) {
                form.submit();
            } else {
                $(".text-danger").remove();
                $('<small class="text-danger">موافقت با قوانین و مقررات اجباری است</small>').insertAfter($("#verifyLaws").parent());
            }
        }
    }).validate({
        errorPlacement: function errorPlacement(error, element) {
            error.insertAfter(element);
        },
        rules: {
            confirm: {
                equalTo: "#password3"
            }
        },
        errorClass: 'invalid-feedback',
        validClass: 'valid-feedback',
        highlight: function (e) {
            $(e).addClass("is-invalid").removeClass('is-valid');
        },
        unhighlight: function (e) {
            $(e).removeClass("is-invalid").addClass('is-valid');
        },
    });


    $(".form-control").each(function () {
        if ($(this)[0].hasAttribute("data-mask")) {
            var element = this;
            IMask(
                    $(element)[0], {
                mask: $(element).attr("data-mask"),
                lazy: false
            });
        }
    });

    $(".form-control").on("keyup", function () {
        if ($(this)[0].hasAttribute("data-mask")) {
            if (/([A-Z]|[a-z]|[0-9])/.test(IMask($(this)[0], {mask: $(this).attr("data-mask")}).unmaskedValue)) {
                $(this).attr("style", "text-align: left;padding-left: 12px !important;direction: ltr;");
            }
        } else {
            if (/([A-Z]|[a-z]|[0-9])/.test($(this).val())) {
                $(this).attr("style", "text-align: left;padding-left: 12px !important");
            } else {
                $(this).attr("style", "text-align: right;");
            }

        }
    });


    $("input[name='card_number']").change(function () {
        var bankValidator = new BankValidator();
        bankValidator.construct();
        $(".text-danger").remove();
        $(".invalid-feedback").remove();
        $(".text-success").remove();
        if (IMask($("input[name='card_number']")[0], {mask: $("input[name='card_number']").attr("data-mask")}).unmaskedValue !== "") {
            bankname = bankValidator.recognizeBank(IMask($("input[name='card_number']")[0], {mask: $("input[name='card_number']").attr("data-mask")}).unmaskedValue);
            if (bankname) {
                $('<small class="text-success">' + bankname.persianName + '</small>').insertAfter("input[name='card_number']");
            } else {
                $('<small class="text-danger">شماره کارت ورودی نامعتبر است.</small>').insertAfter("input[name='card_number']");
            }
        }
    });

});

function isValidNationalCode(code) {
    if (code.length !== 10 || /(\d)(\1){9}/.test(code))
        return false;

    var sum = 0,
            chars = code.split('');

    for (var i = 0; i < 9; i++)
        sum += +chars[i] * (10 - i);

    var lastDigit,
            remainder = sum % 11;

    lastDigit = remainder < 2 ? remainder : 11 - remainder;

    return +chars[9] === lastDigit;
}
;