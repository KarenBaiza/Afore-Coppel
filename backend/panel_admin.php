<?php
session_start();
include "config.php"; // conexión a la base de datos

// ===== Validar que sea admin =====
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'admin')
{
    header("Location: ../frontend/login.html");
    exit();
}

// ===== Manejo de AJAX =====
if(isset($_GET['accion'])) 
{
    $accion = $_GET['accion'];

    switch($accion) 
    {
        case 'productos':
            $res       = mysqli_query($conn, "SELECT * FROM productos ORDER BY id ASC");
            $productos = [];
            while($row = mysqli_fetch_assoc($res)) 
            {
                $productos[] = $row;
            }
            echo json_encode($productos);
            exit();

        case 'usuarios':
            $res      = mysqli_query($conn, "SELECT id, nombre, correo, rol FROM usuarios ORDER BY id ASC");
            $usuarios = [];
            while($row = mysqli_fetch_assoc($res)) 
            {
                $usuarios[] = $row;
            }
            echo json_encode($usuarios);
            exit();

        case 'logs':
            $res = mysqli_query($conn, "
                SELECT l.id, l.accion, p.nombre AS producto, u.nombre AS admin, l.fecha
                FROM logs l
                LEFT JOIN productos p ON l.producto_id = p.id
                LEFT JOIN usuarios u ON l.usuario_id = u.id
                ORDER BY l.fecha DESC
            ");
            $logs = [];
            while($row = mysqli_fetch_assoc($res)) 
            {
                $logs[] = $row;
            }
            echo json_encode($logs);
            exit();

        default:
            echo json_encode(['error'=>'Acción no válida']);
            exit();
    }
}

// ===== Si no es AJAX, redirigir al HTML del panel =====
header("Location: ../frontend/panel_admin.html");
exit();
?>
