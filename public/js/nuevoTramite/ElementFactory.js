ElementFactory = {
    create: function( campo) {
		switch( campo.tipo ) {
			case "input":
				return new Input().setInfo( campo );
			case "select":
				return new Select().setInfo( campo );
			case "checkbox":
				return new Checkbox().setInfo( campo );
			case "option":
				let elem = new Radio();
				return elem.setInfo( campo );
			case "textbox":
				return new TextBox().setInfo( campo );
			default:
				return false;
		}
    },
};