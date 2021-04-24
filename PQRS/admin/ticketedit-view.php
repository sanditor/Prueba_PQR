<?php
	if(isset($_POST['id_serie_edit']) && isset($_POST['solucion_pqr']) && isset($_POST['estado_pqr'])){
		$id_serie_edit= MysqlQuery::RequestPost('id_serie_edit');		
    $fecha_limite_atencion=  MysqlQuery::RequestPost('fecha_limite_atencion');
    $estado_pqr=  MysqlQuery::RequestPost('estado_pqr');  
		$solucion_pqr=  MysqlQuery::RequestPost('solucion_pqr');
		$radio_email=  MysqlQuery::RequestPost('optionsRadios');
    $email_usuario_edit= MysqlQuery::RequestPost('email_usuario');
    $asunto_pqr_edit= MysqlQuery::RequestPost('asunto_pqr');

		$cabecera="From: SoporteSystem Colombia<sluque@qdit.co>";
		$mensaje_mail="Estimado usuario la solución a su problema es la siguiente : ".$solucion_pqr . " y su estado PQR está en: " . $estado_pqr;
		$mensaje_mail=wordwrap($mensaje_mail, 70, "\r\n");


   	if(MysqlQuery::Actualizar("ticket", "fecha_limite_atencion='$fecha_limite_atencion', estado_pqr='$estado_pqr', solucion='$solucion_pqr'", "serie='$id_serie_edit'")){

			echo '
                <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">PQR Actualizado</h4>
                    <p class="text-center">
                        El PQR fue actualizado con exito
                    </p>
                </div>
            ';
			if($radio_email=="option2"){
				mail($email_usuario_edit, $asunto_pqr_edit, $mensaje_mail, $cabecera);
			}

		}else{
			echo '
                <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                    <p class="text-center">
                        No hemos podido actualizar el PQR
                    </p>
                </div>
            '; 
		}
	}     

	     
	$id_serie = MysqlQuery::RequestGet('serie');
	$sql = Mysql::consulta("SELECT * FROM ticket WHERE serie= '$id_serie'");
	$reg=mysqli_fetch_array($sql, MYSQLI_ASSOC);

?>


        <!--************************************ Page content******************************-->
        <div class="container">
          <div class="row">
            <div class="col-sm-3">
                <img src="./img/Edit.png" alt="Image" class="img-responsive animated tada">
            </div>
            <div class="col-sm-9">
                <a href="./admin.php?view=ticketadmin" class="btn btn-primary btn-sm pull-right"><i class="fa fa-reply"></i>&nbsp;&nbsp;Volver administrar PQRS</a>
            </div>
          </div>
        </div>
            
            
          <div class="container">
            <div class="col-sm-12">
                <form class="form-horizontal" role="form" action="" method="POST">
                		<input type="hidden" name="id_serie_edit" value="<?php echo $reg['serie']?>">                        
                       <div class="form-group">
                        <label  class="col-sm-2 control-label">Nombre Usuario</label>
                        <div class="col-sm-10">
                            <div class='input-group'>
                                <input type="text" readonly="" class="form-control"  name="name_ticket" readonly="" value="<?php echo $reg['nombre_usuario']?>">
                              <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Email Usuario</label>
                        <div class="col-sm-10">
                            <div class='input-group'>
                                <input type="email" readonly="" class="form-control"  name="email_usuario" readonly="" value="<?php echo $reg['email_usuario']?>">
                              <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                            </div> 
                        </div>
                      </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Fecha Creacion PQR</label>
                            <div class='col-sm-10'>
                                <div class="input-group">
                                    <input class="form-control" readonly="" type="text" name="fecha_ticket" readonly="" value="<?php echo $reg['fecha_creacion_PQR']?>">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="col-sm-2 control-label">Fecha Limite Atención</label>
                            <div class='col-sm-10'>
                                <div class="input-group">
                                    <input class="form-control" id="fecha_limite_atencion" type="text" name="fecha_limite_atencion" value="<?php echo $reg['fecha_limite_atencion']?>" placeholder="Fecha Limite Atención">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Serie</label>
                            <div class='col-sm-10'>
                                <div class="input-group">
                                    <input class="form-control" readonly="" type="text" name="serie_ticket" readonly="" value="<?php echo $reg['serie']?>">
                                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Estado PQR</label>
                            <div class='col-sm-10'>
                                <div class="input-group">
                                      <select class="form-control" name="estado_pqr">
                                        <option value="<?php echo $reg['estado_pqr']?>"><?php echo $reg['estado_pqr']?> (Actual)</option>
                                        <option value="Nuevo">Nuevo</option>
                                        <option value="En Ejecucion">En Ejecucion</option>
                                        <option value="Cerrado">Cerrado</option>
                                      </select>
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                </div>
                            </div>
                        </div>                       

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Tipo PQR</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                  <select class="form-control" name="Tipo_pqr" disabled="">
                                      <option value="<?php echo $reg['Tipo_pqr']?>"><?php echo $reg['Tipo_pqr']?> (Actual)</option>
                                      <option value="Peticion">Petición</option>
                                      <option value="Queja">Queja</option>
                                      <option value="Reclamo">Reclamo</option>
                                    </select>
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                              </div> 
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Descripción PQR</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                  <input type="text" readonly="" class="form-control"  name="descripcion_pqr" readonly="" value="<?php echo $reg['descripcion_pqr']?>">
                                <span class="input-group-addon"><i class="fa fa-paperclip"></i></span>
                              </div> 
                          </div>
                        </div>

                         <div class="form-group">
                          <label  class="col-sm-2 control-label">Asunto PQR</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                  <input type="text" readonly="" class="form-control"  name="asunto_pqr" readonly="" value="<?php echo $reg['asunto_pqr']?>">
                                <span class="input-group-addon"><i class="fa fa-paperclip"></i></span>
                              </div> 
                          </div>
                        </div>
                
                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Solución</label>
                          <div class="col-sm-10">
                            <textarea class="form-control" rows="3"  name="solucion_pqr" required=""><?php echo $reg['solucion']?></textarea>
                          </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-sm-offset-5">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="optionsRadios" value="option1" checked>
                                        No enviar solución al email del usuario
                                    </label>
                                 </div>


                                <div class="radio">
                                    <label>
                                        <input type="radio" name="optionsRadios" value="option2">
                                         Enviar solución al email del usuario
                                    </label>
                                 </div>
                            </div>
                        </div>
                    
                    <br>   
                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10 text-center">
                              <button type="submit" class="btn btn-info">Actualizar PQR</button>
                          </div>
                        </div>

                      </form>
            </div><!--col-md-12-->
          </div><!--container-->

          <script type="text/javascript">
            $(document).ready(function(){
            $("#fecha_limite_atencion").datepicker();
            });
          </script>