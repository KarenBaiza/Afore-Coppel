<?php
session_start();
include "config.php"; // Tu conexión a la base de datos

if(isset($_POST['correo']) && isset($_POST['contraseña']))
{
    $correo     = mysqli_real_escape_string($conn, $_POST['correo']);
    $contraseña = $_POST['contraseña'];

    $query = "SELECT * FROM usuarios WHERE correo='$correo'";
    $res   = mysqli_query($conn, $query);

    if($res && mysqli_num_rows($res) > 0)
    {
        $usuario = mysqli_fetch_assoc($res);

        if(trim($usuario['contraseña']) === trim($contraseña))
        {
            $_SESSION['usuario_id']     = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol']    = $usuario['rol'];

            if($usuario['rol'] === 'admin')
            {
                echo "<script>
                        alert('¡Bienvenido, ".$usuario['nombre']."! Redirigiendo a panel de admin...');
                        window.location='../frontend/panel_admin.html';
                      </script>";
            } 
            else 
            {
                echo "<script>
                        alert('¡Bienvenido, ".$usuario['nombre']."! Redirigiendo a panel de usuario...');
                        window.location='../frontend/panel_usuario.html';
                      </script>";
            }
        } 
        else 
        {
            echo "<script>alert('Contraseña incorrecta'); window.location='login.html';</script>";
        }

    } 
    else 
    {
        echo "<script>alert('Correo no encontrado'); window.location='login.html';</script>";
    }

} 
else 
{
    header("Location: login.html");
    exit();
}
?>
