function toggleMenu() {
    var menu = document.getElementById("menuContent");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

// Cierra el menú si se hace clic fuera
window.onclick = function(event) {
    if (!event.target.matches('.menu-btn')) {
        var dropdowns = document.getElementsByClassName("menu-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.style.display === "block") {
                openDropdown.style.display = "none";
            }
        }
    }
}
// estas lineas hace la validacion en el formulario de inicio desesion

        document.getElementById("loginForm").addEventListener("submit", function (event) {
            event.preventDefault();

            let usuario = document.getElementById("username").value;
            let contraseña = document.getElementById("password").value;
            let mensajeError = document.getElementById("errorMsg");

            // Simulación de credenciales correctas
            if (usuario === "admin" && contraseña === "1234") {
                alert("Inicio de sesión exitoso");
                window.location.href = "administrador.html"; // Redirigir a otra página
            } else {
                mensajeError.textContent = "Usuario o contraseña incorrectos";
            }
        });
        // logica para laopcion de recuperar contraseña
        document.getElementById("recuperarForm").addEventListener("submit", function(event) {
    event.preventDefault();
    const email = document.getElementById("emailRecuperacion").value;
    const errorMsg = document.getElementById("errorRecuperacion");

    // Simulación: Verificar si el email existe (en un caso real, esto se haría en el backend)
    const usuariosRegistrados = JSON.parse(localStorage.getItem("usuarios")) || [];
    const usuario = usuariosRegistrados.find(user => user.email === email);

    if (usuario) {
        // Simular envío de correo (en realidad, muestra un mensaje)
        alert(`Se ha enviado un enlace de recuperación a: ${email}\n(Simulación: Ver consola para detalles)`);
        console.log(`Enlace simulado: http://tudominio.com/reset-password?token=ABC123`);
        window.location.href = "inicio.html"; // Redirigir al inicio
    } else {
        errorMsg.textContent = "El correo no está registrado.";
    }
});
    