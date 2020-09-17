<div class="content d-flex flex-column flex-column-fluid contenido " id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">

            <div class="tramites">
                <div class="cuadros-cont">
                    <div>
                        <span > inicio->Tramites en curso->Selección de Trámite</span>
                    </div>
                    <div class="cuadro-listado tramite-lista" style="padding-top: 10px">
                        <div class="titulo-cuadro">
                            <div style="padding-top: 20px;">
                                <span class="tituloTabla">
                                    Selección de Trámite
                                </span>
                            </div>
                            <div class="dropdown-divider"></div>
               
							<section id="tabs" class="project-tab">
							    <div class="container">
							        <div class="row">
							            <div class="col-md-12">
							                <nav>
							                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
							                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
								                       	1._Selección de Trámite
								                    </a>
							                        <a class="nav-item nav-link" id="nav-detalle-tab" data-toggle="tab" href="#nav-detalle" role="tab" aria-controls="nav-detalle" aria-selected="false" onclick="buildTablaDetalles()">
							                        	2._Detalle
							                        </a>
							                        <a class="nav-item nav-link" id="nav-comprobante-tab" data-toggle="tab" href="#nav-comprobante" role="tab" aria-controls="nav-comprobante" aria-selected="false">
							                        	3.Comprobante
							                        </a>
							                    </div>
							                </nav>
							                <div class="tab-content" id="nav-tabContent">
							                    <div class="tab-pane fade show active mx-auto" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="width: 70%;">

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

													    <div class="text-center  ">
														    <button class="btn btn-info"  type="button" onclick="next('#nav-detalle-tab')">
							                        			Siguiente
							                        		</button>
													    </div>

													</form>
							                    </div>
							                    <div class="tab-pane fade" id="nav-detalle" role="tabpanel" aria-labelledby="nav-detalle-tab">


													<div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top: 10px;">
													     <div class="card">
													         <div class="card-body">
													             <div class="table-responsive-sm">
													                 <table class="table table-striped" id="tableDetails">
													                     <thead>
													                         <tr>
													                         	<th></th>
													                            <th class="center">#</th>
													                            <th>Nombre</th>
													                            <th>Descripción</th>
													                            <th class="right">Total</th>

													                         </tr>
													                     </thead>
													                 </table>
													             </div>
													             <div class="row">
													                 <div class="col-lg-4 col-sm-5">
													                 </div>
													                 <div class="col-lg-4 col-sm-5 ml-auto">
													                     <table class="table table-clear">
													                         <tbody>
													                             <tr>
													                                 <td class="left">
													                                     <strong class="text-dark">Total</strong> </td>
													                                 <td class="right">
													                                     <strong class="text-dark">$20,744,00</strong>
													                                 </td>
													                             </tr>
													                         </tbody>
													                     </table>
													                 </div>
													             </div>
													         </div>
													     </div>
													 </div>

												    <div class="text-center  ">
													    <button class="btn btn-info"  type="button" onclick="next('#nav-comprobante-tab')">
						                        			Siguiente
						                        		</button>
												    </div>
							                    </div>
							                    <div class="tab-pane fade" id="nav-comprobante" role="tabpanel" aria-labelledby="nav-comprobante-tab">
							                    		Comprbant
							                    </div>
							                </div>
							            </div>
							        </div>
							    </div>
							</section>


                        </div>
                    </div>
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

<link href="{{ asset('css/newTramite.css') }}" rel="stylesheet" type="text/css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/nuevoTramite/inputClass.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/nuevoTramite/selectClass.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/nuevoTramite/checkboxClass.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/nuevoTramite/ElementFactory.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/nuevoTramite/FormularioBuilder.js') }}"></script>

<script type="text/javascript">
	let tramites = [];

	let tramitesGuardar = [];

	$(document).ready(() => {
    	getTramites();
    });

	function getTramites(){
		let url = "{{ url('/allTramites') }}";
		getApi( url,false , ((response) => {  
        	tramites = JSON.parse(response);
        	console.log(tramites )
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
		let url = "{{ url('/getCampos') }}";
		let data =  { id_tramite:$("#tramitesSelect").val()  } 
		getApi( url, data , ((response) => {  
        	buildForm( response, data.id_tramite );
        }), (( msg ) => {
         	Command: toastr.warning("No Success", "Notifications") ;
        }) ,  () => { 
        	$("#loadin").hide();
        	$("#tramitesSelect").attr("disabled", false);
        });
	}

	function buildForm( campos, id_tramite ){
		let arrToDOm = FormularioBuilder.build( campos, validarForm, id_tramite );
		$("#camposDinamicosDiv").hide().empty().append( arrToDOm ).fadeIn(100);                                               
	}

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
		}
	}

	function buildTablaDetalles(){
		var table = $('#tableDetails').DataTable();
                table.destroy(); 

		let datosTabla = [];
		let contador = 0;
		tramitesGuardar.forEach( (tramiteLista) =>{
			let tramiteSeleccionado =  tramites.find( tramite => tramite.id_tramite == tramiteLista.id_tramite );
			tramiteSeleccionado.costo = 0;
			tramiteSeleccionado.num = contador + 1;
			datosTabla.push( tramiteSeleccionado );
		});
		
		$("#tableDetails").DataTable( {
			"paging": false,
			"searching": false,
			"info":     false,
			"language": {
				"zeroRecords" : "No hay trámites agregados",
			},
	        data: datosTabla,
	        columns: [	           
	        	{ title: "", data:"id_tramite", render: getTemplateAcciones },
	        	{ title: "#" , "data":"num"},
	            { title: "Nombre", data:"tramite" },
	            { title: "Descripción", data:"tramite" },
	            { title: "Precio", data:"costo" },
	        ]
	    });
	}

	function getTemplateAcciones( data, type, row, meta  ){
	    let botonEliminar = "<a type='button' onclick='deleteTramite(" +  JSON.stringify( row ) +")' ><i class='far fa-trash-alt'></i></a>";
	    return botonEliminar; 
	}

	function deleteTramite( tramite ){
		$("#modalDelete").modal({show: true}); 
		$( "#modalDelete" ).data( "tramite", tramite );
	}

	function eliminar(){
		let tramiteDel = $( "#modalDelete" ).data( "tramite");
		tramitesGuardar =  tramitesGuardar.filter( tramite => tramite.id_tramite != tramiteDel.id_tramite );
		var myTable = $('#tableDetails').DataTable();
		myTable.clear().rows.add(tramitesGuardar).draw();
		$("#modalDelete").modal('hide');
	}

	function next(idNext){
		$(idNext).click();
	}
</script>