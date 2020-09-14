ElementFactory = {
    create: function( campo) {
		switch( campo.tipo ) {
			case "input":
				return new Input().setInfo( campo );
			case "select":
				return new Select().setInfo( campo );
			case "checkbox":
				return new Checkbox().setInfo( campo );
			default:
				return false;
		}
    },
};