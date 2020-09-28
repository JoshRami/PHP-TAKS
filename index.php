<?php
/** 
 * @version 1
 * @author Josue Ismael Quinteros Ramires
 * @carnet QR100318
 * Archivo de entrada al programa, aca se obtiene la tabla completa de autores, y se disponen la acciones CRUD
 */

//Se incluye el archivo de conexion a la base de datos empresa
require_once "db/db.php";

//Aca se agrega lo faltante a las view a fin de hacerlo dinamico
//Evaluando si esta definido un parametro "acc" y que su valor sea vacio
if(isset($_REQUEST['acc']) == '')
{
    //file_get_contents — Lee el archivo completo en una cadena
    $pagina = file_get_contents("templates/index.html");
    //preg_replace($pattern, $replacement, $string);
    $pagina = preg_replace('/--nav--/', GetNav(), $pagina);
    $pagina = preg_replace('/--alert--/', '', $pagina);
    $pagina = preg_replace('/--data--/', GetData(), $pagina);
    $pagina = preg_replace('/--year--/', date("Y"), $pagina);
    echo $pagina;
}
else //De lo contrario si van a eliminar a un empleado
{
    $pagina = file_get_contents("templates/index.html");

    $pagina = preg_replace('/--nav--/', GetNav(), $pagina);
    $pagina = preg_replace('/--alert--/', GetAlert(), $pagina); //Este método realiza la accion de eliminar
    $pagina = preg_replace('/--data--/', GetData(), $pagina);
    $pagina = preg_replace('/--year--/', date("Y"), $pagina);

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
 * Método que retorna una alerta cuando una acción es ejecutada en el index. Ej. Eliminar un empleado
 * @return $alert 
 */
function GetAlert()
{
    global $con;
    $alert="";

    //mysqli_real_escape_string - Escapa los caracteres especiales de una cadena para usarla en una sentencia SQL, tomando en cuenta el conjunto de caracteres actual de la conexión
    //strip_tags -  Retira las etiquetas HTML y PHP de un string
    $idAutor = mysqli_real_escape_string($con,(strip_tags($_REQUEST["idAutor"],ENT_QUOTES)));
    $query = mysqli_query($con, "SELECT * FROM autor WHERE idAutor='$idAutor'");    
    
    if(mysqli_num_rows($query) == 0){
        $alert .= '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontró a un autor con ese ID.</div>';
    }else{
        $delete = mysqli_query($con, "DELETE FROM autor WHERE idAutor='$idAutor'");
        if($delete)
        {
            $alert .= '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Autor eliminado correctamente.</div>';
        }else{
            $alert .= '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar al autor.</div>';
        }        
    }
    // Cerrando el resulset
    mysqli_free_result($query);
    
    return $alert;
}

/**
 * Método que la información contenida en la tabla empleados de nuestra base de datos
 * @return $data Información obtenida desde la base de datos que sera procesada para mostrarla en una tabla
 */
function GetData()
{
    //Establecemos $con en un ambito global, con ello accedemos a la conexion a la base de datos
    global $con;
    $data="";

    //En este caso no hay filtros, se extrae la tabla completa
    $sql = mysqli_query($con, "SELECT * FROM autor ORDER BY idAutor ASC");
    
    //Evaluamos si la consulta trae filas
    if(mysqli_num_rows($sql) == 0){
        $data .= '<tr><td colspan="8">No hay datos.</td></tr>';
    }
    else //Si trae filas las recorremos con un WHILE y creamos un arreglo asociativo por cada iteración
    {        
        while($row = mysqli_fetch_assoc($sql)){
            //Concatenamos a la variable data una nueva fila de la tabla por cada iteración
            $data .= '
            <tr>
                <td>'.$row['idAutor'].'</td>
                <td><a href="perfil.php?idAutor='.$row['idAutor'].'" title="Ver Perfil">'.$row['nombre'].'</a></td>
                <td>'.$row['carnet'].'</td>
                <td>
                    <a href="editar.php?idAutor='.$row['idAutor'].'" title="Editar datos" class="btn btn-primary btn-sm mr-2"><i class="fa fa-edit"></i></a>
                    <a href="index.php?acc=delete&idAutor='.$row['idAutor'].'" title="Eliminar empleado" onclick="return confirm(\'&iquest;Esta seguro de borrar al empleado '.$row['nombre'].'?\')" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
                </td>
            </tr>
            ';
        }

        // Cerrando el resulset
        mysqli_free_result($sql);
    }

    return $data;
}

?>