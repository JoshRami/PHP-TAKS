<?php
    /** 
    * @version 1
    * @author Josue Ismael Quinteros Ramires
    * @carnet QR100318
    * Este archivo administra la logica para ingresar un nuevo autor a la DB
    * Utiliza el archivo db.php para tener la variable con que contiene la conexion a la db empresa
    * carga el contenido de la plantilla agregar.html para luego cargar la nav y la opcion de guardar un nuevo autor
    */

    //Incluyendo el archivo de conexion a la base de datos
    require_once "db/db.php";
    
    //Evaluando si esta definido un parametro "acc" y que su valor sea vacio
    if(isset($_REQUEST['add'])=='')
    {
        //file_get_contents — Lee el archivo completo en una cadena
        $pagina = file_get_contents("templates/agregar.html");
        //preg_replace($pattern, $replacement, $string);
        $pagina = preg_replace('/--nav--/', GetNav(), $pagina);
        $pagina = preg_replace('/--alert--/', '', $pagina);

        echo $pagina;
    }
    else
    {
        //file_get_contents — Lee el archivo completo en una cadena
        $pagina = file_get_contents("templates/agregar.html");
        //preg_replace($pattern, $replacement, $string);
        $pagina = preg_replace('/--nav--/', GetNav(), $pagina);
        $pagina = preg_replace('/--alert--/', GetAlert(), $pagina);
        
        echo $pagina;
    }

    //Esta funcion genera todo el html para la navegacion, luego la pagina la agrega si desea
    function GetNav()
    {
        $active='<li class=" textnav-item active"><a class=" text-white nav-link" href="index.php">Lista de autores</a></li>
        <li class=" nav-item"><a class="text-white nav-link" href="agregar.php">Agregar autores</a></li>';
        
        //file_get_contents
        $nav = file_get_contents("templates/nav.html");
        //preg_replace
        $nav = preg_replace('/--active--/', $active, $nav);
        
        return $nav;
    }

    function GetAlert()
    {
             
        global $con;
        $alert="";

        $nombre	= mysqli_real_escape_string($con,(strip_tags($_REQUEST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
        $carnet	= mysqli_real_escape_string($con,(strip_tags($_REQUEST["carnet"],ENT_QUOTES)));//Escanpando caracteres 
        // En este caso el id se asigna por la DB el usuario no conoce su id, la unica forma es evaluar que no haya un usuario con un mismo carnet
        $query = mysqli_query($con, "SELECT * FROM autor WHERE carnet='$carnet'");
        if(mysqli_num_rows($query) == 0){
                $insert = mysqli_query($con, "INSERT INTO autor(nombre, carnet)
                                              VALUES('$nombre','$carnet')") or die(mysqli_error($con));
                if(mysqli_affected_rows($con) > 0){
                    $alert.= '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
                }else{
                    $alert.= '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
                }                              
        }else{
            $alert.= '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. carnet existe!</div>';
        }

        // Cerrando el resulset
        mysqli_free_result($query);

        return $alert;
    }

?>