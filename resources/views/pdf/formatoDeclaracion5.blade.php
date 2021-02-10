<!DOCTYPE html>
<html>
<head>
	<title>{{ $info->tramite }}</title>
	<link rel="stylesheet" type="text/css" href="{{ assets("css/app.css") }}">
	<style type="text/css">
		body{
			background-color: #f3f3f7;
			padding: 0;
			margin: 0;
			font-family: sans-serif;
		}

		.card{
			width: 95%;
			max-width: 792px;
			min-width: 792px;
			margin: 10px auto;
		}

		p{
			font-size: .9em;
			color: #999 !important;
		}

		h1 {
			font-size: 1em;
		}

		.text-uppercase{
			text-transform: uppercase;
		}

		strong{
			color: #555;
		}

		.enajenante{
			background-color: #f0f9fc !important;
		}
	</style>
</head>
<body>
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col">
					<img src="{{ assets("images/escudo.svg") }}" width="100">
				</div>
				<div class="col text-right">
					<img src="{{ assets("images/logo.svg") }}" width="250">
				</div>
			</div>
		</div>
		<div class="card-body pb-2">
			<h1 class="text-uppercase text-center"><strong>{{ $info->tramite }}</strong></h1>
			<div class="row mt-5">
				<div class="col">
					<p class="mb-0"><strong>NÚMERO DE ESCRITURA PÚBLICA O MINUTA</strong></p>
					<p class="mt-0">{{ $info->solicitudes[0]->info->campos->{'Escritura'} }}</p>
				</div>
				<div class="col"></div>
				<div class="col">
					<p class="mb-0"><strong>FECHA DE ESCRITURA PÚBLICA O MINUTA</strong></p>
					<p class="mt-0">{{ $info->solicitudes[0]->info->campos->{'FECHA DE ESCRITURA O MINUTA'} }}</p>
				</div>
			</div>
			<div class="row mt-6">
				<div class="col">
					<p class="mb-0"><strong>MUNICIPIO</strong></p>
					<p class="mt-0">{{ $info->solicitudes[0]->info->campos->Municipio[0] }}</p>
				</div>
				<div class="col">
					<p class="mb-0"><strong>NO. EXP. CATASTRAL</strong></p>
					<p class="mt-0">{{ $info->solicitudes[0]->info->campos->{'No. EXP. CATASTRAL'} }}</p>
				</div>
				<div class="col">
					<p class="mb-0"><strong>DOMICILIO DE UBICACIÓN DEL INMUEBLE</strong></p>
					<p class="mt-0">{{ $info->solicitudes[0]->info->campos->{'DOMICILO DE UBICACIÓN DEL INNMUEBLE'} }}</p>
				</div>
			</div>
			<div class="row mt-2 mb-3">
				<div class="col-4">
					<p class="mb-0"><strong>% DE PROPIEDAD QUE ENAJENA</strong></p>
					{{-- <p class="mt-0">{{ $info->solicitudes[0]->info->campos->{'Municipio'} }}</p> --}}
				</div>
				<div class="col">
					<p class="mb-0"><strong>MONTO DE OPERACIÓN</strong></p>
					<p class="mt-0">{{ $info->solicitudes[0]->info->campos->{'MONTO DE OPERACIÓN (reportado en el aviso de enajenación)'} }}</p>
				</div>
			</div>
			<h1 class="text-uppercase mt-6 text-left"><strong>DATOS DEL ENAJENANTE</strong></h1>
		</div>
		<div class="card-body enajenante pt-2">
			<div class="row m-0 mt-5">
				<div class="col-5 pl-0 py-1"><strong>REGISTRO FEDERAL DEL CONTRIBUYENTE:</strong></div>
				<div class="col py-1">{{ $info->solicitudes[0]->info->campos->{'RFC'} }}</div>
			</div>
			<div class="row m-0">
				<div class="col-5 pl-0 py-1"><strong>CLAVE ÚNICA DE REGISTRO DE POBLACIÓN:</strong></div>
				<div class="col py-1"></div>
			</div>
			<div class="row m-0">
				<div class="col-5 pl-0 py-1"><strong>CLAVE DE ELECTOR (INE):</strong></div>
				<div class="col py-1"></div>
			</div>
			<div class="row m-0">
				<div class="col-5 pl-0 py-1"><strong>NOMBRE:</strong></div>
				<div class="col py-1"></div>
			</div>
			<div class="row m-0">
				<div class="col-5 pl-0 py-1"><strong>APELLIDO PATERNO:</strong></div>
				<div class="col py-1"></div>
			</div>
			<div class="row m-0">
				<div class="col-5 pl-0 py-1"><strong>APELLIDO MATERNO:</strong></div>
				<div class="col py-1"></div>
			</div>
		</div>
		<div class="card-body pt-2">
		</div>
	</div>
</body>
</html>