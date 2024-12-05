<?php
    //conexión a la base de datos
    function conexion(){
        $pdo = new PDO('mysql:host=localhost;dbname=inventario', 'root', '');
        return $pdo;
    }
    //verificar datos
    function verificar_datos($filtro, $cadena){
        if(preg_match("/^". $filtro. "$/",$cadena )){
            return false;
        } else{
            return true;
        }
    }
    //limpiar cadenas de texto
    function limpiar_cadena($cadena){
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        $cadena = str_ireplace("<script>", "",$cadena); 
        $cadena = str_ireplace("</script>", "",$cadena); 
        $cadena=str_ireplace("<script src", "", $cadena);
		$cadena=str_ireplace("<script type=", "", $cadena); 
		$cadena=str_ireplace("SELECT * FROM", "", $cadena); 
		$cadena=str_ireplace("DELETE FROM", "", $cadena); 
		$cadena=str_ireplace("INSERT INTO", "", $cadena);
		$cadena=str_ireplace("DROP TABLE", "", $cadena); 
		$cadena=str_ireplace("DROP DATABASE", "", $cadena); 
		$cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
		$cadena=str_ireplace("SHOW TABLES;", "", $cadena);
		$cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
		$cadena=str_ireplace("<?php", "", $cadena); 
		$cadena=str_ireplace("?>", "", $cadena); 
		$cadena=str_ireplace("--", "", $cadena); 
		$cadena=str_ireplace("^", "", $cadena); 
		$cadena=str_ireplace("<", "", $cadena); 
		$cadena=str_ireplace("[", "", $cadena); 
		$cadena=str_ireplace("]", "", $cadena); 
		$cadena=str_ireplace("==", "", $cadena); 
		$cadena=str_ireplace(";", "", $cadena); 
		$cadena=str_ireplace("::", "", $cadena); 
		$cadena=trim($cadena); // Elimina espacios en blanco al principio y al final de la cadena
		$cadena=stripslashes($cadena); // Elimina barras invertidas
		return $cadena; // devolver cadena limpia
    }

    //funcion para renombrar fotos
    function renombrar_foto($nombre){
        $nombre = str_ireplace(" ", "_", $nombre);
        $nombre = str_ireplace("/", "_", $nombre);
        $nombre = str_ireplace("#", "_", $nombre);
        $nombre = str_ireplace("-", "_", $nombre);
        $nombre = str_ireplace("$", "_", $nombre);
        $nombre = str_ireplace(".", "_", $nombre);
        $nombre = str_ireplace(",", "_", $nombre);
        $nombre = $nombre. "_".rand(0,100);
        return $nombre;
    }

    //funcion paginador de tablas
    function paginador_tablas($pagina, $Npaginas, $url, $botones){
        $tabla = '<nav class="pagination is-rounded" role="navigation" aria-label="pagination">';
        if($pagina <= 1){
            $tabla.= '<a class="pagination-previous is-disabled" disabled>Anterior</a> <ul class="pagination-list">';
            
        } else{
            $tabla.= '<a href="'.$url.($pagina-1).'" class="pagination-previous">Anterior</a> <ul class="pagination-list"> <li><a href="'.$url.'1" class="pagination-link" >1</a></li>
             <li><span class="pagination-ellipsis">&hellip;</span></li>';
        }

        $ci=0;
        for($i=$pagina; $i <= $Npaginas; $i++){
            if($ci >= $botones){
                break;
            }

            if($pagina == $i){
                $tabla.= '<li><a href="'.$url.$i.'" class="pagination-link is-current" >'.$i.'</a></li>';
            }else{
                $tabla.= '<li><a href="'.$url.$i.'" class="pagination-link" >'.$i.'</a></li>';
            }
            $ci++;
        }

        if($pagina == $Npaginas){
            $tabla.= '</ul>
            <a class="pagination-next is-disabled" disabled >Siguiente</a>';
            
        } else{
            $tabla.= '<li><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a href="'.$url.$Npaginas.'" class="pagination-link" >'.$Npaginas.'</a></li>
            </ul>
            <a class="pagination-next" href="'.$url.($pagina+1).'" >Siguiente</a>';
        }

        $tabla .= '</nav>';
        return $tabla;
    }
?>