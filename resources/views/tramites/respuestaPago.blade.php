<div class="content d-flex flex-column flex-column-fluid" id="app">
    <div class="d-flex flex-column-fluid">
	    <div class="container">              
            <div>
                <span > inicio->Tramites en curso-> Pago </span>
            </div>
            <div  style="padding-top: 10px; min-height: 600px;" class="content d-flex flex-column flex-column-fluid">
                <div>
                    <div class="dropdown-divider"></div>
                    <section id="invoicePanel" >
						<div class="container">
  							<div class="card">
								<div class="card-header">
									Estado
									<strong>
										{{$respuestabanco['response']['datos']['mensaje']}}
									</strong> 
  									<span class="float-right"> 
  										<strong>Total:</strong> 
  										{{$respuestabanco['response']['datos']['importe_transaccion']}}
  									</span>

								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-lg-12 col-sm-12">
											<div class="container">
									        	<iframe class="responsive-iframe" src="{{$respuestabanco['response']['datos']['url_recibo']}}" frameborder="0"  width="100%" height="600px"></iframe>
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
