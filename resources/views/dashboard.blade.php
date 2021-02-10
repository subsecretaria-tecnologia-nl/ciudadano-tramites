<div class="content ">
    <div class="d-flex flex-column-fluid">
        <div class="container dashboard pt-0">
            <div class="row">
                    <!--[if IE]>
                    <div class="error"><span>ESTAS EN INTERNET EXPLORER</span></div>
                    ![endif]-->

                <div class="col-lg-6" style="margin-bottom: 30px;"> 
                    <div class="card" >
                          <div class="card-body">
                                <h5 class="card-title">
                                    <div style="padding-left: 1%">
                                        <span class="titulo">Borradores</span>
                                    </div>
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>
                                            @foreach ($draft as $item)
                                                @php
                                                    $infoDraft = json_decode($item->info);
                                                @endphp
                                                <tr>
                                                    <td class="mobile-id" style="vertical-align: middle">
                                                        <div class="text-center">
                                                            <span class="identificador">
                                                                {{$item->id}}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td colspan="3">
                                                        <span class="nombre-tramite">
                                                            {{$item->titulo}}
                                                        </span>
                                                        <div class="nombre">
                                                            <strong>{{ $item->clave }}</strong>
                                                            @php
                                                                if(isset($infoDraft->solicitante)){
                                                                    if($infoDraft->solicitante->tipoPersona == 'pf'){
                                                                        $apMat = isset($infoDraft->solicitante->apMat) ? $infoDraft->solicitante->apMat : '';
                                                                        echo "- {$infoDraft->solicitante->nombreSolicitante} {$infoDraft->solicitante->apPat} {$apMat}";
                                                                    }else{
                                                                        echo "- {$infoDraft->solicitante->razonSocial}";
                                                                    }
                                                                }
                                                            @endphp
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <a href="{{ url()->route("tramites", [ "borradores", "80" ]) }}" type="button" class="btn btn-vermas">VER MÁS</a>
                                </div>
                          </div>
                    </div>
                </div>
                <div class="col-lg-6" style="margin-bottom: 30px;"> 
                    <div class="card" >
                          <div class="card-body">
                                <h5 class="card-title">
                                    <div style="padding-left: 1%">
                                        <span class="titulo">Pendientes de Pago</span>
                                    </div>
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>
                                            @foreach ($pendingPayment as $item)
                                                @php
                                                    $infoPP = json_decode($item->info);
                                                @endphp
                                                <tr>
                                                    <td class="mobile-id" style="vertical-align: middle">
                                                        <div class="text-center">
                                                            <span class="identificador">
                                                                {{$item->id}}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td colspan="3">
                                                        <span class="nombre-tramite">
                                                            {{$item->titulo}}
                                                        </span>
                                                        <div class="nombre">
                                                            <strong>{{ $item->clave }}</strong>
                                                            @php
                                                                if(isset($infoPP->solicitante)){
                                                                    if($infoPP->solicitante->tipoPersona == 'pf'){
                                                                        $apMat = isset($infoPP->solicitante->apMat) ? $infoPP->solicitante->apMat : '';
                                                                        echo "- {$infoPP->solicitante->nombreSolicitante} {$infoPP->solicitante->apPat} {$apMat}";
                                                                    }else{
                                                                        echo "- {$infoPP->solicitante->razonSocial}";
                                                                    }
                                                                }
                                                            @endphp
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <a href="{{ url()->route("tramites", [ "pendientes-de-pago", "99" ]) }}" type="button" class="btn btn-vermas">VER MÁS</a>
                                </div>
                          </div>
                    </div>
                </div>
                <div class="col-lg-6" style="margin-bottom: 30px;"> 
                    <div class="card" >
                          <div class="card-body">
                                <h5 class="card-title">
                                    <div style="padding-left: 1%">
                                        <span class="titulo">En Espera de Atención</span>
                                    </div>
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>
                                            @foreach ($waiting as $item)
                                                @php
                                                    $infoWait = json_decode($item->info);
                                                @endphp
                                                <tr>
                                                    <td class="mobile-id" style="vertical-align: middle">
                                                        <div class="text-center">
                                                            <span class="identificador">
                                                                {{$item->id}}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td colspan="3">
                                                        <span class="nombre-tramite">
                                                            {{$item->titulo}}
                                                        </span>
                                                        <div class="nombre">
                                                            <strong>{{ $item->clave }}</strong>
                                                            @php
                                                                if(isset($infoWait->solicitante)){
                                                                    if($infoWait->solicitante->tipoPersona == 'pf'){
                                                                        $apMat = isset($infoWait->solicitante->apMat) ? $infoWait->solicitante->apMat : '';
                                                                        echo "- {$infoWait->solicitante->nombreSolicitante} {$infoWait->solicitante->apPat} {$apMat}";
                                                                    }else{
                                                                        echo "- {$infoWait->solicitante->razonSocial}";
                                                                    }
                                                                }
                                                            @endphp
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <a href="{{ url()->route("tramites", [ "en-espera-de-atención", "3" ]) }}" type="button" class="btn btn-vermas">VER MÁS</a>
                                </div>
                          </div>
                    </div>
                </div>
                <div class="col-lg-6" style="margin-bottom: 30px;"> 
                    <div class="card" >
                          <div class="card-body">
                                <h5 class="card-title">
                                    <div style="padding-left: 1%">
                                        <span class="titulo">En Curso</span>
                                    </div>
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>
                                            @foreach ($progress as $item)
                                                @php
                                                    $infoProgress = json_decode($item->info);
                                                @endphp
                                                <tr>
                                                    <td class="mobile-id" style="vertical-align: middle">
                                                        <div class="text-center">
                                                            <span class="identificador">
                                                                {{$item->id}}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td colspan="3">
                                                        <span class="nombre-tramite">
                                                            {{$item->titulo}}
                                                        </span>
                                                        <div class="nombre">
                                                            <strong>{{ $item->clave }}</strong>
                                                            @php
                                                                if(isset($infoProgress->solicitante)){
                                                                    if($infoProgress->solicitante->tipoPersona == 'pf'){
                                                                        $apMat = isset($infoProgress->solicitante->apMat) ? $infoProgress->solicitante->apMat : '';
                                                                        echo "- {$infoProgress->solicitante->nombreSolicitante} {$infoProgress->solicitante->apPat} {$apMat}";
                                                                    }else{
                                                                        echo "- {$infoProgress->solicitante->razonSocial}";
                                                                    }
                                                                }
                                                            @endphp
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <a href="{{ url()->route("tramites", [ "en-curso", "1" ]) }}" type="button" class="btn btn-vermas">VER MÁS</a>
                                </div>
                          </div>
                    </div>
                </div>
            </div>

        </div>        
    </div>
</div> 