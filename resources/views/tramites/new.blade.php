<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">                
            <div>
                <span > inicio->Tramites en curso->Selección de Trámite</span>
            </div>
            <div class="card" style="padding-top: 10px; min-height: 600px;">
                <div class="card-body">
                    <div style="padding-top: 20px;">
                        <span class="card-title">
                            
                            <div style="padding-left: 1%">
                                <span class="titulo">Selección de Trámite</span>
                            </div>
                        </span>
                    </div>
                    <div class="dropdown-divider"></div>
                    <section id="tabs" >
					    <div class="container-fluid">
							<div class="row">

							    <!--Grid column-->
							    <div class="col-lg-8">

							      	<!-- Card -->
							      	<div class="mb-3">
							        	<div class="pt-4 wish-list" id="listTramites"></div>
							      	</div>
							      	<!-- Card -->


					      			<div class="mb-3" id="divMetodoPago"  style="display: none;">
										<div id="containerMetodoPago" > </div>  		
						        	</div>

							    </div>
							    <!--Grid column-->

							    <!--Grid column-->
							    <div class="col-lg-4">

							    	<!-- Card -->
							      	<div class="mb-3 shadow-sm p-3 bg-white rounded">  
							        	<div class="pt-4 ">

							          		<h5 class="mb-3">Total:</h5>

							          		<ul class="list-group list-group-flush">
							            		<li class="list-group-item d-flex justify-content-between align-items-center px-0 pb-0">
							              			Subtotal
							              			<span>$25.98</span>
							            		</li>
							            		<li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
							              			<div>
							                			<strong>Total</strong>
							                			<strong>
							                  				<p class="mb-0">(incluy IVA)</p>
							                			</strong>
							              			</div>
							              			<span><strong>$53.98</strong></span>
							            		</li>
							          		</ul>

							          		<button id="metodoPagoBtn" type="button" class="btn btn-primary btn-block" onclick="metodoPago()">
							          			Elegir método de pago
							          		</button>
							          		<button  id="addTramiteBTN" type="button" class="btn btn-default btn-block" onclick="openModalAdd()">Agregar Trámite</button>
							          		<button id="metodoPagoCancBtn" type="button" class="btn btn-danger btn-block" onclick="cancelarPago()" style="display: none;">
							          			Cancelar
							          		</button>
							        	</div>


							     	</div>
							      	<!-- Card -->
							    </div>
							    <!--Grid column-->
							</div>
							<!-- Grid row -->
					    </div>
					</section>

                </div>
            </div>
        </div>
        
    </div>
</div> 


<div id="modalDelete" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ></button>
                <h4 class="modal-title">Confirmación</h4>
            </div>
            <div class="modal-body">
                <p>
             		¿Eliminar Registro?
                </p>
                 <input hidden="true" type="text" name="iddeleted" id="iddeleted" class="iddeleted">
            </div>
            <div class="modal-footer">
	         	<button type="button" data-dismiss="modal" class="btn default" >Cancelar</button>
	            <button type="button"  class="btn green" onclick="eliminar()" id="btnDel">
	            	<i class="fa fa-check" id="iconBtnDel"></i> 
	            	Confirmar
	            </button>
	        </div>
	   </div>
	</div>
</div>

<div id="addTramite" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" ></button>
                <h4 class="modal-title">Agregar trámite</h4>
            </div>
            <div class="modal-body">

				<form class="p-5" action="#!" id="formularioDinamico">
				    <!-- Tramite -->
				    <div class="row">
					    <div class="col-lg-12" id="divSelectTramites" >
					    	<div class="form-group">
					            <label class="col-md-3 control-label">Trámite</label>
					            <div>
					                <select class="select2me form-control browser-default custom-select mb-4" name="tramitesSelect" id="tramitesSelect">
					                	<option value="limpia">------</option>
							    	</select>   
					            </div>
					        </div>
					    </div>
					</div>
					<div class="text-center" id="loadin" style="display: none; margin-bottom: 9px;" >
						<div class="spinner-grow" role="status">
						  	<span class="sr-only">Loading...</span>
						</div>
					</div>
				    <div id="camposDinamicosDiv" class="row"></div>
				</form>

            </div>
            <div class="modal-footer">
	         	<button type="button" data-dismiss="modal" class="btn default" >Cancelar</button>
	            <button type="button"  class="btn green" onclick="eliminar()" id="btnAdd">
	            	<i class="fa fa-check" id="iconBtnAdd"></i> 
	            	Aceptar
	            </button>
	        </div>
	   </div>
	</div>
</div>

<link href="{{ asset('css/newTramite.css') }}" rel="stylesheet" type="text/css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/nuevoTramite/inputClass.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/nuevoTramite/selectClass.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/nuevoTramite/checkboxClass.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/nuevoTramite/ElementFactory.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/nuevoTramite/FormularioBuilder.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/nuevoTramite/JSONGeneraReferencia.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/nuevoTramite/JSONGeneraReferenciaBuilder.js') }}"></script>


<script type="text/javascript" src="{{ asset('js/nuevoTramite/shoppingCarModule/shoppingCarBuilder.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/nuevoTramite/tramiteModulo/templateMetodoPagoBuilder.js') }}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script><divid="conteudo">
<script type="text/javascript">
	let tramites = [];

	let tramitesGuardar = [];

	$(document).ready(() => {
    	getTramites();

		JSONGeneraReferenciaBuilder.setToken("9E1345508F2EBF30BD4D227D7E625111CFA6")
									.setUrlRetorno("http://10.153.144.94/egobDes/CNAPRetorno.php")
									.setImporteTransaccion(500)
									.setIdTransaccion("201910")
									.setEntidad("3")
									.setUrlConfirmaPago("http://10.153.144.94/egobDes/CNAConfirma.php");

    	
    });

    function openModalAdd(){
    	$("#tramitesSelect").val("limpia").trigger('change');
    	$("#camposDinamicosDiv").empty();
    	$("#addTramite").modal({show: true}); 
    }

	function getTramites(){
		let url = "{{ url('/allTramites') }}";
		getApi( url,false , ((response) => {  
        	tramites = JSON.parse(response);
        	setTramites( $("#tramitesSelect") );
        }), (( msg ) => {
         	Command: toastr.warning("No Success", "Notifications") ;
        }) ,  () => $("#spin-animate").hide())
	}

	function getApi( url, data , fnDone, fnFail, fnAlways ){
		let obkTokn =  {_token:'{{ csrf_token() }}'};
		if( data ){
			obkTokn = Object.assign(obkTokn, data)
		}
        $.ajax({method: "get", url,data:obkTokn }).done(fnDone).fail(fnFail).always(fnAlways);
	}

	function setTramites(element){
    	tramites.forEach(tramite => addOptionToSelect( element, tramite.tramite, tramite.id_tramite ));
	}

	function addOptionToSelect( element, name, key ){
		element.append( new Option(name , key) );
	}


	$("#tramitesSelect").on(  "change" , () =>{
		$("#loadin").fadeIn();
		$("#tramitesSelect").attr("disabled", true);
		$("#camposDinamicosDiv").empty();
		getCampos();
	});

	function getCampos(){
		$("#btnAdd").attr("disabled", true);
		let url = "{{ url('/getCampos') }}";
		let data =  { id_tramite:$("#tramitesSelect").val()  } 
		getApi( url, data , ((response) => {  
        	buildForm( response );
        }), (( msg ) => {
         	Command: toastr.warning("No Success", "Notifications") ;
        }) ,  () => { 
        	$("#loadin").hide();
        	$("#tramitesSelect").attr("disabled", false);
        });
	}

	function buildForm( campos ){
		let arrToDOm = FormularioBuilder.build( campos );
		$("#camposDinamicosDiv").hide().empty().append( arrToDOm ).fadeIn(100);  
		$("#btnAdd").attr("disabled", false);                                             
	}

	$("#btnAdd").on("click", () => {
		validarForm( FormularioBuilder.getElements(), $("#tramitesSelect").val() );
	});

	function validarForm( campos, id_tramite ){
		let isValid = true;		
		let tramite = FormularioBuilder.isValid( campos );

		for (var campo in tramite) { 
			if( !tramite[campo].isValid) {
				isValid = false;
				Command: toastr.warning(campo.split("_").join(" ") + " es requerido", "Notifications") ;
				break;
			} 
		}

		if( isValid ) {
			let nuevoTramite = { id_tramite };
			for (var campo in tramite) { 
				nuevoTramite[campo] = tramite[campo].valor;
			}
			tramitesGuardar.push( nuevoTramite );
			Command: toastr.success("Se agrego el trámite a su lista", "Notifications") ;
			$("#camposDinamicosDiv").fadeOut(60).empty();
			$("#tramitesSelect").val("limpia").trigger('change');

			$("#addTramite").modal("hide"); 
			buildTablaDetalles();
		}
	}

	function buildTablaDetalles(){
		ShoppingCarBuilder.build( tramitesGuardar );
	}

	function deleteTramite( tramite ){
		$("#modalDelete").modal({show: true}); 
		$( "#modalDelete" ).data( "tramite", tramite );
	}

	function eliminar(){
		let tramiteDel = $( "#modalDelete" ).data( "tramite");
		tramitesGuardar =  tramitesGuardar.filter( tramite => tramite.id_tramite != tramiteDel.id_tramite );
		$("#modalDelete").modal('hide');
		buildTablaDetalles();
	}


	function metodoPago(){
		$("#metodoPagoBtn").attr("disabled", true);
		$("#addTramiteBTN").slideUp();

		$("#metodoPagoBtn").append('<div id="spinner-pago" class="spinner-border spinner-border-sm float-right" role="status"><span class="sr-only">Loading...</span></div>');
		
		console.log( JSON.stringify(JSONGeneraReferenciaBuilder.build()) );
		let url = "https://payments-api-stage.herokuapp.com/v1/pay";
		$.ajax({
		  	type: "POST",
		  	url,
		  	data: JSON.stringify(JSONGeneraReferenciaBuilder.build()),
		  	dataType:"json",
		   	headers: {
		        "Authorization":"Bearer B6C8XvbNouJj!ds@.NXjfeswtzehVN",
		        "Content-type":"application/json"
		    }
		}).done((response) => {
			
			let folio = response.response.folio;

			let cuentas = response.response.cuentas;
			if(cuentas.length > 0 ){
				templateMetodoPagoBulder.build(cuentas, folio);

				$(".btn-metodopago").on("click", (e) => {
					console.log(e.currentTarget.id)
					$("#" + e.currentTarget.id)
				});

				$("#metodoPagoBtn").attr("disabled", false).slideUp( "slow", () => {
					$("#listTramites").slideUp("slow", ()=> {
						$("#divMetodoPago").slideDown( "slow");
						$("#metodoPagoCancBtn").slideDown("slow");
					});
					
				});
			}
			
		}).fail((rror)=> {
			console.log( rror)
		}).always(() => {
			$("#spinner-pago").remove();
		});
	}

	function cancelarPago(){
		$("#divMetodoPago").slideUp("slow", () => {
			$("#metodoPagoBtn").slideDown( "slow");
			$("#addTramiteBTN").slideDown( "slow");	
			$("#listTramites").slideDown("slow");	

			$("#metodoPagoCancBtn").hide("slow");	
		});	

	}

</script>

							        		

							       