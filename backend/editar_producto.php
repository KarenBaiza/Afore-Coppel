<?php
include "config.php";
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD']==='POST')
    {
    if(!isset($_POST['id'], $_POST['sku'], $_POST['nombre'], $_POST['precio'], $_POST['descripcion']))
    {
        echo json_encode(["status"=>"error","mensaje"=>"Faltan datos del producto"]);
        exit;
    }

    $id          = intval($_POST['id']);
    $sku         = $conn->real_escape_string($_POST['sku']);
    $nombre      = $conn->real_escape_string($_POST['nombre']);
    $precio      = floatval($_POST['precio']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);

    $sql = "UPDATE productos SET sku='$sku', nombre='$nombre', precio='$precio', descripcion='$descripcion'";

    // Revisar si hay imagen nueva
    if(isset($_FILES['imagen']) && $_FILES['imagen']['name'] != '')
    {
        $imagenNombre = $_FILES['imagen']['name'];
        $imagenTmp    = $_FILES['imagen']['tmp_name'];
        move_uploaded_file($imagenTmp, "../imagenes/".$imagenNombre);
        $sql .= ", imagen='$imagenNombre'";
    }

    $sql .= " WHERE id=$id";

    if($conn->query($sql) === TRUE)
    {
        echo json_encode(["status"=>"success", "mensaje"=>"Producto actualizado"]);
    } 
    else 
    {
        echo json_encode(["status"=>"error", "mensaje"=>$conn->error]);
    }

    $conn->close();
}
?>
