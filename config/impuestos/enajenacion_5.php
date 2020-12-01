<?php

return
	array (

		"Tipo" => "Impuesto",

		"Datos del Inmueble" => array(
				"Número de escritura o Minuta" => array(
					"tipo" 		=> "int",
					"length"	=> 10,
					"value"	=> false,
					"formula"	=> false,
					"index"		=> false,
				),
				"Fecha de escritura o Minuta" => array(
					"tipo" 		=> "date",
					"length"	=> 18,
					"index"		=> 'FE',
					"formula"	=> false,
					"value"	=> false,
				),
				"Municipio" => array(
					"tipo"		=> "list",
					"index"		=> false,
					"formula"	=> false,
					"lenght"	=> false,
					"value"	=> array(
						"Abasolo", "Monterrey"
					)
				),
				"Expediente Catastral" => array(
					"tipo" 		=> "int",
					"length"	=> 10,
					"index"		=> false,
					"formula"	=> false,
					"value"	=> false,
				),
				"Domicilio del inmueble" => array(
					"tipo" 		=> "varchar",
					"length"	=> 100,
					"value"	=> false,
					"index"		=> false,
					"formula"	=> false,
					"expreg"	=> false,
				),
				"% de la propiedad que enajena" => array(
					"tipo" 		=> "int",
					"length"	=> 10,
					"index"		=> false,
					"formula"	=> false,
					"value"		=> false,
					"max_value"	=> 99
				),
				"Monto de operación(reportado en el aviso de enajenación)" => array(
					"tipo" 		=> "int",
					"length"	=> 15,
					"index"		=> false,
					"formula"	=> false,
					"value"		=> false,
				),
		),

		"Datos del Enajenante" => array(
			"Persona Física" => array(
				"tipo"		=> "radio",
				"value"	=> "persona_fisica",
				"formula"	=> false,
				"expreg"	=> false,
				"dependencias" => array( // <== CAMPOS DEPENDIENTES
					"Registro Federal de Contribuyente" => array(
						"tipo"		=> "varchar",
						"length"	=> 13,
						"index"		=> false,
						"value"	=> false,
						"formula"	=> false,
						"expreg"	=> "SDFSFSFS",
					),
					"CURP" => array(
						"tipo"		=> "varchar",
						"index"		=> false,
						"length"	=> 18,
						"value"	=> false,
						"formula"	=> false,
						"expreg"	=> "sfsfsfsdfsfs",
					),
					"IFE" => array(
						"tipo"		=> "varchar",
						"length"	=> 18,
						"index"		=> false,
						"value"	=> false,
						"formula"	=> false,
						"expreg"	=> false,
					),
					"Nombre" => array(
						"tipo"		=> "varchar",
						"length"	=> 100,
						"index"		=> false,
						"value"	=> false,
						"formula"	=> false,
						"expreg"	=> false,
					),
					"Apellido paterno" => array(
						"tipo"		=> "varchar",
						"length"	=> 100,
						"index"		=> false,
						"value"	=> false,
						"formula"	=> false,
						"expreg"	=> false,
					),
					"Apellido materno" => array(
						"tipo"		=> "varchar",
						"length"	=> 100,
						"index"		=> false,
						"value"	=> false,
						"formula"	=> false,
						"expreg"	=> false,
					),
				)
			),
			"Persona Moral" => array(
				"tipo"		=> "radio",
				"value"	=> "persona_fisica",
				"formula"	=> false,
				"expreg"	=> false,
				"dependencias" => array( // <== CAMPOS DEPENDIENTES
					"Registro Federal de Contribuyente" => array(
						"tipo"		=> "varchar",
						"length"	=> 12,
						"formula"	=> false,
						"value"	=> false,
						"index"		=> false,
						"expreg"	=> "SDFSFSFS",
					),
					"Razón social" => array(
						"tipo"		=> "varchar",
						"length"	=> 100,
						"index"		=> false,
						"formula"	=> false,
						"value"	=> false,
						"expreg"	=> false,
					)
				)
			)
		),
		"Declaración normal" => array(

			"Ganancia obtenida"	=> array(
				"tipo" 		=> "int",
				"length"	=> 15,
				"value"	=> false,
				"index"		=> 'A',
				"expreg"	=> false,
				"formula"	=> false,
			),
			"Pago provisional conforme al artículo 126 LISR" => array(
				"tipo" 		=> "int",
				"length"	=> 15,
				"expreg"	=> false,
				"index"		=> 'C',
				"value"	=> false,
				"formula"	=> false,
			),

			"Multa por corrección fiscal" => array(
				"tipo" 		=> "int",
				"length"	=> 15,
				"expreg"	=> false,
				"index"		=> 'F',
				"value"		=> false,
				"formula"	=> false, // donde el | define las agrupaciones numericas

			),
			/*
			los siguientes 3 los regresa el sistema cuando ejecuten el ws
			"Impuesto correspondiente a la entidad" => array(
				"tipo" 		=> "int",
				"length"	=> 15,
				"expreg"	=> false,
				"index"		=> 'D',
				"value"		=> false,
				"formula"	=> "[[C,<,B,C,B[[", // cuando recibamos [ simple al inicio de la cadena es una terna (C < B): C ? B
			),
			"Parte actualizada del impuesto" => array(
				"tipo" 		=> "int",
				"length"	=> 15,
				"expreg"	=> false,
				"index"		=> 'E',
				"value"		=> false,
				"formula"	=> "|,D,*,AA,|,-,D", // donde el | define las agrupaciones numericas

			),
			"Recargos" => array(
				"tipo" 		=> "int",
				"length"	=> 15,
				"expreg"	=> false,
				"index"		=> 'F',
				"value"		=> false,
				"formula"	=> "|,D,+,E,|,*,RR", // donde el | define las agrupaciones numericas

			),
			*/
			"Monto obtenido conforme al artículo 127 LISR"	=> array(
				"tipo"		=> "sistema",
				"ws"		=> "/impuesto/fecha_actual/FE/100000"
			),
			"Impuesto correspondiente a la entidad" => array(
				"tipo"		=> "sistema",
				"ws"		=> "response"
			),
			"Parte actualizada del impuesto" => array(
				"tipo"		=> "sistema",
				"ws"		=> "response"
			),
			"Recargos" => array(
				"tipo"		=> "sistema",
				"ws"		=> "response"
			),
			"Importe total" => array(
				"tipo"		=> "sistema",
				"ws"		=> "response"
			),
		),

		"Declaración complementaria" => array (

		),

		"Vigencia"	=>	15 /* valor dado en dias y se establece para la fecha despues de la escrituracion */




	);
