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
                                                    $infoDraf = json_decode($item->info);
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
                                                            <strong>{{ $item->clave }}</strong>{{ isset($infoDraf->solicitante) ? ($infoDraf->solicitante->tipoPersona == 'pf' ? "- {$infoDraf->solicitante->nombreSolicitante} {$infoDraf->solicitante->apPat} {$infoDraf->solicitante->apMat}" : $infoDraf->solicitante->razonSocial) : "" }}
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
                                                            <strong>{{ $item->clave }}</strong>{{ isset($infoPP->solicitante) ? ($infoPP->solicitante->tipoPersona == 'pf' ? "- {$infoPP->solicitante->nombreSolicitante} {$infoPP->solicitante->apPat} {$infoPP->solicitante->apMat}" : $infoPP->solicitante->razonSocial) : "" }}
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
                                                            <strong>{{ $item->clave }}</strong>{{ isset($infoWait->solicitante) ? ($infoWait->solicitante->tipoPersona == 'pf' ? "- {$infoWait->solicitante->nombreSolicitante} {$infoWait->solicitante->apPat} {$infoWait->solicitante->apMat}" : $infoWait->solicitante->razonSocial) : "" }}
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
                                                            <strong>{{ $item->clave }}</strong>{{ isset($infoProgress->solicitante) ? ($infoProgress->solicitante->tipoPersona == 'pf' ? "- {$infoProgress->solicitante->nombreSolicitante} {$infoProgress->solicitante->apPat} {$infoProgress->solicitante->apMat}" : $infoProgress->solicitante->razonSocial) : "" }}
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