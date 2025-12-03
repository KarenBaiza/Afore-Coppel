document.getElementById("formAgregar").addEventListener("submit", function(e)
{
    e.preventDefault();

    let datos = new FormData(this);

    fetch("../backend/agregar_producto.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        const mensaje = document.getElementById("mensaje");
        if(data.status === "success"){
            // Mostrar mensaje y redirigir al panel en la sección productos
            alert(data.mensaje);
            window.location.href = "panel_admin.html#productos";
        } else {
            mensaje.innerHTML = `<div class="alert alert-error">${data.mensaje}</div>`;
        }
    })
    .catch(err => {
        document.getElementById("mensaje").innerHTML = `<div class="alert alert-error">Error de conexión</div>`;
        console.error(err);
    });
});
