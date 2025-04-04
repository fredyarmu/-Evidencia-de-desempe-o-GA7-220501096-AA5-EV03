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
    