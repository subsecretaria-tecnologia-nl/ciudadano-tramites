
<div class="content d-flex flex-column flex-column-fluid" id="app">
    <div class="d-flex flex-column-fluid">
	    <div class="container">              
            <div>
                <span> inicio->Tramites en curso-> Pago </span>
            </div>
            <div  style="padding-top: 10px; min-height: 600px;" class="content d-flex flex-column flex-column-fluid">
                <div>
                    <div class="dropdown-divider"></div>
                    <section id="invoicePanel" >
						<div class="container">
  							<div class="card">
								<div class="card-header">
                                    TRAMITES POR FIRMAR:
								</div>

								<div class="card-body">
                                {{ $idTramites }}
									<div class="row" >
										<div class="col-lg-12 col-sm-12">
											<div class="container">
                                            <div class="pt-10 pl-10 pr-10">
                                                    <firma-electronica-component :usuario="{{$idTramites}}"  :id="{{$id}}"  :user="{{$user}}" ></firma-electronica-component>
                                                </div>
									    	</div> 
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
