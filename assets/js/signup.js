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
    form.steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        stepsOrientation: "vertical",
        onStepChanging: function (event, currentIndex, newIndex) {
            // Always allow going backward even if the current step contains invalid fields!
            if (currentIndex > newIndex) {
                return true;
            }
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
                return false;
            }

            if ($("input[name='nationalcode']").val() !== "") {
                if (!isValidNationalCode($("input[name='nationalcode']").val())) {
                    $("input[name='nationalcode']").addClass("is-invalid");
                    return false;
                }
            }

            // Start validation; Prevent going forward if false
            return form.valid();
        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            if ($("#password1").val() === $("#password2").val()) {
                form.submit();
            } else {
                $("#password2").addClass("is-invalid");
                var error = '<label id="password2-error" class="invalid-feedback active" for="password2" style="">رمز عبور و تاییدیه آن برابر نیست</label>'
                $("#password2").parent().append(error);
                return false;
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