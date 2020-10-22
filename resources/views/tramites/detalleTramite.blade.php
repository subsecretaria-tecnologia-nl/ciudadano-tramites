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
                        <wizard-component :tramite="{
  'id_tramite': 101,
  'tramite': 'ADJUDICACIÃ?N POR HERENCIA',
  'partidas': [
    {
      'id_partida': 21017,
      'descripcion': 'ADJUDICACIÓN POR HERENCIA PAGO EN LÍNEA'
    }
  ]
}"></wizard-component>
                    </section>

                </div>
            </div>
        </div>
    </div>
</div> 
<script type="text/javascript">
    let urlObtnerCampos = "{{ url()->route('getCampos') }}";
</script>
