<div class="content d-flex flex-column flex-column-fluid" id="app">
    <div class="d-flex flex-column-fluid">
	    <div class="container">              
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent">
                    <li class="breadcrumb-item"><a href="{{ url()->route("home") }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page" id="tramite-name">NUEVO TRÁMITE</li>
                </ol>
            </nav>
            <div  style="min-height: 600px;" class="content d-flex flex-column flex-column-fluid pt-0">
                <div>
                    <section id="listaTramites" >
						<listado-tramites-component></listado-tramites-component>
					</section>

                </div>
            </div>
        </div>
        
    </div>
</div>
