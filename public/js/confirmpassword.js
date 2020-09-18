$(document).ready(function() {
    const urlParams = window.location.pathname;
    const token = urlParams.substr(19);
    // const token = new URLSearchParams(param);
    $.ajax({
        url: "/get_token",
        type: "GET",
        data: {
            token,
        },
        success: function(res) {
            console.log("token correcto");
        },
        error: function(res) {
            console.log(res);
            // window.location = "/error";
        }
    })
})

var validation;

document.addEventListener('DOMContentLoaded', function(e) {
    const form = document.getElementById('kt_confirm_password_form');
    validation = FormValidation.formValidation(
        document.getElementById('kt_confirm_password_form'), {
            fields: {
                password: {
                    validators: {
                        notEmpty: {
                            message: 'La contraseña es obligatoria'
                        },
                        regexp: {
                            regexp: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/,
                            message: 'La contraseña debe tener al entre 8 y 16 caracteres,al menos un dígito,' +
                                '<br>' + ' al menos una minúscula y al menos una mayúscula'
                        }
                    }
                },
                confirmPassword: {
                    validators: {
                        identical: {
                            compare: function() {
                                return form.querySelector('[name="password"]').value;
                            },
                            message: 'La confirmacion de contraseña no coincide'
                        },
                        regexp: {
                            regexp: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/,
                            message: 'La contraseña debe tener al entre 8 y 16 caracteres,al menos un dígito,' +
                                '<br>' + ' al menos una minúscula y al menos una mayúscula'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                bootstrap: new FormValidation.plugins.Bootstrap(),
                declarative: new FormValidation.plugins.Declarative()
            }
        }
    );
    form.querySelector('[name="password"]').addEventListener('input', function() {
        fv.revalidateField('confirmPassword');
    });
});





$('#kt_recovery_submit').on('click', function(e) {
    e.preventDefault();
    var email = $(document).find('input[name="email"]').val();
    validation.validate().then(function(status) {
        if (status == 'Valid') {
            $.ajax({
                url: "/login",
                type: "POST",
                data: {
                    email,
                },
                success: function(res) {
                    console.log(res);
                    swal.fire({
                        text: "Tu contraseña a sido actualizada",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Entendido",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    }).then(function() {
                        window.location = "/login?e=" + btoa(res);
                    });
                }
            });
        } else {
            swal.fire({
                text: "La contraseña no a sido actualizada, intenta nuevamente.",
                icon: "error",
                buttonsStyling: false,
                cxonfirmButtonText: "Entendido",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary"
                }
            }).then(function() {
                KTUtil.scrollTop();
            });
        }
    });
});