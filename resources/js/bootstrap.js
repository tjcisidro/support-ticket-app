import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

//initialize toaster
toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
};

$(".form-group #phone").on("keypress", function (e) {
    var char = String.fromCharCode(e.which);
    if (!/[\+0-9]/.test(char)) {
        e.preventDefault();
    }
});

//validate and submit form via AJAX
$(document).ready(function () {
    $("form").validate({
        rules: {
            subject: {
                required: true,
                minlength: 5,
            },
            description: {
                required: true,
                minlength: 10,
            },
            full_name: {
                required: true,
                minlength: 2,
            },
            email: {
                required: true,
                email: true,
            },
            phone: {
                minlength: 10,
                number: true,
            },
            consent: {
                required: true,
            },
        },
        messages: {
            subject: {
                required: "Please enter a subject",
                minlength: "Subject must be at least 5 characters",
            },
            description: {
                required: "Please provide a description",
                minlength: "Description must be at least 10 characters",
            },
            full_name: {
                required: "Please enter your full name",
                minlength: "Name must be at least 2 characters",
            },
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address",
            },
            consent: {
                required: "You must consent to data processing",
            },
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.css({
                color: "#e53e3e",
                "font-size": "0.85rem",
                "margin-top": "0.25rem",
                display: "block",
            });
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            var formData = new FormData(form);
            var submitButton = $(form).find('button[type="submit"]');

            submitButton.prop("disabled", true).text("Submitting...");

            $.ajax({
                url: "/submit-ticket",
                type: "POST",
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        console.log("Created by: Timothy Isidro");
                        toastr["success"](
                            "Ticket submitted successfully!",
                            "Success"
                        );
                        form.reset();
                    } else {
                        console.log("Submission failed:", response);
                        toastr["error"](
                            "Submission failed. Please try again.",
                            "Error"
                        );
                    }
                    submitButton.prop("disabled", false).text("Submit Ticket");
                },
                error: function (xhr, status, error) {
                    toastr["error"](
                        "An error occurred. Please try again.",
                        "Error"
                    );
                    submitButton.prop("disabled", false).text("Submit Ticket");
                },
            });

            return false;
        },
    });
});
