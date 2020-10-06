var validation;

document.addEventListener('DOMContentLoaded', function(e) {
    validation = FormValidation.formValidation(
        document.getElementById('kt_login_signin_form'), {
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                bootstrap: new FormValidation.plugins.Bootstrap(),
                declarative: new FormValidation.plugins.Declarative()
            }
        }
    );
});

$('#kt_login_signin_submit').on('click', function(e) {
    e.preventDefault();

    var password = $(document).find('input[name="password"]').val();
    var username = $(document).find('input[name="username"]').val();

    validation.validate().then(function(status) {
        if (status == 'Valid') {
            console.log("");
            $.ajax({
                url: "/login",
                type: "POST",
                data: {
                    password,
                    username
                },
                success: function(res) {
                    console.log(res);
                    swal.fire({
                        text: "All is cool! Now you submit this form",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    }).then(function() {
                        window.location = "/dashboard"
                    });
                }
            });
        } else {
            swal.fire({
                text: "Sorry, looks like there are some errors detected, please try again.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary"
                }
            }).then(function() {
                KTUtil.scrollTop();
            });
        }
    });
});