<?php
include "config.php"; // tu conexión a la DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
    $sku         = $_POST['sku'];
    $nombre      = $_POST['nombre'];
    $precio      = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    // Guardar imagen
    $imagenNombre = $_FILES['imagen']['name'];
    $imagenTmp    = $_FILES['imagen']['tmp_name'];
    $ruta         = "../imagenes/" . $imagenNombre;
    move_uploaded_file($imagenTmp, $ruta);

    $sql = "INSERT INTO productos (sku, nombre, precio, descripcion, imagen) 
            VALUES ('$sku', '$nombre', '$precio', '$descripcion', '$imagenNombre')";
    
    if ($conn->query($sql) === TRUE) 
    {
        echo json_encode(["status"=>"success", "mensaje"=>"Producto agregado"]);
    } 
    else 
    {
        echo json_encode(["status"=>"error", "mensaje"=>$conn->error]);
    }
}
?>
