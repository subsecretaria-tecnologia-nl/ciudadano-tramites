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
			font-size: 10px;
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
			padding: 15px
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
			bottom:55px;
			height:50px;
			width:100%;
		}
	</style>
</head>
<body>
	<table  style="width: 100%; margin-top:0px" border="0">
		<thead class="border_bottom" >
			<tr class="header">
				<th  class="escudo">
					<div style="padding:20px" ><img src="{{public_path('images/icon.svg')}}" width="100"></div> 
				</th>
				<th colspan="2" class='text-uppercase'"> <strong> DECLARACION DEL{{ $info->tramite }} <br> REALIZADAS EN EL ESTADO DE NUEVO LEÓN </strong> </th>
				<th class="">
					<div style="padding:20px"><img src="{{public_path('images/logo.svg')}} " width="180"></div>
				</th>
			</tr>
		</thead>
		
		<tbody>
		
			<tr style="padding-top:20px">
				<td class="titulo1" colspan="4"> <strong> DATOS DEL INMUEBLE(S)  QUE SE ENAJENA(N) </strong></td>
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
				<!-- <tr>
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
					<td class="columna value" >{{-- <p class="mt-0">{{ $enajenante->{'porcentajeCompra'} }}</p> --}}</td>
					<td class="columna value" colspan="2">{{$enajenante->datosParaDeterminarImpuesto->{'montoOperacion'} }}</td>
					<td class="columna"></td>
				</tr> -->
			<tr >
				<td class="titulo1" colspan="4"> <strong> DATOS DEL ENAJENANTE </strong></td>
			</tr>
				<tr class="datos-enajenante"">
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
				<tr class="datos-enajenante">
					<td class="columna ">% DE CO-PROPIEDAD:</td>
					<td class="columna "colspan="2"></td>
					<td class="columna "></td>
				</tr>
				<tr class="datos-enajenante">
					<td class="columna value">{{ $enajenante->{'porcentajeCompra'} ?? ''  }}</td>
					<td class="columna value" colspan="2"> </td>
					<td class="columna value"></td>
				</tr>
			<tr >
				<td class="titulo1" colspan="4"> <strong> DATOS PARA DETERMINAR EL IMPUESTO DE LA ENTIDAD FEDERATIVA </strong></td>
			</tr>
				<tr >
					<td class="columna ">TIPO DE DECLARACION</td>
					<td class=" columna " colspan="2">GANANCIA OBTENIDA</td>
					<td class="columna ">MONTO OBTENIDO CONFORME AL <br> ART 154 BIS DE LA LISR</td>
				</tr>
				<tr >
					<td class="columna value">{{ $info->solicitudes[0]->info->{'tipoTramite'} ?? ''  }}</td>
					<td class="columna value" colspan="2"> {{ $enajenante->datosParaDeterminarImpuesto->{'gananciaObtenida'} ?? ''}}</td>
					<td class="columna value">{{ $enajenante->detalle->Salidas->{'Monto obtenido conforme al art 127 LISR'} ?? ''  }}</td>
				</tr>
				<tr >
					<td class="columna ">PAGO PROVISIONAL CONFORME AL <br>	ART 154 BIS DE LISR</td>
					<td class=" columna " colspan="2">IMPUESTO CORRESPONDIENTE A LA <br> ENTIDAD FEDERATIVA</td>
					<td class="columna ">PARTE ACTUALZIADA DEL <br> IMPUESTO</td>
				</tr>
				<tr >
					<td class="columna value">{{ $enajenante->detalle->Salidas->{'Pago provisional conforme al art 126 LISR'} ?? ''  }}</td>
					<td class="columna value" colspan="2">{{ $enajenante->detalle->Salidas->{'Impuesto correspondiente a la entidad federativa'} ?? ''  }}</td>
					<td class="columna value">{{ $enajenante->detalle->Salidas->{'Parte actualizada del impuesto'} ?? ''  }}</td>
				</tr>
				<tr >
					<td class="columna ">RECARGOS</td>
					<td class=" columna " colspan="2">MULTA POR CORRECCION FISCAL</td>
					<td class="columna ">IMPORTE TOTAL</td>
				</tr>
				<tr >
					<td class="columna value">{{ $enajenante->detalle->Salidas->{'Recargos'} ?? ''  }}</td>
					<td class="columna value" colspan="2">{{$enajenante->detalle->Salidas->{'Multa corrección fiscal'} ?? ''}}</td>
					<td class="columna value">{{ $enajenante->detalle->Salidas->{'Importe total'} ?? ''  }}</td>
				</tr>
			<tr >
				<td class="titulo1" colspan="4"> <strong> CONTROL Y SEGUIMIENTO </strong></td>
			</tr>
				<tr class="datos-enajenante">
					<td class="columna ">ESTATUS</td>
					<td class=" columna " colspan="2">FECHA LIMITE DE PAGO</td>
					<td class="columna ">NO. FOLIO DE TESORERIA VIRTUAL</td>
				</tr>
				<tr class="datos-enajenante">
					<td class="columna value"></td>
					<td class="columna value" colspan="2"></td>
					<td class="columna value"></td>
				</tr>
				<tr class="datos-enajenante">
					<td class="columna ">FECHA DE PAGO</td>
					<td class=" columna " colspan="2">NO. DE OPERACION INTERNA</td>
					<td class="columna ">REFERENCIA BANCARIA</td>
				</tr>
				<tr class="datos-enajenante">
					<td class="columna value"></td>
					<td class="columna value" colspan="2">:</td>
					<td class="columna value"></td>
				</tr>

		
		
			
		</tbody>
	</table>
	<div class="footer">
		<table style="width: 100%; margin-top:0px; text-align:center; border-bottom: 1px solid grey; " >
				<tr class="">
					<td class=""></td>
					<td class=" "></td>
					<td class=" "></td>
				</tr>
				<tr class="">
					<td class=" ">LIC. JORGE ALBERTO SALAZAR SALAZAR</td>
					<td class="  ">SELLO DEL NOTARIO PUBLICO</td>
					<td class=" ">FIRMA DEL CONTRIBUYENTE</td>
				</tr>
		</table>
		<div  style="position:fixed;left:0px;bottom:0px;"> 
			<p >BAJO PROTESTA DE DECIR VERDAD MANIFIESTO QUE TODOS Y CADA UNO E LOS DATOS PROPORCIONADOS EN ESTA DECLARACION SON CIERTOS.<p>
		</div>
 	 </div>
</body>
</html>