<?php
if(isset($_POST['del_ticket'])){
  $id=MysqlQuery::RequestPost('del_ticket');

  if(MysqlQuery::Eliminar("ticket", "serie='$id'")){
    echo '
        <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="text-center">PQR ELIMINADO</h4>
            <p class="text-center">
                El PQR fue eliminado con exito
            </p>
        </div>
    ';
  }else{
    echo '
        <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="text-center">OCURRIÓ UN ERROR</h4>
            <p class="text-center">
                Lo sentimos, no hemos podido eliminar el PQR
            </p>
        </div>
    ';
  }
}

if(isset($_POST['upd_pqr']) && isset($_POST['upd_estado_pqr'])) {

  $id_colsul= MysqlQuery::RequestGet('id_consul');
  $estado_pqr= MysqlQuery::RequestPost('upd_estado_pqr');

  $consulta_tablaTicket=Mysql::consulta("SELECT * FROM ticket WHERE serie= '$id_colsul'");

    if(mysqli_num_rows($consulta_tablaTicket)>=1){

     MysqlQuery::Actualizar("ticket", "estado_pqr='$estado_pqr'", "serie='$id_colsul'");

    echo '
          <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="text-center">Estado_pqr ACTUALIZADA</h4>
              <p class="text-center">
                ¡El Estado_PQR ha sido actualizado correctamente!
              </p>
          </div>
        ';

    }else{

      echo '
            <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="text-center">OCURRIÓ UN ERROR CON EL PQR</h4>
                <p class="text-center">
                    Lo sentimos, no Existe el id_PQR
                </p>
            </div>
        ';
  }


}




$email_consul=  MysqlQuery::RequestGet('email_consul');
$id_colsul= MysqlQuery::RequestGet('id_consul');

$consulta_tablaTicket=Mysql::consulta("SELECT * FROM ticket WHERE serie= '$id_colsul' AND email_usuario='$email_consul'");
if(mysqli_num_rows($consulta_tablaTicket)>=1){
  $lsT=mysqli_fetch_array($consulta_tablaTicket, MYSQLI_ASSOC);   
?>
        <div class="container">
            <div class="row well">
            <div class="col-sm-2">
                <img src="img/status.png" class="img-responsive" alt="Image">
            </div>
            <div class="col-sm-10 lead text-justify">
              <h2 class="text-info">Estado de PQR de soporte</h2>
              <p>Si su <strong>PQR</strong> no ha sido solucionado aún, espere pacientemente, estamos trabajando para poder resolver su problema y darle una solución.</p>
            </div>
          </div><!--fin row well-->
          <div class="row">
              <div class="col-sm-12">
                    <div class="panel panel-success">
                        <div class="panel-heading text-center"><h4><i class="fa fa-ticket"></i> PQR &nbsp;#<?php echo $lsT['serie']; ?></h4></div>
                      <div class="panel-body">
                          <div class="container">
                              <div class="col-sm-12">
                                  <div class="row">
                                      <div class="col-sm-4">
                                          <img class="img-responsive" alt="Image" src="img/tux_repair.png">
                                      </div>
                                      <div class="col-sm-8">
                                        <form action="" method="POST">
                                          <div class="row">
                                              <div class="col-sm-6"><strong>Fecha Creación:</strong> <?php echo $lsT['fecha_creacion_PQR']; ?></div>
                                              <div class="col-sm-6"><strong>Estado PQR:</strong>

                                              <?php if ($lsT['estado_pqr'] == "Nuevo") { ?>
                                               
                                                <select name="upd_estado_pqr" id="">
                                                    <option value="<?php echo $lsT['estado_pqr']; ?>" selected><?php echo $lsT['estado_pqr']; ?></option>
                                                    <option value="En Ejecucion">En Ejecución</option>
                                                    <option value="Cerrado">Cerrado</option>
                                                </select>  
                                              
                                              <?php } else if ($lsT['estado_pqr'] == "En Ejecucion") { ?>

                                                <select name="upd_estado_pqr" id="">                                                    
                                                    <option value="Nuevo">Nuevo</option>
                                                    <option value="<?php echo $lsT['estado_pqr']; ?>" selected><?php echo $lsT['estado_pqr']; ?></option>
                                                    <option value="Cerrado">Cerrado</option>
                                                </select>   

                                              <?php } else if ($lsT['estado_pqr'] == "Cerrado") { ?> 

                                                <select name="upd_estado_pqr" id="">                                                   
                                                    <option value="Nuevo">Nuevo</option>
                                                    <option value="En Ejecucion">En Ejecución</option>
                                                    <option value="<?php echo $lsT['estado_pqr']; ?>" selected><?php echo $lsT['estado_pqr']; ?></option>
                                                </select>  
                                                 
                                              <?php } ?>  
                                              </div>
                                          </div>
                                          <br>
                                          <div class="row">
                                              <div class="col-sm-6"><strong>Nombre Usuario:</strong> <?php echo $lsT['nombre_usuario']; ?></div>
                                              <div class="col-sm-6"><strong>Email Usuario:</strong> <?php echo $lsT['email_usuario']; ?></div>
                                          </div>
                                          <br>
                                          <div class="row">
                                              <div class="col-sm-6"><strong>Tipo PQR:</strong> <?php echo $lsT['Tipo_pqr']; ?></div>
                                              <div class="col-sm-6"><strong>Asunto PQR:</strong> <?php echo $lsT['asunto_pqr']; ?></div>
                                          </div>
                                          <br>
                                          <div class="row">
                                              <div class="col-sm-12"><strong>Descripción PQR:</strong> <?php echo $lsT['descripcion_pqr']; ?></div>
                                          </div>
                                          <br>
                                          <div class="row">
                                              <div class="col-sm-12"><strong>Solución:</strong> <?php echo $lsT['solucion']; ?></div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="panel-footer text-center">
                          <div class="row">
                              <h4>Opciones</h4>

                              <?php if ($_SESSION['tipo']=="admin" && ($lsT['estado_pqr'] == "Nuevo" || $lsT['estado_pqr'] == "En Ejecucion")) { ?>                         

                                  <div class="col-sm-4">                                  
                                          <input type="text" value="<?php echo $lsT['serie']; ?>" name="upd_pqr" hidden="">
                                          <button class="btn btn-danger"><span class="glyphicon glyphicon-tag"></span>&nbsp;  Actualizar Estado PQR</button>
                                      </form>
                                  </div>
                                  <div class="col-sm-4">
                                      <form action="" method="POST">
                                          <input type="text" value="<?php echo $lsT['serie']; ?>" name="del_ticket" hidden="">
                                          <button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>&nbsp;  Eliminar PQR</button>
                                      </form>
                                  </div>
                                    
                              <?php } ?>
                                
                              <!-- <br class="hidden-lg hidden-md hidden-sm"> -->
                              <div class="col-sm-4 float-right">
                                   <button id="save" class="btn btn-success" data-id="<?php echo $lsT['serie']; ?>"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; Guardar PQR en PDF</button>
                              </div>
                          </div>
                      </div>
                    </div>
              </div>
          </div>
        </div>
 <?php }else{ ?>
        <div class="container">
            <div class="row  animated fadeInDownBig">
                <div class="col-sm-4">
                    <img src="img/error.png" alt="Image" class="img-responsive"/><br>
                    <img src="img/SadTux.png" alt="Image" class="img-responsive"/>
                    
                </div>
                <div class="col-sm-7 text-center">
                    <h1 class="text-danger">Lo sentimos ha ocurrido un error al hacer la consulta, esto se debe a lo siguiente:</h1>
                    <h3 class="text-warning"><i class="fa fa-check"></i> El PQR ha sido eliminado completamente.</h3>
                    <h3 class="text-warning"><i class="fa fa-check"></i> Los datos ingresados no son correctos.</h3>
                    <br>
                    <h3 class="text-primary"> Por favor verifique que su <strong>id PQR</strong> y <strong>email</strong> sean correctos, e intente nuevamente.</h3>
                    <h4><a href="./index.php?view=soporte" class="btn btn-primary"><i class="fa fa-reply"></i> Regresar a soporte</a></h4>
                </div>
                <div class="col-sm-1">&nbsp;</div>
            </div>
        </div>
<?php } ?>
<script>
  $(document).ready(function(){
    $("button#save").click(function (){
       window.open ("./lib/pdf_user.php?id="+$(this).attr("data-id"));
    });
  });
</script>