document.getElementById("loginForm").addEventListener("submit", async function(event) {
    event.preventDefault();

    const correo = document.getElementById("correo").value;
    const contraseña = document.getElementById("contraseña").value;

    const datos = new FormData();
    datos.append("correo", correo);
    datos.append("contraseña", contraseña);

    let respuesta = await fetch("../backend/login.php", {
        method: "POST",
        body: datos
    });

    let resultado = await respuesta.text();

    if (resultado === "OK") {
        alert("Bienvenida Karen ❤️");
        window.location.href = "login.html"; // ejemplo
    } else {
        alert("Correo o contraseña incorrectos");
    }
});
