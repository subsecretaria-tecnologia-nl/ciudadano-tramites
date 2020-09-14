
<div id="buscador" class="">
    <div class="busqueda">
            
    </div>
    <div class="gradient">
            <div class="form-group">
                <div class="padding-busqueda">
                    <span class="busqueda-titulo">Busca tus trámites</span>
                </div>
                <span  class="busqueda-sub">Puedes buscar por nombre de trámite, número de folio, nombre de solicitante, etc.</span>
                <div class="padding-busqueda">
                    <input class="form-control  form-control-lg" type="text" name="busqueda" id="busqueda"  placeholder="Ejemplo: Certificado de gravamen">
                </div>
            </div>
    </div>
</div>

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
							                        <a class="nav-item nav-link" id="nav-formulario-tab" data-toggle="tab" href="#nav-formulario" role="tab" aria-controls="nav-formulario" aria-selected="false">
							                        	2._ Formulario
							                        </a>
							                        <a class="nav-item nav-link" id="nav-detalle-tab" data-toggle="tab" href="#nav-detalle" role="tab" aria-controls="nav-detalle" aria-selected="false">
							                        	3._Detalle
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
													    <!-- Next button -->
														    <button class="btn btn-info" type="submit"> 
														    	Siguiente
														    </button>
													    </div>

													</form>
							                    </div>
							                    <div class="tab-pane fade" id="nav-formulario" role="tabpanel" aria-labelledby="nav-formulario-tab">
							                        Formulario
							                    </div>
							                    <div class="tab-pane fade" id="nav-detalle" role="tabpanel" aria-labelledby="nav-detalle-tab">
							                    		Detalles
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
<link href="{{ asset('css/newTramite.css') }}" rel="stylesheet" type="text/css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/nuevoTramite/inputClass.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/nuevoTramite/selectClass.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/nuevoTramite/checkboxClass.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/nuevoTramite/ElementFactory.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/nuevoTramite/FormularioBuilder.js') }}"></script>

<script type="text/javascript">
	let tramites = [];

	$(document).ready(() => {
    	getTramites();
    });

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
	}
</script>