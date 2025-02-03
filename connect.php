<?php
// Parámetros de conexión a la base de datos
$host = "localhost"; // Dirección del servidor MySQL (por lo general localhost)
$usuario = "root";   // Usuario (por defecto "root" en MySQL)
$password = "";      // Contraseña (déjala vacía si no tiene)
$baseDeDatos = "blog_db"; // Nombre de la base de datos

// Crear la conexión
$conexion = new mysqli($host, $usuario, $password, $baseDeDatos);

// Verificar si hubo un error en la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
} else {
    /*echo "Conexión exitosa a la base de datos '<b>$baseDeDatos</b>'";*/
}
