document.addEventListener("DOMContentLoaded", () => {

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    if (!id) {
        alert("No se recibió el ID del producto.");
        return;
    }

    // ===== CARGAR DATOS DEL PRODUCTO =====
    fetch(`../backend/obtener_producto.php?id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                const p = data.data;
                document.getElementById("producto-id").value = p.id;
                document.getElementById("sku").value = p.sku;
                document.getElementById("nombre").value = p.nombre;
                document.getElementById("precio").value = p.precio;
                document.getElementById("descripcion").value = p.descripcion;
            } else {
                alert("Error al cargar el producto: " + data.mensaje);
            }
        })
        .catch(err => alert("No se pudo conectar al servidor"));

    // ===== ENVIAR FORMULARIO =====
    document.getElementById("formEditar").addEventListener("submit", function(e){
        e.preventDefault();

        const formData = new FormData(this);

        fetch("../backend/editar_producto.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                // ===== ALERTA DE CONFIRMACIÓN =====
                alert("Producto editado correctamente");

                // ===== REDIRIGIR AL PANEL ADMIN Y SECCIÓN PRODUCTOS =====
                window.location.href = `panel_admin.html#productos&id=${id}`;
            } else {
                alert("Error al guardar cambios: " + data.mensaje);
            }
        })
        .catch(err => alert("Error al guardar los cambios"));
    });

});
