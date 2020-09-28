<?php
     /** 
    * @version 1
    * @author Josue Ismael Quinteros Ramires
    * @carnet QR100318
    * UPDATE DEL CRUD, usa el archivo db.php para tener la conexion disponible al momento de editar el registro
    * Al cargar la pagina editar.php se debe enviar como parametro en el request una propiedad llamada idAutor
    * para cargar debidamente el autor y actualizarlo
    */
    
    //Incluyendo el archivo de conexion a la base de datos
    require_once "db/db.php";
    
    //Evaluando si esta definido un parametro "save" y que su valor sea vacio
    if(isset($_REQUEST['save'])=='')
    {
        if(isset($_REQUEST['acc'])=='ok')
        {
            //file_get_contents — Lee el archivo completo en una cadena
            $pagina = file_get_contents("templates/editar.html");
            //preg_replace($pattern, $replacement, $string);
            $pagina = preg_replace('/--nav--/', GetNav(), $pagina);
            $pagina = preg_replace('/--alert--/', '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Los datos han sido actualizados con éxito.</div>', $pagina);
            $pagina = preg_replace('/--form--/', GetForm(), $pagina);

            echo $pagina;
        }
        else
        {
            //file_get_contents — Lee el archivo completo en una cadena
            $pagina = file_get_contents("templates/editar.html");
            //preg_replace($pattern, $replacement, $string);
            $pagina = preg_replace('/--nav--/', GetNav(), $pagina);
            $pagina = preg_replace('/--alert--/', '', $pagina);
            $pagina = preg_replace('/--form--/', GetForm(), $pagina);
            echo $pagina;
        }
    }
    else
    {
        //file_get_contents - Lee el archivo completo en una cadena
        $pagina = file_get_contents("templates/editar.html");
        //preg_replace($pattern, $replacement, $string);
        $pagina = preg_replace('/--nav--/', getNav(), $pagina);
        $pagina = preg_replace('/--alert--/', getAlert(), $pagina);
        $pagina = preg_replace('/--form--/', getForm(), $pagina);

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
     * Metodo que retorna una alerta cuando una acción es ejecutada en el index. Ej. Actualizar un empleado
     * @return $alert 
     */
    function GetAlert()
    {
        global $con;
        $alert="";

        //mysqli_real_escape_string - Escapa los caracteres especiales de una cadena para usarla en una sentencia SQL, tomando en cuenta el conjunto de caracteres actual de la conexión
        //strip_tags -  Retira las etiquetas HTML y PHP de un string
        $idAutor = mysqli_real_escape_string($con,(strip_tags($_REQUEST["idAutor"],ENT_QUOTES)));//Escanpando caracteres 
        $nombre = mysqli_real_escape_string($con,(strip_tags($_REQUEST["nombre"],ENT_QUOTES)));//Escanpando caracteres
        $carnet = mysqli_real_escape_string($con,(strip_tags($_REQUEST["carnet"],ENT_QUOTES)));//Escanpando caracteres 
        
        $update = mysqli_query($con, "UPDATE autor SET nombre='$nombre', carnet='$carnet' WHERE idAutor=$idAutor") or die(mysqli_error($con));
        if($update){
            header("Location: editar.php?idAutor=".$idAutor."&acc=ok");
        }else{
            $alert.= '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo actualizar los datos.</div>';
        }

        // Cerrando el resulset
        mysqli_free_result($update);

        return $alert;
    }

    /**
     * Metodo que la información contenida en la tabla empleados de nuestra base de datos
     * @return $form Retorna un formulario con la data almacenada en la base de datos de un empleado en especifico
     */  
    function GetForm()
    {
        global $con;
        $form="";

        //mysqli_real_escape_string - Escapa los caracteres especiales de una cadena para usarla en una sentencia SQL, tomando en cuenta el conjunto de caracteres actual de la conexión
        //strip_tags -  Retira las etiquetas HTML y PHP de un string
        $idAutor = mysqli_real_escape_string($con,(strip_tags($_REQUEST["idAutor"],ENT_QUOTES)));
        $sql = mysqli_query($con, "SELECT * FROM autor WHERE idAutor='$idAutor'");
        if(mysqli_num_rows($sql) > 0){

            $row = mysqli_fetch_assoc($sql);

            $id		     = htmlentities($row['idAutor'],ENT_QUOTES);
            $nombre		     =  htmlentities($row['nombre'], ENT_QUOTES);
            $carnet =  htmlentities($row['carnet'], ENT_QUOTES);

            $form = "<form class=\"form-horizontal ml-2\" action=\"\" method=\"post\">
             <div class=\"form-group row\">
                <label class=\"col-sm-2 control-label\">ID</label>
                <div class=\"col-sm-4\">
                    <input disabled type=\"text\" name=\"idAutor\" value='".$id."' class=\"form-control\" placeholder=\"Lugar de nacimiento\" required>
                </div>
            </div>
            <div class=\"form-group row\">
                <label class=\"col-sm-2 control-label\">Nombres</label>
                <div class=\"col-sm-4\">
                    <input type=\"text\" name=\"nombre\" value='".$nombre."' class=\"form-control\" placeholder=\"Nombre\" required>
                </div>
            </div>
            <div class=\"form-group row\">
                <label class=\"col-sm-2 control-label\">Lugar de nacimiento</label>
                <div class=\"col-sm-4\">
                    <input type=\"text\" name=\"carnet\" value='".$carnet."' class=\"form-control\" placeholder=\"Lugar de nacimiento\" required>
                </div>
            </div>
            
            <div class=\"form-group\">
                <label class=\"col-sm-3 control-label\">&nbsp;</label>
                <div class=\"col-sm-6\">
                    <button type=\"submit\" name=\"save\" class=\"btn btn-md btn-outline-primary mr-2\"><i class=\"fa fa-save\"></i> Guardar datos</button>
                    <a href=\"index.php\" class=\"btn btn-md btn-outline-danger\"><i class=\"fa fa-undo\"></i> Cancelar</a>
                </div>
            </div>
        </form>";        
        }

        // Cerrando el resulset
        mysqli_free_result($sql);

        return $form;
    }
?>