<?php
include "config.php";
header('Content-Type: application/json');

if(isset($_GET['id']))
{
    $id  = intval($_GET['id']);
    $res = $conn->query("SELECT * FROM productos WHERE id=$id");
    
    if($res->num_rows > 0)
    {
        $producto = $res->fetch_assoc();
        echo json_encode([
            "status" => "success",
            "data" => $producto
        ]);
    } 
    else 
    {
        echo json_encode([
            "status" => "error",
            "mensaje" => "Producto no encontrado"
        ]);
    }
} 
else 
{
    echo json_encode([
        "status" => "error",
        "mensaje" => "ID no recibido"
    ]);
}
?>
