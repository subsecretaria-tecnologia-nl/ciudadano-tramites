ElementFactory = {
    create: function( campo) {
		switch( campo.tipo ) {
			case "input":
				var input = new Input().setInfo( campo );
				var obj = Object.create( input );
				return input;//;
			case "select":
				var select = new Select(campo);
				var obj = Object.create( select );
				return select;//.setInfo( campo );
			case "checkbox":
				var checkbox = new Checkbox(campo);
				var obj = Object.create( checkbox );
				return checkbox//.setInfo( campo );
			case "option":
				var option = new Radio(campo);
				var obj = Object.create( option );
				return option//.setInfo( campo );
			case "textbox":
				var textbox = new TextBox(campo);
				var obj = Object.create( textbox );
				return textbox//.setInfo( campo );
			default:
				return false;
		}
    },
};