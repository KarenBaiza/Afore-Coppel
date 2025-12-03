<?php
session_start();
include "config.php";

// Validar usuario
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'usuario')
{
    header("Location: ../frontend/login.html");
    exit();
}

$sql    = "SELECT * FROM productos ORDER BY id ASC";
$result = $conn->query($sql);

$productos = [];
if ($result->num_rows > 0) 
{
    while($row = $result->fetch_assoc()) 
    {
        $productos[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($productos);

$conn->close();
?>
