<?php
    $user = session()->get("user");
    $id = $user->id;
?>
<div class="content d-flex flex-column flex-column-fluid" id="app">
    <div class="d-flex flex-column-fluid">
        <div class="container">                
            <div>
                <span > inicio-> Trámites en curso -> Selección de Trámite</span>
            </div>
            <div class="" style="padding-top: 10px; min-height: 600px;">
                <div class="">
                    <div class="dropdown-divider"></div>
                    <car-shop-component id-usuario="{{ $id }}"></car-shop-component>
                </div>
            </div>
        </div>
        
    </div>
</div> 
