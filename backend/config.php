<?php
$host = "localhost";
$db   = "aforecoppel";   // tu base de datos
$user = "root";          // tu usuario de BD
$pass = "";              // tu contraseña de BD

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) 
{
    die("Conexión fallida: " . $conn->connect_error);
}
?>
