<?php
    require_once"../php/main.php";

    //Almacenar los datos del formulario
    //limpiar cadenas de texto y eliminar caracteres especiales y espacios en blanco al principio y al final
    $nombre = limpiar_cadena($_POST['usuario_nombre']); // recupera el valor del campo usuario_nombre
    $apellido = limpiar_cadena($_POST['usuario_apellido']);
    $usuario = limpiar_cadena($_POST['usuario_usuario']);
    $email = limpiar_cadena($_POST['usuario_email']);
    $clave_1 = limpiar_cadena($_POST['usuario_clave_1']);
    $clave_2 = limpiar_cadena($_POST['usuario_clave_2']);

    //segundo filtro en el back-end
    if($nombre == "" || $apellido =="" || $usuario == "" || $clave_1 == "" || $clave_2 == ""){
        echo '
            <div class="notification is-danger is-light">
                 <strong>¡Ocurrió un error inesperado!</strong><br>
                 No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    //verificando integridad de los datos
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,40}", $nombre)){
        echo '
            <div class="notification is-danger is-light">
                 <strong>¡Ocurrió un error inesperado!</strong><br>
                 El nombre no cumple con el formato requerido
            </div>
        ';
        exit();
    }
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,40}", $apellido)){
        echo '
            <div class="notification is-danger is-light">
                 <strong>¡Ocurrió un error inesperado!</strong><br>
                 El apellido no cumple con el formato requerido
            </div>
        ';
        exit();
    }
    if(verificar_datos("[a-zA-Z0-9]{4,28}", $usuario)){
        echo '
            <div class="notification is-danger is-light">
                 <strong>¡Ocurrió un error inesperado!</strong><br>
                 El usuario no cumple con el formato requerido
            </div>
        ';
        exit();
    }
    
    if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_2)){
        echo '
            <div class="notification is-danger is-light">
                 <strong>¡Ocurrió un error inesperado!</strong><br>
                 Las CLAVES no cumple con el formato requerido
            </div>
        ';
        exit();
    }

    //verificando el email
    if($email!=""){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email = conexion();
            $check_email = $check_email->query(("SELECT usuario_email FROM usuario WHERE usuario_email = '$email'"));
            if($check_email->rowCount()>0){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        El email ya se encuentra registrado
                    </div>
                ';
                exit();
            }
            $check_email = null;
        } else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    El email no cumple con el formato requerido
                </div>
            ';
            exit();
        }
    }

    //verificando usuario
    $check_usuario = conexion();
            $check_usuario = $check_usuario->query(("SELECT usuario_usuario FROM usuario WHERE usuario_usuario = '$usuario'"));
            if($check_usuario->rowCount()>0){//cuantos registros se encontraron
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        El usuario ya se encuentra registrado
                    </div>
                ';
                exit();
            }
            $check_usuario = null;


    //verificando claves
    if($clave_1 != $clave_2){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Las claves no coinciden
            </div>
        ';
        exit();
    } else{
        $clave = password_hash($clave_1, PASSWORD_BCRYPT, ["cost"=>10]);  
    }

    //guardar los datos en la base de datos
    $guardar_usuario = conexion();
    $guardar_usuario = $guardar_usuario->prepare("INSERT INTO usuario (usuario_nombre, usuario_apellido, usuario_usuario, usuario_clave, usuario_email) VALUES(:nombre, :apellido, :usuario, :clave, :email)");

    $marcadores = [
        ":nombre" => $nombre, 
        ":apellido" => $apellido, 
        ":usuario" => $usuario, 
        ":clave" => $clave, 
        ":email" => $email
    ];
    $guardar_usuario->execute($marcadores);//ejecuta la consulta

    if($guardar_usuario->rowCount()==1){//cuantos registros se encontraron
        echo '
            <div class="notification is-success is-light">
                <strong>¡Registro exitoso!</strong><br>
                El usuario se ha registrado correctamente
            </div>
        ';
    } else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El usuario no se ha registrado correctamente
            </div>
        ';
    }
    $guardar_usuario = null; //cerrar la conexión
    ?>