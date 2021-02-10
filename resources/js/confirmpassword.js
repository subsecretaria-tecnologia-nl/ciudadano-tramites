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





$('#kt_recovery_submit_confirm').on('click', function(e) {
    e.preventDefault();
    var url = window.location.href;
    const urlExt = url.replace(window.location.hostname, "");
    const email = new URL(url).searchParams.get('e');
    const password = $(document).find('input[name="password"]').val();
    const password_confirmation = $(document).find('input[name="confirmPassword"]').val();
    validation.validate().then(function(status) {
        if (status == 'Valid') {
            $.ajaxSetup({
                url: `${process.env.SESSION_HOSTNAME}/password/recovery/${urlExt}`,
                type: "POST",
                data: {
                    "email": email,
                    "password": password,
                    "password_confirmation": password_confirmation
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
                        redirect("/login?e=" + btoa(res));
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 401) {
                        alert(".");
                        return redirect("/login");
                    }
                }
            });
            $.ajax();
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