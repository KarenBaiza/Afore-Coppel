<?php
session_start();
include "config.php";

header('Content-Type: application/json'); // importante para que JS reciba JSON

if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'admin')
{
    echo json_encode(['status'=>'error','mensaje'=>'No tienes permisos']);
    exit();
}

if(isset($_POST['id']))
{
    $id = intval($_POST['id']);

    if($id == $_SESSION['usuario_id'])
    {
        echo json_encode(['status'=>'error','mensaje'=>'No puedes eliminar tu propia cuenta']);
        exit();
    }

    $query = "DELETE FROM usuarios WHERE id=$id";
    if(mysqli_query($conn, $query))
    {
        echo json_encode(['status'=>'success','mensaje'=>'Usuario eliminado correctamente']);
    } 
    else 
    {
        // Mostrar el error real de MySQL
        echo json_encode(['status'=>'error','mensaje'=>'Error al eliminar usuario: '.mysqli_error($conn)]);
    }
} 
else 
{
    echo json_encode(['status'=>'error','mensaje'=>'ID de usuario no recibido']);
}
?>
