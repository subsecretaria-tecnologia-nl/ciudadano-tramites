<template>
	<div id="contenedorCampos">
        <div class="mb-10 font-weight-bold text-dark">Enter your Account detalles men</div>
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label>First Name</label>
            <input type="text" class="form-control form-control-solid form-control-lg" name="fname" placeholder="First Name" value="John">
            <span class="form-text text-muted">Please enter your first name.</span>
        <div class="fv-plugins-message-container"></div></div>
        <!--end::Input-->
        <!--begin::Input-->
        <div class="form-group fv-plugins-icon-container">
            <label>Last Name</label>
            <input type="text" class="form-control form-control-solid form-control-lg" name="lname" placeholder="Last Name" value="Wick">
            <span class="form-text text-muted">Please enter your last name.</span>
        <div class="fv-plugins-message-container"></div></div>
        <!--end::Input-->
        <div class="row">
            <div class="col-xl-6">
                <!--begin::Input-->
                <div class="form-group fv-plugins-icon-container">
                    <label>Phone</label>
                    <input type="tel" class="form-control form-control-solid form-control-lg" name="phone" placeholder="phone" value="+61412345678">
                    <span class="form-text text-muted">Please enter your phone number.</span>
                <div class="fv-plugins-message-container"></div></div>
                <!--end::Input-->
            </div>
            <div class="col-xl-6">
                <!--begin::Input-->
                <div class="form-group fv-plugins-icon-container">
                    <label>Email</label>
                    <input type="email" class="form-control form-control-solid form-control-lg" name="email" placeholder="Email" value="john.wick@reeves.com">
                    <span class="form-text text-muted">Please enter your email address.</span>
                <div class="fv-plugins-message-container"></div></div>
                <!--end::Input-->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['campos'],
        data() {
            return {
                tramites: []
            }
        },
        mounted() {
            axios
              .get(urlObtnerCampos)
              .then(response => {
              	console.log( response )
                this.campos = response.data;
              })
        }
    }
</script>
