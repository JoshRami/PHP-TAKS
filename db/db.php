<?php
//Incluimos el contenido de las constantes de conexion
require_once "config.php";

// Creamos la cadena de conexion al servidor de bases de datos
$con=mysqli_connect(host, user, pass, dbname, port);

//Evaluamos que la conexion no nos retorne codigos de error
if($con->connect_errno)
{
    die("Lo sentimos, no se ha podido conectar con MySQL/MariaDB: ".mysqli_error($con));
}
else
{
    //Seleccionamos la base de datos a la que nos conectaremos por defecto
    $db=mysqli_select_db($con, dbname);
    if($db==0)
    {
        die("Lo sentimos, no se ha podido conectar con la base de datos: ".dbname);
    }
}
?>