<?php
// eliminar_usuario.php
session_start();
header('Content-Type: application/json');

// Verificar sesión y rol admin
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin')
{
    echo json_encode(['status' => 'error', 'mensaje' => 'No autorizado.']);
    exit;
}

include "config.php"; // conexión a la base de datos

// Verificar id
if (!isset($_POST['id']) || !is_numeric($_POST['id']))
{
    echo json_encode(['status' => 'error', 'mensaje' => 'ID inválido.']);
    exit;
}

$id = intval($_POST['id']);

try {
    $conn->begin_transaction();

    // Eliminar usuario
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows === 0) 
    {
        $stmt->close();
        $conn->rollback();
        echo json_encode(['status' => 'error', 'mensaje' => 'Usuario no encontrado o ya eliminado.']);
        exit;
    }

    $stmt->close();
    $conn->commit();
    echo json_encode(['status' => 'success', 'mensaje' => 'Usuario eliminado correctamente.']);

} 
catch (Exception $e) 
{
    if ($conn->connect_errno == 0) $conn->rollback();
    echo json_encode(['status' => 'error', 'mensaje' => 'Error al eliminar: ' . $e->getMessage()]);
}
?>
