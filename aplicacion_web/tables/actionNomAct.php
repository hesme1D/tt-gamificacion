<?php 
  include "conexion.php";
  //echo ("jola");
  if(isset($_POST['idHistoria']) && isset($_POST['idActv']) && isset($_POST['accion']) ){
    
    if($_POST['accion']=='mostrar'){
      //echo ("hola");
      //$idGrupo = $_POST['idGrupo'];
      $idHistoria = $_POST['idHistoria'];
      $idActv = $_POST['idActv'];
      $QueryJeop = "SELECT * FROM historia_view where id_historia = '$idHistoria' AND id_actividades = '$idActv' ";
      //echo $QueryJeop;
      $Resultado = mysqli_query($Con, $QueryJeop);
        $Res=array();

        while ($renglon=mysqli_fetch_array($Resultado)) {
          $Res['id']=$renglon['id'];
          $Res['imagen_paisaje'] = $renglon['imagen_paisaje'];
          $Res['imagen_personaje'] = $renglon['imagen_personaje'];
          $Res['historia_part'] = $renglon['historia_part'];
        }
    }else{
      $Res['estado']=0;
    }
    
  }else{
    $Res['estado']=0;
  }
  echo json_encode($Res);
?>