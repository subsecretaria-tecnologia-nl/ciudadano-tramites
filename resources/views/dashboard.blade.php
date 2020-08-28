@extends('metronic_front.app')

@section('dashboard')
<div class="gradient">
        <br>
        <div class="form-group">
            <div>
                <span class="busqueda-titulo">Busca tus trámites</span>
            </div>
            <span  class="busqueda-sub">Puedes buscar por nombre de trámite, número de folio, nombre de solicitante, etc.</span>
            <div>
                <br>
                <input class="form-control  form-control-lg" style="height: 50px;" type="text" name="busqueda" id="busqueda"  placeholder="Ejemplo: Certificado de gravamen">
            </div>
        </div>
</div>
<div class="busqueda">
        
</div>
@endsection


@section('tramites')
<div class="container">
    <div class="tramites">
        <div class="cuadros-cont">
            <div class="cuadro tramite-lista">
                <div class="titulo-cuadro">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th colspan="4"> 
                                    <div style="padding-left: 1%">
                                        <span class="titulo">Trámites pendientes</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Certificado de libertad de gravamen
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite" style="padding-right: 10%">
                                        M-5 Constitucion/modificacion de sociedad microindustrial
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Disolucion de copropiedad y aplicacion de bienes 
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Promesa Compra venta
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Promesa Compra venta
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <div class="text-center">
                        <button type="button" class="btn btn-vermas ">VER MÁS</button>
                    </div>

                </div>
            </div>
            <div class="cuadro tramite-lista">
                <div class="titulo-cuadro">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th colspan="4"> 
                                    <div style="padding-left: 1%">
                                        <span class="titulo">Trámites pendientes</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Certificado de libertad de gravamen
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite" style="padding-right: 10%">
                                        M-5 Constitucion/modificacion de sociedad microindustrial
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Disolucion de copropiedad y aplicacion de bienes 
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Promesa Compra venta
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Promesa Compra venta
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <div class="text-center">
                        <button type="button" class="btn btn-vermas ">VER MÁS</button>
                    </div>

                </div>
            </div>
            <div class="cuadro tramite-lista">
                <div class="titulo-cuadro">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th colspan="4"> 
                                    <div style="padding-left: 1%">
                                        <span class="titulo">Trámites pendientes</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Certificado de libertad de gravamen
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite" style="padding-right: 10%">
                                        M-5 Constitucion/modificacion de sociedad microindustrial
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Disolucion de copropiedad y aplicacion de bienes 
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Promesa Compra venta
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Promesa Compra venta
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <div class="text-center">
                        <button type="button" class="btn btn-vermas ">VER MÁS</button>
                    </div>

                </div>
            </div>
            <div class="cuadro tramite-lista">
                <div class="titulo-cuadro">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th colspan="4"> 
                                    <div style="padding-left: 1%">
                                        <span class="titulo">Trámites pendientes</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Certificado de libertad de gravamen
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite" style="padding-right: 10%">
                                        M-5 Constitucion/modificacion de sociedad microindustrial
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Disolucion de copropiedad y aplicacion de bienes 
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Promesa Compra venta
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle">
                                    <div class="text-center">
                                        <span class="identificador">
                                            14200034   
                                        </span>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <span class="nombre-tramite">
                                        Promesa Compra venta
                                    </span>
                                    <div class="nombre">
                                        jaime castillo
                                    </div>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <div class="text-center">
                        <button type="button" class="btn btn-vermas"  >VER MÁS</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" /> --}}
<style type="text/css">
    @font-face {
    font-family: 'Montserrat-Black';
    src: url('{{ resource_path('font/Montserrat-Black.ttf') }}');
    }

</style>