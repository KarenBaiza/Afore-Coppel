// ====================================================================================
// ==================== PANEL_ADMIN.JS SIN LOGS ======================================
// ====================================================================================

document.addEventListener("DOMContentLoaded", () => {

    // ===== Secciones =====
    const dashboard = document.getElementById('dashboard');
    const productos = document.getElementById('productos');
    const usuarios = document.getElementById('usuarios');

    // ===== Sidebar links =====
    const dashboardLink = document.getElementById('dashboard-link');
    const productosLink = document.getElementById('productos-link');
    const usuariosLink = document.getElementById('usuarios-link');

    function mostrarSeccion(seccion) {
        dashboard.style.display = 'none';
        productos.style.display = 'none';
        usuarios.style.display = 'none';
        seccion.style.display = 'block';
    }

    // ===== Event listeners sidebar =====
    dashboardLink.addEventListener('click', e => { 
        e.preventDefault(); 
        mostrarSeccion(dashboard); 
    });

    productosLink.addEventListener('click', e => { 
        e.preventDefault(); 
        mostrarSeccion(productos); 
        cargarProductos();
    });

    usuariosLink.addEventListener('click', e => { 
        e.preventDefault(); 
        mostrarSeccion(usuarios); 
        cargarUsuarios(); 
    });

    // ===== Botón Agregar Producto =====
    const productosH1 = document.querySelector('#productos h1');
    if(productosH1){
        const btnAgregar = document.createElement('button');
        btnAgregar.textContent = "Agregar Producto";
        btnAgregar.style = "padding:10px; background-color:#FFD700; border:none; cursor:pointer; margin-bottom:15px;";
        btnAgregar.id = "btn-agregar";
        productosH1.after(btnAgregar);

        btnAgregar.addEventListener('click', () => {
            window.location.href = '/Afore-Coppel/frontend/agregar_producto.html';
        });
    }

    // ===== Revisar si viene de editar/URL hash =====
    const urlParams = new URLSearchParams(window.location.search);
    const hash = window.location.hash;
    const productoEditadoId = urlParams.get('id');

    if(hash === "#productos" && productoEditadoId){
        mostrarSeccion(productos);
        cargarProductos(productoEditadoId);
    }

    // ===== Cargar todos los datos al inicio =====
    cargarProductos();
    cargarUsuarios();
});

// =======================================================================
// ================== FUNCIONES AJAX DE PRODUCTOS ========================
// =======================================================================
function cargarProductos(productoEditadoId = null) {
    fetch('/Afore-Coppel/backend/panel_admin.php?accion=productos')
    .then(res => res.json())
    .then(data => {
        const contenedor = document.getElementById('contenedor-productos');
        contenedor.innerHTML = '';
        data.forEach(p => {
            const div = document.createElement('div');
            div.classList.add('producto');
            div.dataset.id = p.id;
            div.innerHTML = `
                <img src="/Afore-Coppel/imagenes/${p.imagen || 'ima1.jpg'}" alt="${p.nombre}">
                <p>Nombre: ${p.nombre}</p>
                <p>Precio: $${p.precio}</p>
                <div class="producto-botones">
                    <a href="#" class="btn-editar">Editar</a>
                    <a href="#" class="btn-borrar">Borrar</a>
                </div>
            `;
            contenedor.appendChild(div);

            // ===== Resaltar producto editado =====
            if(productoEditadoId && p.id == productoEditadoId){
                div.style.border = "2px solid green";
                div.scrollIntoView({behavior: "smooth", block: "center"});
            }

            // ===== Editar Producto =====
            div.querySelector('.btn-editar').addEventListener('click', e => {
                e.preventDefault();
                window.location.href = `/Afore-Coppel/frontend/editar_producto.html?id=${p.id}`;
            });

            // ===== Borrar Producto =====
            div.querySelector('.btn-borrar').addEventListener('click', e => {
                e.preventDefault();
                if(confirm(`¿Eliminar el producto "${p.nombre}"?`)){
                    fetch('/Afore-Coppel/backend/eliminar_producto.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `id=${p.id}`
                    })
                    .then(res => res.json())
                    .then(resp => {
                        alert(resp.mensaje);
                        cargarProductos();
                    })
                    .catch(err => console.error(err));
                }
            });
        });

        // ===== Actualizar contador =====
        const totalProductos = document.getElementById('total-productos');
        if(totalProductos) totalProductos.textContent = data.length;
    })
    .catch(err => console.error("Error cargando productos:", err));
}

// =======================================================================
// ================== FUNCIONES AJAX DE USUARIOS =========================
// =======================================================================
function cargarUsuarios() {
    fetch('/Afore-Coppel/backend/panel_admin.php?accion=usuarios')
    .then(res => res.json())
    .then(data => {
        const tbody = document.querySelector('#tabla-usuarios tbody');
        tbody.innerHTML = '';
        data.forEach(u => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${u.id}</td>
                <td>${u.nombre}</td>
                <td>${u.correo}</td>
                <td>${u.rol}</td>
                <td>
                    <button class="btn-editar-usuario">Editar</button>
                    <button class="btn-borrar-usuario">Borrar</button>
                </td>
            `;
            tbody.appendChild(tr);

            tr.querySelector('.btn-borrar-usuario').addEventListener('click', () => {
                if(confirm(`¿Eliminar usuario "${u.nombre}"?`)){
                    fetch('/Afore-Coppel/backend/eliminar_usuario.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `id=${u.id}`
                    })
                    .then(res => res.json())
                    .then(resp => {
                        alert(resp.mensaje);
                        cargarUsuarios();
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Error al eliminar usuario");
                    });
                }
            });

            tr.querySelector('.btn-editar-usuario').addEventListener('click', () => {
                alert('Función de editar usuario aún no implementada');
            });
        });

        // ===== Actualizar contador =====
        const totalUsuarios = document.getElementById('total-usuarios');
        if(totalUsuarios) totalUsuarios.textContent = data.length;
    })
    .catch(err => console.error("Error cargando usuarios:", err));
}
