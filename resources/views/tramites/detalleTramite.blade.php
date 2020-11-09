<?php
    $user = session()->get("user");
    $id = $user->id;
?>
<div class="content d-flex flex-column flex-column-fluid" id="app">
    <div class="d-flex flex-column-fluid">
        <div class="container">              
            <div>
                <span > inicio->Tramites en curso-> Detalle Trámite</span>
            </div>
            <div  style="padding-top: 10px; min-height: 600px;" class="content d-flex flex-column flex-column-fluid">
                <div>
                    <div class="dropdown-divider"></div>
                    <section id="detalleTrammite">
                      @php
                        $jsonTramite = json_encode($detalle[0]);
                      @endphp
                      <wizard-component :tramite="{{$jsonTramite}}" id-usuario="{{ $id }}"></wizard-component>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div> 