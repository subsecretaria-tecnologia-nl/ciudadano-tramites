@php
	// dd($info);
@endphp

<!DOCTYPE html>
<html>
<head>
	<title>{{ $info->tramite }}</title>
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
		
		th {
			height: 120px;
		}

		td{
			padding: 8px;
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
			padding-left: 33%;
		}
		.titulo2{
			padding-left: 38%;
		}
		.row-table{
			/* margin: 10px 0px 10px 0px */
			height: 60px;
		}
		.columna{
			max-width: 33%;
			min-width: 33%;
		}
		.value{
			color: grey;
		}
	</style>
</head>
<body>
<table  style="width: 100%;">
	<thead align="right">
		<tr>
			<th class="columna"></th>
			<th class="columna"></th>
			<th class="columna">
				<div style="padding:20px"><img src="{{public_path('images/escudo.svg')}}" width="100"></div> 
			</th>
			<th class="columna">
				<div style="padding:20px"><img src="{{public_path('images/logo.svg')}} " width="180"></div>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr class='row-table' style="height: 100px">
			<td class='titulo1 text-uppercase  row-table' colspan="4">{{ $info->tramite }}</td>
		</tr>
		<tr>
			<td class="columna">NÚMERO DE ESCRITURA PÚBLICA O MINUTA</td>
			<td class="columna"  colspan="2"></td>
			<td class="columna"  >FECHA DE ESCRITURA PÚBLICA O MINUTA</td>
		</tr>
		<tr>
			<td class="columna value"  style="width: 33%;">{{ $info->solicitudes[0]->info->campos->{'Escritura'} }}</td>
			<td class="columna value" style="width: auto;"  colspan="2"></td>
			<td class="columna value" style="width: 33%;">{{ $info->solicitudes[0]->info->campos->{'Fecha de escritura o minuta'} }}</td>
		</tr>
		<tr>
			<td style="width: 1%">MUNICIPIO</td>
			<td style="width: 1%" colspan="2">NO. EXP. CATASTRAL</td>
			<td style="width: 1%" >DOMICILIO DE UBICACIÓN DEL INMUEBLE</td>
		</tr>
		<tr>
			<td class="columna value" >{{ $info->solicitudes[0]->info->campos->Expedientes->expedientes[0]->municipio->{'nombre'} }}</td>
			<td class="columna value" colspan="2">{{ $info->solicitudes[0]->info->campos->Expedientes->expedientes[0]->{'expediente'} }}</td>
			<td class="columna value" >{{ $info->solicitudes[0]->info->campos->Expedientes->expedientes[0]->direccion->datos_direccion[0]->{'calle'} }}  </td>
		</tr>
		<tr>
			<td class="columna">% DE PROPIEDAD QUE ENAJENA</td>
			<td class="columna" colspan="2">MONTO DE OPERACIÓN</td>
			<td class="columna"></td>
		</tr>
		<tr>
			<td class="columna value" >{{-- <p class="mt-0">{{ $enajenante->{'porcentajeCompra'} }}</p> --}}</td>
			<td class="columna value" colspan="2">{{$enajenante->datosParaDeterminarImpuesto->{'montoOperacion'} }}</td>
			<td class="columna"></td>
		</tr>
		<tr class='row-table '>
			<td class='row-table titulo2' colspan="4">DATOS DEL ENAJENANTE</td>
		</tr>
		<tr>
			<td>REGISTRO FEDERAL DEL CONTRIBUYENTE:</td>
			<td class="value">{{ $enajenante->datosPersonales->{'rfc'}  }}</td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>CLAVE ÚNICA DE REGISTRO DE POBLACIÓN:</td>
			<td class="value"> {{ $enajenante->datosPersonales->{'curp'}  }}</td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>CLAVE DE ELECTOR (INE):</td>
			<td class="value">{{ $enajenante->datosPersonales->{'claveIne'}  }}</td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>NOMBRE:</td>
			<td class="value">{{ $enajenante->datosPersonales->{'nombre'}  }}</td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>APELLIDO PATERNO:</td>
			<td class="value">{{  $enajenante->datosPersonales->{'apPat'}  }} </td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td>APELLIDO MATERNO:</td>
			<td class="value">{{  $enajenante->datosPersonales->{'apMat'}  }}</td>
			<td colspan="2"></td>
		</tr>
	</tbody>
</table>
</body>
</html>