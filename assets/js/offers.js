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
    var form = $("#form-wizard");
    form.steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        titleTemplate: '<span class="step-number">#index#</span> #title#',
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
            // Start validation; Prevent going forward if false
            return form.valid();
        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            form.submit();
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