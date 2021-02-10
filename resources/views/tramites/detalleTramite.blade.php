<?php
    $user = session()->get("user");
    $id = $user->id;
?>
<div class="content d-flex flex-column flex-column-fluid" id="app">
    <div class="d-flex flex-column-fluid">
        <div class="container">              
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent">
                    <li class="breadcrumb-item"><a href="{{ url()->route("home") }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url()->route("tramite.nuevo") }}">Trámites</a></li>
                    <li class="breadcrumb-item active" aria-current="page" id="tramite-name">TRÁMITE: <span class="ml-2"><i class="fas fa-circle-notch fa-spin text-black"></i></span></li>
                </ol>
            </nav>
            <div style="min-height: 600px;" class="content d-flex flex-column flex-column-fluid pt-0">
                <div>
                    <section id="detalleTrammite">
                      @php
                        $jsonTramite = json_encode($detalle[0]);
                      @endphp
                      <wizard-component :tramite="{{$jsonTramite}}" id-usuario="{{ $id }}" clave="{{$clave}}"></wizard-component>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div> 