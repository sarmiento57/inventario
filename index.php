<?php require './inc/session_start.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      include './inc/head.php';
    ?>
</head>
<body>
  <?php
    if(!isset($_GET['vista']) || $_GET['vista'] == "") {//Si no se ha definido una vista se carga la vista de login
      $_GET['vista'] = "login"; //Se define la vista de login
    }

    if(is_file("./vistas/" . $_GET['vista'] .".php") && $_GET['vista'] != "login" && $_GET['vista']!="404"){//Si la vista existe y no es la de login

      // Cerrar sesión forzadamente
      if((!isset($_SESSION['id']) || $_SESSION['id']=="") || (!isset($_SESSION['usuario']) || $_SESSION['usuario']=="")){
        include "./vistas/logout.php";
        exit();
    }
        
      include './inc/navbar.php';//Se carga la barra de navegación

      include "./vistas/". $_GET['vista'] . ".php";//Se carga la vista solicitada

      include './inc/script.php';  //Se carga el script

    }else{
      if($_GET['vista']=='login'){ //Si la vista es la de login
        include './vistas/login.php'; //Se carga la vista de login
      }else{
        include './vistas/404.php'; //Si no se encuentra la vista solicitada se carga la vista de error 404
      }
    }

  ?>

</body>
</html>
