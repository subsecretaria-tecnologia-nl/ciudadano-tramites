<div class="content d-flex flex-column flex-column-fluid" id="app">
    <div class="d-flex flex-column-fluid">
        <div class="container">              
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent">
                    <li class="breadcrumb-item"><a href="{{ url()->route("home") }}">Home</a></li>
                    <li class="breadcrumb-item">Trámites</li>
                    <li class="breadcrumb-item active" aria-current="page" id="tramite-name">{{ strtoupper(str_replace("-", " ", $type)) }}</li>
                </ol>
            </nav>
            <div  style="min-height: 600px;" class="content d-flex flex-column flex-column-fluid pt-0">
                <div>
                    <section id="listaTramites" >
                        <listado-tramites :notary="{{session()->get("user")->notary->id}}" :type="{{ $id }}"></listado-tramites>
                    </section>
                </div>
            </div>
        </div>
        
    </div>
</div>
