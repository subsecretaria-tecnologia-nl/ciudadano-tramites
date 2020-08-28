<div class="card bg-transparent border-0">
	<div class="card-body justify-content-center align-items-center text-center">
		<img src="{{ asset("images/logo.svg") }}" alt="" width="400">
		<h1 class="mt-20"><strong>INICIA SESIÓN</strong></h1>
		<p>Ingrese sus datos para iniciar sesión en su cuenta:</p>
		<form class="form fv-plugins-bootstrap fv-plugins-framework" novalidate="novalidate" id="kt_login_signin_form">
			<div class="form-group fv-plugins-icon-container">
				<input
					class="form-control form-control-solid bg-light h-auto py-5 px-6"
					type="text"
					placeholder="Nombre de Usuario o Correo Electrónico"
					name="username"
					autocomplete="off"

					data-fv-not-empty="true"
					data-fv-not-empty___message="El Nombre de Usuario o Correo Electrónico es Requerido" 
				>
				<div class="fv-plugins-message-container"></div>
			</div>
			<div class="form-group fv-plugins-icon-container">
				<input
					class="form-control form-control-solid bg-light h-auto py-5 px-6"
					type="password"
					placeholder="Contraseña"
					name="password"
					autocomplete="off"

					data-fv-not-empty="true"
					data-fv-not-empty___message="La Contraseña es Requerida" 

					data-fv-regexp="false"
					data-fv-regexp___regexp="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$"
					data-fv-regexp___message="La contraseña de ser de al menos 8 caracteres,<br>contener al menos una mayúscula, un número y un caracter especial."
				>
				<div class="fv-plugins-message-container"></div>
			</div>
			<!--begin::Action-->
			<div class="form-group d-flex flex-wrap justify-content-between align-items-center">
				<a href="javascript:;" class="text-dark-50 text-hover-primary my-3 mr-2" id="kt_login_forgot">¿Olvidaste tu Contraseña?</a>
				<button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3">Inicar Sesión</button>
			</div>
			<!--end::Action-->
		</form>
	</div>
</div>