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
			font-size: 14px;
		}

		.card{
			width: 95%;
			max-width: 792px;
			min-width: 792px;
			margin: 10px auto;
		}

		p{
			font-size: .6em;
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
		.titulo1{
			padding-left: 30%;
		}
		.titulo2{
			padding-left: 38%;
		}
		.row-table{
			/* margin: 10px 0px 10px 0px */
			height: 80px;
		}
		.columna{
			max-width: 250%;
			min-width: 250%;
		}
	</style>
</head>
<body>
<table>
	<thead>
		<tr>
			<th></th>
			<th></th>
			<!-- <th><img src="{{ assets("./images/escudo.svg") }}" width="100"></th> -->
			<!-- <th>  <img id="logo_gob" src="{{asset('images/logo.png')}}"> </th> -->
			<!-- <th><img src="../public/images/escudo.svg" width="100"></th> -->
			<!-- <th><img src="{{ url('./images/logo.png') }} " width="250"></th> -->
			<th>
				<div style="padding:20px"><img src="{{ public_path('images/logo.png') }} " width="250"></div>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr class='row-table' style="height: 100px">
			<td class='titulo1' colspan="4">5% DE ENAJENACIÓN DE INMUEBLES</td>
		</tr>
		<tr>
			<td class="columna">NÚMERO DE ESCRITURA PÚBLICA O MINUTA</td>
			<td class="columna" colspan="2"></td>
			<td class="columna" >FECHA DE ESCRITURA PÚBLICA O MINUTA</td>
		</tr>
		<tr>
			<td class="columna">{{ $info->solicitudes[0]->info->campos->{'Escritura'} }}</td>
			<td class="columna"  colspan="2"></td>
			<td class="columna">{{ $info->solicitudes[0]->info->campos->{'FECHA DE ESCRITURA O MINUTA'} }}</td>
		</tr>
		<tr>
			<td class="columna">MUNICIPIO</td>
			<td class="columna" colspan="2">NO. EXP. CATASTRAL</td>
			<td class="columna" >DOMICILIO DE UBICACIÓN DEL INMUEBLE</td>
		</tr>
		<tr>
			<td class="columna" >{{ $info->solicitudes[0]->info->campos->Municipio[0] }}</td>
			<td class="columna" colspan="2">{{ $info->solicitudes[0]->info->campos->{'No. EXP. CATASTRAL'} }}</td>
			<td class="columna" >{{ $info->solicitudes[0]->info->campos->{'DOMICILO DE UBICACIÓN DEL INNMUEBLE'} }}</td>
		</tr>
		<tr>
			<td class="columna">% DE PROPIEDAD QUE ENAJENA</td>
			<td class="columna" colspan="2">MONTO DE OPERACIÓN</td>
			<td class="columna"></td>
		</tr>
		<tr>
			<td class="columna" >{{-- <p class="mt-0">{{ $info->solicitudes[0]->info->campos->{'Municipio'} }}</p> --}}</td>
			<td class="columna" colspan="2">{{ $info->solicitudes[0]->info->campos->{'MONTO DE OPERACIÓN (reportado en el aviso de enajenación)'} }}</td>
			<td class="columna"></td>
		</tr>
		<tr class='row-table'>
			<td class='titulo2' colspan="4">DATOS DEL ENAJENANTE</td>
		</tr>
		<tr>
			<td>REGISTRO FEDERAL DEL CONTRIBUYENTE:</td>
			<td>{{ $info->solicitudes[0]->info->campos->{'RFC'} }}</td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>MAVA900222JQ9</td>
			<td></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>CLAVE ÚNICA DE REGISTRO DE POBLACIÓN:</td>
			<td></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>CLAVE DE ELECTOR (INE):</td>
			<td></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>NOMBRE:</td>
			<td></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>APELLIDO PATERNO:</td>
			<td></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>APELLIDO MATERNO:</td>
			<td></td>
			<td colspan="2"></td>
		</tr>
	</tbody>
</table>
</body>
</html>