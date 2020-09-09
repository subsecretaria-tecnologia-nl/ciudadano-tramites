<div class="card bg-transparent border-0">
	<div class="card-body justify-content-center align-items-center text-center">
		<img src="{{ asset("images/logo.svg") }}" alt="" width="400">
		<h1 class="mt-20"><strong>RECUPERAR CONTRASEÑA</strong></h1>
		<p>Ingrese su correo electronico o nombre de usuario :</p>
		<form class="form fv-plugins-bootstrap fv-plugins-framework" novalidate="novalidate" id="kt_login_signin_form">
			<div class="form-group fv-plugins-icon-container">
				<input
					class="form-control form-control-solid bg-light h-auto py-5 px-6"
					type="text"
					placeholder="Nombre de usuario o Correo electrónico"
					name="username"
					autocomplete="off"

					data-fv-not-empty="true"
					data-fv-not-empty___message="El nombre de usuario o correo electrónico es requerido" 
				>
				<div class="fv-plugins-message-container"></div>
			</div>
			<!--begin::Action-->
			<div class="form-group d-flex flex-wrap justify-content-between align-items-center">
				<button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bold form-control px-6 py-3 h-auto" >Inicar sesión</button>
			</div>
			<!--end::Action-->
		</form>
	</div>
</div>