document.addEventListener('DOMContentLoaded', () => {
    const contenedor = document.getElementById('contenedor-productos');

    fetch('../backend/panel_usuario.php')
        .then(response => response.json())
        .then(data => {
            contenedor.innerHTML = '';
            if(data.length === 0){
                contenedor.innerHTML = "<p>No hay productos disponibles por ahora.</p>";
                return;
            }

            data.forEach(producto => {
                const div = document.createElement('div');
                div.className = 'producto';
                div.innerHTML = `
                    <img src="../imagenes/${producto.imagen || 'ima1.jpg'}" alt="${producto.nombre}">
                    <p>Nombre: ${producto.nombre}</p>
                    <p>Precio: $${parseFloat(producto.precio).toFixed(2)}</p>
                    <a class="boton-contacto" href="https://wa.me/526677852219?text=¡Hola!%20Estoy%20interesado%20en el producto ${encodeURIComponent(producto.nombre)}">Contactar</a>
                `;
                contenedor.appendChild(div);
            });
        })
        .catch(error => {
            console.error('Error al cargar productos:', error);
            contenedor.innerHTML = "<p>Error al cargar productos.</p>";
        });
});
