<?php if(isset($_SESSION['nombre']) && isset($_SESSION['tipo'])){
        

        if(isset($_POST['fecha_creacion_PQR']) && isset($_POST['nombre_usuario']) && isset($_POST['email_usuario'])){

          /*Este codigo nos servira para generar un numero diferente para cada PQR*/
          $codigo = ""; 
          $longitud = 2; 
          for ($i=1; $i<=$longitud; $i++){ 
            $numero = rand(0,9); 
            $codigo .= $numero; 
          } 
          $num=Mysql::consulta("SELECT * FROM ticket");
          $numero_filas = mysqli_num_rows($num);

          $numero_filas_total=$numero_filas+1;
          $id_pqr="PQR".$codigo."N".$numero_filas_total;
          /*Fin codigo numero de PQR*/

          $solucion = "";
          $Tipo_pqr= MysqlQuery::RequestPost('Tipo_pqr');
          if ($Tipo_pqr == "Peticion") {
            $solucion = "En 7 días damos solución";
          }else if ($Tipo_pqr == "Queja") {
            $solucion = "En 3 días damos solución";
          }else if ($Tipo_pqr == "Queja") {
            $solucion = "En 2 días damos solución";
          }

          $nombre_usuario=  MysqlQuery::RequestPost('nombre_usuario');
          $email_usuario= MysqlQuery::RequestPost('email_usuario');
          $asunto_pqr= MysqlQuery::RequestPost('asunto_pqr');
          $estado_pqr= MysqlQuery::RequestPost('estado_pqr');
          $fecha_creacion_PQR=  MysqlQuery::RequestPost('fecha_creacion_PQR');
          $fecha_limite_atencion = "";
          $descripcion_pqr=  MysqlQuery::RequestPost('descripcion_pqr');         
          $cabecera="From: SoporteSystem Colombia<sluque@qdit.co>";
          $mensaje_mail="¡Gracias por reportarnos su problema! Buscaremos una solución para su PQR lo mas pronto posible. Su ID PQR es: ".$id_pqr;
          $mensaje_mail=wordwrap($mensaje_mail, 70, "\r\n");

          
         
          if(MysqlQuery::Guardar("ticket", "fecha_creacion_PQR, fecha_limite_atencion, nombre_usuario, email_usuario, Tipo_pqr, asunto_pqr, descripcion_pqr, estado_pqr, serie, solucion", "'$fecha_creacion_PQR', '$fecha_limite_atencion', '$nombre_usuario', '$email_usuario', '$Tipo_pqr', '$asunto_pqr', '$descripcion_pqr', '$estado_pqr', '$id_pqr', '$solucion'")){

            /*----------  Enviar correo con los datos del PQR
            mail($email_usuario, $asunto_pqr, $descripcion_pqr, $cabecera)
            ----------*/
            
            echo '
                <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">PQR CREADO</h4>
                    <p class="text-center">
                        PQR creado con exito '.$_SESSION['nombre'].'<br>El PQR ID es: <strong>'.$id_pqr.'</strong>
                    </p>
                </div>
            ';

          }else{
            echo '
                <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                    <p class="text-center">
                        No hemos podido crear el PQR. Por favor intente nuevamente.
                    </p>
                </div>
            ';
          }          
        }
?>
        <div class="container">
          <div class="row well">
            <div class="col-sm-3">
              <img src="img/ticket.png" class="img-responsive" alt="Image">
            </div>
            <div class="col-sm-9 lead">
              <h2 class="text-info">¿Cómo abrir un nuevo PQR?</h2>
              <p>Para abrir un nuevo PQR deberá de llenar todos los campos de el siguiente formulario. Usted podra verificar el estado de su PQR mediante el <strong>PQR ID</strong> que se le proporcionara a usted cuando llene y nos envie el siguiente formulario.</p>
            </div>
          </div><!--fin row 1-->

          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title text-center"><strong><i class="fa fa-ticket"></i>&nbsp;&nbsp;&nbsp;PQR</strong></h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-sm-4 text-center">
                      <br><br><br>
                      <img src="img/write_email.png" alt=""><br><br>
                      <p class="text-primary text-justify">Por favor llene todos los datos de este formulario para abrir su PQR. El <strong>PQR ID</strong> será enviado a la dirección de correo electronico proporcionada en este formulario.</p>
                    </div>
                    <div class="col-sm-8">
                      <form class="form-horizontal" role="form" action="" method="POST">
                          <fieldset>

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Tipo PQR</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <select class="form-control" name="Tipo_pqr">
                                  <option value="Peticion">Petición</option>
                                  <option value="Queja">Queja</option>
                                  <option value="Reclamo">Reclamo</option>
                                </select>
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                              </div> 
                          </div>
                        </div> 

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Asunto</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Asunto" name="asunto_pqr" required="">
                                <span class="input-group-addon"><i class="fa fa-paperclip"></i></span>
                              </div> 
                          </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Usuario</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Nombre" required="" pattern="[a-zA-Z ]{1,30}" name="nombre_usuario" title="Nombre Apellido">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="email_usuario" required="" title="Ejemplo@dominio.com">
                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                              </div> 
                          </div>
                        </div> 

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Estado</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <select class="form-control" name="estado_pqr">
                                  <option value="Nuevo">Nuevo</option>
                                  <option value="En Ejecucion">En Ejecución</option>
                                  <option value="Cerrado">Cerrado</option>
                                </select>
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                              </div> 
                          </div>
                        </div>    
                            
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Fecha Creación</label>
                            <div class='col-sm-10'>
                                <div class="input-group">
                                    <input class="form-control" type="text" id="fechainput" placeholder="Fecha Creación" name="fecha_creacion_PQR" required="" readonly>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>    

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Descripción PQR</label>
                          <div class="col-sm-10">
                            <textarea class="form-control" rows="3" placeholder="Escriba una breve descripción de su PQR " name="descripcion_pqr" required=""></textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-info">Abrir PQR</button>
                          </div>
                        </div>
                             </fieldset> 
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<?php
}else{
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <img src="./img/Stop.png" alt="Image" class="img-responsive"/><br>
                <img src="./img/SadTux.png" alt="Image" class="img-responsive"/>
                
            </div>
            <div class="col-sm-7 text-center">
                <h1 class="text-danger">Lo sentimos esta página es solamente para usuarios registrados en SoporteSystem</h1>
                <h3 class="text-info">Inicia sesión para poder acceder</h3>
            </div>
            <div class="col-sm-1">&nbsp;</div>
        </div>
    </div>
<?php
}
?>
<script type="text/javascript">
  $(document).ready(function(){
      $("#fechainput").datepicker();
  });
</script>