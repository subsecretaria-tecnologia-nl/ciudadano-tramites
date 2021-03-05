@php
	// dd($info);
@endphp

<!DOCTYPE html>
<html>
<head>
	<title>{{ $info->tramite }}</title>
	<style type="text/css">
		body{
			background-color: white;
			padding: 0;
			margin: 0;
			font-family: sans-serif;
			font-size: 12px;
		}

		p{
			font-size: .8em;
			color: #999 !important;
		}

		h1 {
			font-size: 1em;
		}
		
		th {
			height: 80px;
			vertical-align: 0px;
		}

		td{
			padding: 8px;
		}

		.border td:nth-child(1) { 
			border: 5px solid #f0f9fc;
			border-spacing: 10px;
			border-collapse: separate;
			width: 90%;
			height: 100px;
			padding: 0.5rem

		}
		.border td:nth-child(2) { 
			border: 5px solid #f0f9fc;
			border-spacing: 10px;
			border-collapse: separate;
			width: 90%;
			height: 100px;
			padding: 0.5rem
		}

		.text-uppercase{
			text-transform: uppercase;
		}

		strong{
			color: #555;
			font-weight: bold;
		}

		.enajenante{
			background-color: #f0f9fc !important;
		}
		.titulo1{
			text-align: center; 
			padding:20px;
		}
		.titulo2{
			text-align: center;
		}
		.escudo{
			text-align: left
		}
		.columna{
			max-width: 33%;
			min-width: 33%;
		}
		.value{
			color: grey !important; 
		}
		.border_bottom{
			border-bottom: 1px solid grey;
		}
		table{
			border-collapse: collapse; 
		}
		.datos-enajenante{
			background-color: #f1f9fc;
		}
		.footer{
			position:fixed;
			left:0px;
			bottom:0px;
			height:30px;
			width:100%;
			border-top: 1px solid grey;
		}
		.motivo-fundamento{
			border = 1;
		}
	</style>
</head>
<body>
	<table  style="width: 100%; margin-top:0px" border="0">
		<thead class="border_bottom" >
			<tr class="header">
				<th colspan="3" class="escudo">
					<div style="padding:20px" ><img src="{{public_path('images/icon.svg')}}" width="100"></div> 
				</th>
				<th class="columna">
					<div style="padding:20px"><img src="{{public_path('images/logo.svg')}} " width="180"></div>
				</th>
			</tr>
		</thead>
		
		<tbody>
			<tr  style="height: 100px">
				<td class='titulo1 text-uppercase ' colspan="4"> <strong> DECLARACION DEL{{ $info->tramite }} <br> REALIZADAS EN EL ESTADO DE NUEVO LEÓN </strong> </td>
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
				<td style="width: 1%">fecha</td>
				<td style="width: 1%" colspan="2">Autorizacion pago</td>
				<td style="width: 1%" >Pago realizado mediante</td>
			</tr>
			<tr>
				<td class="columna value" > 11-22-11</td>
				<td class="columna value" colspan="2"> si </td>
				<td class="columna value" >  netPay  </td>
			</tr>
			<tr>
				<td class="columna">% DE PROPIEDAD QUE ENAJENA</td>
				<td class="columna" colspan="2">MONTO DE OPERACIÓN</td>
				<td class="columna"></td>
			</tr>
			<tr>
				<td class="columna value" >{{-- <p>{{  $enajenante->{'porcentajeCompra'} ?? ''  }}</p> --}}</td>
				<td class="columna value" colspan="2">{{$enajenante->datosParaDeterminarImpuesto->{'montoOperacion'} }}</td>
				<td class="columna"></td>
			</tr>
			<tr >
				<td  colspan="4" class="titulo1"> <strong> DATOS DEL ENAJENANTE </strong></td>
			</tr>
			<tr class="datos-enajenante">
					<td class="columna ">REGISTRO FEDERAL DEL CONTRIBUYENTE:</td>
					<td class=" columna " colspan="2">CLAVE ÚNICA DE REGISTRO DE POBLACIÓN:</td>
					<td class="columna ">CLAVE DE ELECTOR (INE):</td>
				</tr>
				<tr class="datos-enajenante">
					<td class="columna value">{{ $enajenante->datosPersonales->{'rfc'} ?? ''  }}</td>
					<td class="columna value" colspan="2">CLAVE ÚNICA DE REGISTRO DE POBLACIÓN:</td>
					<td class="columna value">{{ $enajenante->datosPersonales->{'claveIne'} ?? ''  }}</td>
				</tr>
				<tr class="datos-enajenante">
					<td class="columna ">NOMBRE:</td>
					<td class="columna "colspan="2">APELLIDO PATERNO:</td>
					<td class="columna ">APELLIDO MATERNO:</td>
				</tr>
				<tr class="datos-enajenante">
					<td class="columna value">{{ $enajenante->datosPersonales->{'nombre'} ?? ''  }}</td>
					<td class="columna value" colspan="2">{{  $enajenante->datosPersonales->{'apPat'} ?? ''  }} </td>
					<td class="columna value">{{  $enajenante->datosPersonales->{'apMat'} ?? ''  }}</td>
				</tr>
				<tr>
					<td class="titulo1" colspan="2"> <strong> MOTIVO POR EL QUE DECLARA EN CEROS </strong></td>
					<td class="titulo1" colspan="2"> <strong> FUNDAMENTO LEGAL</strong></td>
				</tr>
					<tr class="border">
						<td clas="motivo-fundamento" colspan="2">...</td>
						<td class="motivo-fundamento" colspan="2">...</td>
					</tr>

		</tbody>
	</table>
	<div class="footer">
		<p >QUE LA NOTARIA SUBA EL ARCHIVO DE CALCULO DEL ISR CONFORME AL 126 (EXCEL O XML).<p>
		<p >QUE LA NOTARIA SUBA ARCHIVO DE LA DECLARACION AL SAT (XML). <p>
 	 </div>
</body>
</html>