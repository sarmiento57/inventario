<?php
    //Almacenar los datos del formulario
    //limpiar cadenas de texto y eliminar caracteres especiales y espacios en blanco al principio y al final
    $usuario = limpiar_cadena($_POST['login_usuario']); // recupera el valor del campo usuario_nombre
    $clave = limpiar_cadena($_POST['login_clave']);

    //segundo filtro en el back-end
    if($usuario == "" || $clave == "" ){
        echo '
            <div class="notification is-danger is-light">
                 <strong>¡Ocurrió un error inesperado!</strong><br>
                 No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    //verificando integridad de los datos
    if(verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)){
        echo '
            <div class="notification is-danger is-light">
                 <strong>¡Ocurrió un error inesperado!</strong><br>
                 El usuario no cumple con el formato requerido
            </div>
        ';
        exit();
    }
    
    if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave)){
        echo '
            <div class="notification is-danger is-light">
                 <strong>¡Ocurrió un error inesperado!</strong><br>
                 La clave no cumple con el formato requerido
            </div>
        ';
        exit();
    }

    //verificar si el usuario existe en la base de datos
    $check_user = conexion();
    $check_user=$check_user->query("SELECT * FROM usuario WHERE usuario_usuario = '$usuario'");

    if($check_user->rowCount()==1){
        $check_user = $check_user->fetch();
        if($check_user['usuario_usuario'] == $usuario && password_verify($clave, $check_user['usuario_clave'])){
            $_SESSION['id']=$check_user['usuario_id'];
            $_SESSION['nombre']=$check_user['usuario_nombre'];
            $_SESSION['apellido']=$check_user['usuario_apellido'];
            $_SESSION['usuario']=$check_user['usuario_usuario'];

            if(headers_sent()){
                echo '<script>window.location.href="./index.php?vista=home";</script>';
            }else{
                header('Location: ./index.php?vista=home');
            }

        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    Usuario o clave incorrectos
                </div>
            ';
                 
        }
    } else{
        echo '
            <div class="notification is-danger is-light">
                 <strong>¡Ocurrió un error inesperado!</strong><br>
                 El usuario no existe en la base de datos
            </div>
            ';
    }
    $check_user = null;
