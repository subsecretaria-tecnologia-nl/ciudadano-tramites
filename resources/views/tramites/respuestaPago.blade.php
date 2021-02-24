<?php
    $user = session()->get("user");
?>
<div class="content d-flex flex-column flex-column-fluid" id="app">
    <div class="d-flex flex-column-fluid">
	    <div class="container">              
            <div>
                <san > inicio->Tramites en curso-> Pago </span>
                <san >{{  json_encode( $respuestabanco)  }} </span>
                <san >{{  json_encode( $user)  }} </span>
            </div>
            <div  style="padding-top: 10px; min-height: 600px;" class="content d-flex flex-column flex-column-fluid">
                <div>
                    <div class="dropdown-divider"></div>
                    <section id="invoicePanel" >
						<div class="container">
  							<div class="card">
								<div class="card-header">
									Estado:
									<strong>
										{{ $respuestabanco['response']['datos']['mensaje'] }}
										@if(isset($user->email))
										<a href="mailto:{{$user->email}}?subject=Recibo de pago&body={{$respuestabanco['response']['datos']['url_recibo']}}">
											Enviar por correo <i class="fa fa-envelope-open-text"></i>
										</a>
										@endif
									</strong>
									@if($respuestabanco['response']['datos']['mensaje'] == 'Aprobada')
	  									<span class="float-right"> 
	  										<strong>Total:</strong> 
	  										{{$respuestabanco['response']['datos']['importe_transaccion']}}
	  									</span>
									@endif
								</div>

							
								<div class="card-body">
									<div class="row" >
										<div class="col-lg-12 col-sm-12">
											<div class="container">
												@if($respuestabanco['response']['datos']['mensaje'] == 'Aprobada')
									        		<iframe class="responsive-iframe" src="{{$respuestabanco['response']['datos']['url_recibo']}}" frameborder="0"  width="100%" height="600px"></iframe>
												@else
										           	<div class="text-center">
										           		<h1>  Lo sentimos, No se ha podido procesar el pago</h1>
										           		<hr>
										           		<a class="btn btn-danger" href="{{ url()->route('tramite.cart') }}" >
										           			Ir al carrito
										           		</a>
										           	</div>
										         
										        @endif
									    	</div> 
										</div>
									</div>
								</div>
								<div class="pt-10 pl-10 pr-10">
                                	<firma-electronica-component  :usuario="{{  json_encode( $respuestabanco['response']['datos']['tramites'][0]['id_tramite'])  }}"  ></firma-electronica-component>
                                </div>
							</div>
						</div>
					</section>

                </div>
            </div>
        </div>
        
    </div>
</div>
