<div class="content d-flex flex-column flex-column-fluid" id="app">
    <div class="d-flex flex-column-fluid">
        <div class="container">              
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent">
                    <li class="breadcrumb-item"><a href="{{ url()->route("home") }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url()->route("tramite.nuevo") }}">Trámites</a></li>
                    <li class="breadcrumb-item active" aria-current="page" id="tramite-name">{{ $tramite->titulo }}</li>
                </ol>
            </nav>
            <div style="min-height: 600px;" class="content d-flex flex-column flex-column-fluid pt-0">
                <div class="card">
                	<div class="card-body">
                		<div class="row align-items-center">
                			<div class="col">
		                		<h3 class="m-0">{{ $tramite->titulo }}</h3>
		                		<p class="text-muted m-0">{{ $tramite->clave }}</p>
                			</div>
                			<div class="col text-right">
                				<p class="m-0">{{ strftime("%A %d, %Y %I:%M %p", strtotime($tramite->created_at)) }}</p>
                			</div>
                		</div>
                	</div>
                </div>
                <div class="card mt-5">
                	<div class="card-header">Información</div>
                	<div class="card-body">
                		<div class="row">
                			<?php
                				foreach($tramite->info->campos as $campo => $value){
                					while(gettype($value) != "string"){ $value = $value[0]; }
                					echo "
                						<div class=\"col-md-6\">
                							<span class=\"text-muted\">$campo</span>
                							<p><strong>$value</strong></p>
                						</div>
                					";
                				}
                			?>
                		</div>
                	</div>
                </div>
                <div class="card mt-5">
                	<div class="card-header">Mensajes</div>
                	<div class="card-body">
                		<?php
                			foreach($tramite->mensajes as $ind => $msg){
                				$format = [];
                				$updated = new DateTime($msg->updated_at);
                				$current = new DateTime();
								$interval = $updated->diff($current);
								if($interval->format('%d') > 0)
									array_push($format, $interval->format('%d') . " días");
								array_push($format, $interval->format('%h') . " hrs");
								array_push($format, $interval->format('%i') . " mins");
                				echo "
                					<div class=\"mensage ".($ind == 0 ? "pb-0 pt-4" : "py-4 border-bottom ").($ind == (count($tramite->mensajes)-1) ? "pt-0 pb-4" : "py-4")." px-1\">
                						<div class=\"row\">
                							<div class=\"col-md-10\">
		                						<p class=\"card-text mb-0\">{$msg->mensaje}</p>
		                						<p class=\"card-text mt-2\"><small class=\"text-muted\">Ultima actualización hace ".implode(" ", $format)."</small></p>
                							</div>
                							<div class=\"col-md-2 text-right ".(empty($msg->attach) ? "d-none" : "")."\">
                								<a href=\"".(!empty($msg->attach) ? getenv("TESORERIA_HOSTNAME")."/storage/app/{$msg->attach}" : "")."\" class=\"btn btn-secondary\" target=\"_blank\"><i class=\"fas fa-download\"></i> Ver Archivo</a>
                							</div>
                						</div>
                					</div>
                				";
                			}
                		?>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div> 