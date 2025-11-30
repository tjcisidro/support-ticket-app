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

$(document).ready(function () {
    $("form").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 6,
            },
            
        },
        messages: {
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address",
            },
            password: {
                required: "Please enter your password",
                minlength: "Password must be at least 6 characters",
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
                url: "/admin-authenticate",
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
                            "Admin authenticated successfully!",
                            "Success"
                        );
                        form.reset();
                        window.location.href = "/admin-dashboard";
                    } else {
                        toastr["error"](
                            "Authentication failed. Please try again.",
                            "Error"
                        );
                    }
                    submitButton.prop("disabled", false).text("Login");
                },
                error: function (xhr) {
                    toastr["error"](
                        xhr.responseJSON?.message || "An error occurred. Please try again.",
                        "Error"
                    );
                    submitButton.prop("disabled", false).text("Login");
                },
            });

            return false;
        },
    });
});