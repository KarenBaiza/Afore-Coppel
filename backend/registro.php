<?php
include "config.php";

// Validar método
if ($_SERVER["REQUEST_METHOD"] !== "POST") 
{
    echo "ERROR";
    exit;
}

// Recibir datos del formulario
$nombre     = $_POST["nombre"] ?? "";
$correo     = $_POST["correo"] ?? "";
$contraseña = $_POST["contraseña"] ?? "";
$rol        = $_POST["rol"] ?? "usuario";

// Validar campos vacíos
if ($nombre === "" || $correo === "" || $contraseña === "") 
{
    echo "ERROR";
    exit;
}

// Verificar si el correo ya existe
$sql  = "SELECT id FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) 
{
    echo "EXISTE";
    exit;
}

// Insertar usuario nuevo
$sql  = "INSERT INTO usuarios (nombre, correo, contraseña, rol) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nombre, $correo, $contraseña, $rol);

if ($stmt->execute()) 
{
    echo "OK";
} 
else 
{
    echo "ERROR";
}
?>
