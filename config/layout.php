<?php
return [
	"args" => [
		"title" => env("APP_NAME") ?? "Gobierno del Estado de Nuevo León",
		"empty_layout" => false,
		"fluid_container" => false,
		"footer" => [
			"style" => "minify"
		],
		"notifications" => [
			"total" => 3,
			"read" => 0,
			"items" => [
				[
					"title" => "En este momento <strong>AFIRME</strong> no esta notificando los pagos en línea.",
					"content" => "Si requiere ayuda con algún pago llama al 2020-5555.",
					"read" => false,
					"icon" => "",
					"date" => "2020-08-10 00:00:00"
				],
				[
					"title" => "Utiliza <strong>Banamex y Bancomer</strong> para pagar en línea.",
					"content" => "Si requiere ayuda con algún pago llama al 2020-5555.",
					"read" => false,
					"icon" => "",
					"date" => "2020-08-10 00:00:00"
				],
				[
					"title" => "En este momento AFIRME no esta notificando los pagos en línea.",
					"content" => "",
					"read" => false,
					"icon" => "",
					"date" => "2020-08-10 00:00:00"
				]
			]
		]
	]
];