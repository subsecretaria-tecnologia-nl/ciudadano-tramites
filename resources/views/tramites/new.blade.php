<div class="content d-flex flex-column flex-column-fluid" id="app">
    <div class="d-flex flex-column-fluid">
        <div class="container">                
            <div>
                <span > inicio->Tramites en curso->Selección de Trámite</span>
            </div>
            <div  style="padding-top: 10px; min-height: 600px;">
                <div>
                    <div class="dropdown-divider"></div>
                    <section id="listaTramites" >
					    <div class="container-fluid">
							<div class="row">
								<listado-tramites-component></listado-tramites-component>
							</div>
							<!-- Grid row -->
					    </div>
					</section>

                </div>
            </div>
        </div>
        
    </div>
</div> 

<link href="{{ asset('css/newTramite.css') }}" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
<script type="text/javascript">
	let url = "{{ url()->route('allTramites') }}";
</script>
