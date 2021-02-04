<?php
    $user = session()->get("user");
    $id = $user->id;
?>
<div class="content d-flex flex-column flex-column-fluid" id="app">
    <div class="d-flex flex-column-fluid">
        <div class="container">              

            <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
                <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center flex-wrap mr-1">
                        <!--begin::Page Heading-->
                        <div class="d-flex align-items-baseline flex-wrap mr-5">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb bg-transparent">
                                    <li class="breadcrumb-item"><a href="{{ url()->route("home") }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url()->route("tramite.nuevo") }}">Trámites</a></li>
                                    <li class="breadcrumb-item active" aria-current="page" id="tramite-name">TRÁMITE: <span class="ml-2"><i class="fas fa-circle-notch fa-spin text-black"></i></span></li>
                                </ol>
                            </nav>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page Heading-->
                    </div>
                    <!--end::Info-->
                    <!--begin::Toolbar-->
                    <div class="d-flex align-items-center">

                        <!--begin::Dropdown-->
                        <div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Congiguración">
                            <a href="#" class="btn btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="svg-icon svg-icon-success svg-icon-2x">
                                    <!--begin::Svg Icon | path:/metronic/theme/html/demo7/dist/assets/media/svg/icons/Files/File-plus.svg-->
                                   <i class="flaticon2-gear"></i>
                                    <!--end::Svg Icon-->
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 m-0" style="">
                                <!--begin::Navigation-->
                                <ul class="navi navi-hover">
                                    <li class="navi-header font-weight-bold py-4">
                                        <span class="font-size-lg">Divisas</span>
                                        <i class="icon-md text-muted" data-toggle="tooltip" data-placement="right" title="" data-original-title="Elija divisa"></i>
                                    </li>
                                    <li class="navi-separator mb-3 opacity-70"></li>
                                    <li class="navi-item">
                                        <a href="#" class="navi-link">
                                            <span class="navi-text">
                                                <span class="label label-xl label-inline label-light-success">Customer</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="#" class="navi-link">
                                            <span class="navi-text">
                                                <span class="label label-xl label-inline label-light-danger">Partner</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                                <!--end::Navigation-->
                            </div>
                        </div>
                        <!--end::Dropdown-->
                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>
            <div style="min-height: 600px;" class="content d-flex flex-column flex-column-fluid pt-0">
                <div>
                    <section id="detalleTrammite">
                      @php
                        $jsonTramite = json_encode($detalle[0]);
                      @endphp
                      <wizard-component :tramite="{{$jsonTramite}}" id-usuario="{{ $id }}" clave="{{$clave}}" :notary="{{session()->get("user")->notary->id}}"></wizard-component>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div> 