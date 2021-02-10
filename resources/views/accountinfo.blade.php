<div class="content iecontent" id="kt_content" style="min-width: -webkit-fill-available">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <span class="col-sm-12 col-md-3 sideNavBtn" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>

            <span class="col-sm-12 col-md-3">
                perfil->Informacion de la cuenta
            </span>
            <div id="Sidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">...</a>
                <div class="card" >
                    <div class="card-body">
                        {{-- img --}}
                      <div class="d-flex align-items-center mt-5" style="border-bottom:  1px solid #ECF0F3 !important;padding-bottom: 30px">
                          <div class="symbol symbol-100 mr-5">
                              {{-- <div class="symbol-label" style="background-image:url('media/users/300_21.jpg')"></div> --}}
                              <span class="symbol-label font-size-h2 font-weight-bold bg-dark-o-30">RS</span>
                              <i class="symbol-badge bg-success"></i>
                          </div>
                          <div class="d-flex flex-column">
                              <a href="{{ url()->route("perfil") }}" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">Raymundo Salazar</a>
                              <div class="text-muted mt-1">Frontend Development</div>
                              <div class="navi mt-2">
                                  <a href="mailto:alberto.salazars@nuevoleon.gob.mx" class="navi-item">
                                      <span class="navi-link p-0 pb-2">
                                          <span class="navi-icon mr-1">
                                              <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                  <!--begin::Svg Icon | path:media/svg/icons/Communication/Mail-notification.svg-->
                                                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                          <rect x="0" y="0" width="24" height="24" />
                                                          <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
                                                          <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
                                                      </g>
                                                  </svg>
                                                  <!--end::Svg Icon-->
                                              </span>
                                          </span>
                                          <span class="navi-text text-muted text-hover-primary text-truncate col-8 pl-0">alberto.salazars@nuevoleon.gob.mx</span>
                                      </span>
                                  </a>
                                  <a href="{{ url()->route("logout") }}" class="btn btn-sm btn-sidevar btn-info font-weight-bolder text-white  text-hover-white py-2 px-5">Chat</a>
                                  <a href="{{ url()->route("logout") }}" class="btn btn-sm btn-sidevar btn-primary font-weight-bolder  text-white text-hover-white py-2 px-5">Seguir</a>
                              </div>
                          </div>
                      </div>
                      {{-- datos --}}
                          <div class="table-responsive">
                              <table class="table table-borderless">
                                  <tbody>
                                      <tr>
                                          <td style="vertical-align: middle">
                                              <div>
                                                  <span>
                                                      Email   
                                                  </span>
                                              </div>
                                          </td>
                                          <td colspan="3">
                                              <span class="text-muted text-truncate col-8 pl-0">
                                                  {{ $user->email }}

                                              </span>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td style="vertical-align: middle">
                                              <div>
                                                  <span>
                                                      Phone   
                                                  </span>
                                              </div>
                                          </td>
                                          <td colspan="3">
                                              <span class="text-muted" style="padding-right: 10%">
                                                  {{  $user->phone }}
                                              </span>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td style="vertical-align: middle">
                                              <div >
                                                  <span>
                                                      Ubicacion   
                                                  </span>
                                              </div>
                                          </td>
                                          <td colspan="3">
                                              <span class="text-muted">
                                                 Lorem ipsum dolor sit amet consectetur 
                                              </span>
                                         
                                          </td>
                                      </tr>
                                      
                                  </tbody>
                              </table>
                              <a href="{{ url()->route("perfil") }}" type="button" class="btn btn-text-primary btn-hover-light-primary font-weight-bold btn-lg btn-block text-dark text-hover-primary">Informacion Personal</a>
                              <a href="{{ url()->route("informacion-cuenta") }}" type="button" class="btn btn-text-primary btn-hover-light-primary font-weight-bold btn-lg btn-block text-dark text-hover-primary">Informacion de la Cuenta</a>
                              <a href="{{ url()->route("cambiar-contraseña") }}"  type="checkbox" class="btn btn-text-primary btn-hover-light-primary font-weight-bold btn-lg btn-block text-dark text-hover-primary">Cambiar Contraseña</a>
                              <a href="{{ url()->route("usuarios")}}" type="button" class="btn btn-text-primary btn-hover-light-primary font-weight-bold btn-lg btn-block text-dark text-hover-primary">Usuario</a>
                         </div>
                    </div>
              </div>  
            </div> 

            <div class="row">
                <div class=" nav col-lg-4" style="margin-bottom: 30px;"> 
                    <div class="card" >
                          <div class="card-body">
                              {{-- img --}}
                            <div class="d-flex align-items-center mt-5" style="border-bottom:  1px solid #ECF0F3 !important;padding-bottom: 30px">
                                <div class="symbol symbol-100 mr-5">
                                    {{-- <div class="symbol-label" style="background-image:url('media/users/300_21.jpg')"></div> --}}
                                    <span class="symbol-label font-size-h2 font-weight-bold bg-dark-o-30">RS</span>
                                    <i class="symbol-badge bg-success"></i>
                                </div>
                                <div class="d-flex flex-column">
                                <a href="{{ url()->route("perfil") }}" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"> {{ $user->name }} {{$user->fathers_surname}}</a>
                                    <div class="text-muted mt-1">Frontend Development</div>
                                    <div class="navi mt-2">
                                        <a href="mailto:alberto.salazars@nuevoleon.gob.mx" class="navi-item">
                                            <span class="navi-link p-0 pb-2">
                                                <span class="navi-icon mr-1">
                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                        <!--begin::Svg Icon | path:media/svg/icons/Communication/Mail-notification.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
                                                                <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text text-muted text-hover-primary text-truncate col-8 pl-0">{{ $user->email}}</span>
                                            </span>
                                        </a>
                                        <a href="{{ url()->route("logout") }}" class="btn btn-sm  btn-info font-weight-bolder text-white  text-hover-white py-2 px-5">Chat</a>
                                        <a href="{{ url()->route("logout") }}" class="btn btn-sm btn-primary font-weight-bolder  text-white text-hover-white py-2 px-5">Seguir</a>
                                    </div>
                                </div>
                            </div>
                            {{-- datos --}}
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align: middle">
                                                    <div>
                                                        <span>
                                                            Email   
                                                        </span>
                                                    </div>
                                                </td>
                                                <td colspan="3">
                                                    <span class="text-muted text-truncate col-8 pl-0">
                                                        {{ $user->email  }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: middle">
                                                    <div>
                                                        <span>
                                                            Phone   
                                                        </span>
                                                    </div>
                                                </td>
                                                <td colspan="3">
                                                    <span class="text-muted" style="padding-right: 10%">
                                                        {{ $user->phone  }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: middle">
                                                    <div >
                                                        <span>
                                                            Ubicacion   
                                                        </span>
                                                    </div>
                                                </td>
                                                <td colspan="3">
                                                    <span class="text-muted">
                                                       Lorem ipsum dolor sit amet consectetur 
                                                    </span>
                                               
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                    <a href="{{ url()->route("perfil") }}" type="button" class="btn btn-text-primary btn-hover-light-primary font-weight-bold btn-lg btn-block text-dark text-hover-primary">Informacion Personal</a>
                              <a href="{{ url()->route("informacion-cuenta") }}" type="button" class="btn btn-text-primary btn-hover-light-primary font-weight-bold btn-lg btn-block text-dark text-hover-primary">Informacion de la Cuenta</a>
                              <a href="{{ url()->route("cambiar-contraseña") }}"  type="checkbox" class="btn btn-text-primary btn-hover-light-primary font-weight-bold btn-lg btn-block text-dark text-hover-primary">Cambiar Contraseña</a>
                              <a href="{{ url()->route("usuarios")}}" type="button" class="btn btn-text-primary btn-hover-light-primary font-weight-bold btn-lg btn-block text-dark text-hover-primary">Usuario</a>
                                </div>
                          </div>
                    </div>
                </div>
                <div class="col-lg-8" style="margin-bottom: 30px;"> 
                    <div class="card" >
                        <div class="p-6">
                            <div  class="row">
                                <div class="col-md-5 col-sm-12 pl-12">
                                    <span style="font-size: .6cm">Informacion Personal</span>
                                    <br>
                                    <span >Cambiar la configuracion de la cuenta</span>

                                </div>
                                <div class="col-md-7 col-sm-12  pt-6  pt-sm-6 pt-md-0">
                                    <a class="btn btn-icon btn-primary btn-cancelar ">Cancelar</a>
                                    <a class="btn btn-icon btn-primary btn-guardar" > Guardar cambios</a>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-md-5 col-sm-12">
                                    <span >Cambiar la configuracion de la cuenta</span>
                                </div> 
                            </div>--}}
                        </div>
                        <div class="dropdown-divider"></div>
                                                        <!--begin::Form-->
                                <form>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label  class="col-3 col-form-label"></label>
                                            <div class="col-8">
                                                <label  class="col-8 col-form-label">Informacion:</label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label  class="col-md-3 col-sm-12 col-form-label">Avatar</label>
                                            <div class="col-md-8 col-sm-12 text-center">
                                                <div class="symbol symbol-100 mr-5">
                                                    {{-- <div class="symbol-label" style="background-image:url('media/users/300_21.jpg')"></div> --}}
                                                    <span class="symbol-label font-size-h2 font-weight-bold bg-dark-o-30">RS</span>
                                                    <a href=""><i class="symbol-badge la la-pencil-alt"></i></a>
                                                </div>   
                                                <span class="form-text text-muted">Lorem ipsum dolor sit, amet consectetur adipisicing elit</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label  class="col-md-3 col-sm-12 col-form-label">Nombre de la notaria</label>
                                            <div class="col-md-8 col-sm-12">
                                                <input class="form-control" type="text" placeholder="Nombre de la notaria" id="example-text-input"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label  class="col-md-3 col-sm-12 col-form-label">Rol Asignado</label>
                                            <div class="col-md-8 col-sm-12">
                                                <input class="form-control" type="text" value="{{ $user->role_name }}" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-search-input" class="col-md-3 col-sm-12 col-form-label">Nombres(s)</label>
                                            <div class="col-md-8 col-sm-12">
                                                <input class="form-control" type="text" value="{{ $user->name }} {{ $user->mothers_surname}} {{ $user->fathers_surname }}" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-email-input" class="col-md-3 col-sm-12 col-form-label">Apellido Paterno</label>
                                            <div class="col-md-8 col-sm-12">
                                                <input class="form-control" type="text"  value="{{ $user->fathers_surname }}" disabled />
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="dropdown-divider"></div>
                                 <!--begin::Form-->
                                 <form>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label  class="col-md-3 col-sm-12 col-form-label"></label>
                                            <div class="col-md-8 col-sm-12">
                                                <label  class="col-8 col-form-label">Informacion del contacto:</label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label  class="col-md-3 col-sm-12 col-form-label">Correo Electronioco</label>
                                            <div class="col-md-8 col-sm-12">
                                                <input class="form-control" type="text"  value="{{ $user->email }}" disabled id="example-text-input"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-search-input" class="col-md-3 col-sm-12 col-form-label">Contraseña</label>
                                            <div class="col-md-8 col-sm-12">
                                                <input class="form-control" type="text" placeholder="Contraseña"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-email-input" class="col-md-3 col-sm-12 col-form-label">Curp </label>
                                            <div class="col-md-8 col-sm-12">
                                                <input class="form-control" type="text"  value="{{ $user->curp }}" disabled />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-email-input" class="col-md-3 col-sm-12 col-form-label">RFC</label>
                                            <div class="col-md-8 col-sm-12">
                                                <input class="form-control" type="text"  value="{{ $user->rfc }}" disabled />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-email-input" class="col-md-3 col-sm-12 col-form-label">Numero de Contacto </label>
                                            <div class="col-md-8 col-sm-12">
                                                <input class="form-control" type="text" value="{{ $user->phone }}" disabled />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-email-input" class="col-md-3 col-sm-12 col-form-label">Persona Fisica/Moral </label>
                                            <div class="col-md-8 col-sm-12">
                                                <select class="form-control" id="exampleSelect1">
                                                    <option>Fisica</option>
                                                    <option>Moral</option>
                                                   </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                    </div>
                </div>
            </div>

        </div>        
    </div>
</div> 


<script>
    function openNav() {
      document.getElementById("Sidenav").style.width = "90%";
      document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
      
    }
    
    function closeNav() {
      document.getElementById("Sidenav").style.width = "0";
      document.body.style.backgroundColor = "#f2f3f7";

    }
</script>
