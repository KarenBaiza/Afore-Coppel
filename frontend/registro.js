document.getElementById("registroForm").addEventListener("submit", async function(e) {
    e.preventDefault(); // Evita que el formulario haga submit normal

    let datos = new FormData(this);

    let respuesta = await fetch("../backend/registro.php", {
        method: "POST",
        body: datos
    });

    let text = await respuesta.text();

    if (text === "OK") {
        alert("✨ ¡Tu cuenta se registró con éxito! Bienvenida/o a Afore Coppel 💛");
        window.location.href = "registro.html"; // ejemplo
    } else {
        alert("Algo salió mal, revisa tus datos");
    }

});
