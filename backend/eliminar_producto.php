<?php
include "config.php";

if(isset($_POST['id']))
{
    $id  = intval($_POST['id']);
    $sql = "DELETE FROM productos WHERE id = $id";

    if($conn->query($sql) === TRUE)
    {
        echo json_encode(["status"=>"success", "mensaje"=>"Producto eliminado"]);
    }
    else 
    {
        echo json_encode(["status"=>"error", "mensaje"=>$conn->error]);
    }
} 
else 
{
    echo json_encode(["status"=>"error", "mensaje"=>"ID no recibido"]);
}
?>
