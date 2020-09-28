<?php
    /** 
    * @version 1
    * @author Josue Ismael Quinteros Ramires
    * @carnet QR100318
    * Read del CRUD, recibe el  id del autor para mostrar sus datos que deben de ser pasador al llamar a esta pagina
    */


    //Incluyendo el archivo de conexion a la base de datos
    require_once "db/db.php";
    
    //Evaluando si esta definido un parametro "acc" y que su valor sea vacio
    if(isset($_REQUEST['acc'])=='')
    {
        //file_get_contents — Lee el archivo completo en una cadena
        $pagina = file_get_contents("templates/perfil.html");
        //preg_replace($pattern, $replacement, $string);
        $pagina = preg_replace('/--nav--/', GetNav(), $pagina);
        $pagina = preg_replace('/--alert--/', '', $pagina);
        $pagina = preg_replace('/--content--/', GetInfo(), $pagina);

        echo $pagina;
    }
    else
    {
        //file_get_contents — Lee el archivo completo en una cadena
        $pagina = file_get_contents("templates/perfil.html");
        //preg_replace($pattern, $replacement, $string);
        $pagina = preg_replace('/--nav--/', GetNav(), $pagina);
        $pagina = preg_replace('/--alert--/', GetAlert(), $pagina);
        $pagina = preg_replace('/--content--/', GetInfo(), $pagina);
        
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

    /**
     * Metodo que retorna una alerta cuando una acción es ejecutada en el index. Ej. Eliminar un empleado
     * @return $alert 
     */
    function GetAlert()
    {   
        global $con;
        $alert="";

        //mysqli_real_escape_string - Escapa los caracteres especiales de una cadena para usarla en una sentencia SQL, tomando en cuenta el conjunto de caracteres actual de la conexión
        //strip_tags -  Retira las etiquetas HTML y PHP de un string
        $idAutor = mysqli_real_escape_string($con,(strip_tags($_REQUEST["idAutor"],ENT_QUOTES)));
        $delete = mysqli_query($con, "DELETE FROM autor WHERE idAutor=$idAutor");
        if($delete){
            $alert .= '<div class="alert alert-danger alert-dismissable">><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Autor borrado con éxito</div>';
        }else{
            $alert .= '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>No se pudo eliminar al autor</div>';
        }    

        // Cerrando el resulset
        mysqli_free_result($delete);

        return $alert;
    }

    /**
     * Metodo que la información contenida en la tabla empleados de nuestra base de datos
     * @return $info Información obtenida desde la base de datos que sera procesada para mostrarla en una tabla
     */    
    function GetInfo()
    {
        global $con;
        $info="";

        //mysqli_real_escape_string - Escapa los caracteres especiales de una cadena para usarla en una sentencia SQL, tomando en cuenta el conjunto de caracteres actual de la conexión
        //strip_tags -  Retira las etiquetas HTML y PHP de un string
        $idAutor = mysqli_real_escape_string($con,(strip_tags($_REQUEST["idAutor"],ENT_QUOTES)));
        $sql = mysqli_query($con, "SELECT * FROM autor WHERE idAutor='$idAutor'");
        if(mysqli_num_rows($sql) == 0){
            header("Location: index.php");
        }else{
            $row = mysqli_fetch_assoc($sql);
            $id	= $row['idAutor'];
            $carnet	= $row['carnet'];
            $nombre	=  $row['nombre'];

            $info = "<table class=\"table table-striped table-condensed\">
            <tr>
                <th width=\"30%\">Código</th>
                <td>$id</td>
            </tr>
            <tr>
                <th>Nombre del empleado</th>
                <td>$nombre</td>
            </tr>
            <tr>
                <th>Lugar y Fecha de Nacimiento</th>
                <td>$carnet</td>
            </tr>
        </table>
        
        <a href=\"index.php\" class=\"btn btn-sm btn-outline-info\"><i class=\"fa fa-undo\"></i> Regresar</a>
        <a href=\"editar.php?idAutor=$id\" class=\"btn btn-sm btn-outline-success mx-3\"><i class=\"fa fa-edit\"></i></span> Editar datos</a>
        <a href=\"perfil.php?acc=delete&idAutor=$id\" class=\"btn btn-sm btn-outline-danger\" onclick=\"return confirm('&iquest;Esta seguro de borrar los datos $nombre?')\"><i class=\"fa fa-trash-o\"></i> Eliminar</a>";
        }

        // Cerrando el resulset
        mysqli_free_result($sql);

        return $info;
    }

?>