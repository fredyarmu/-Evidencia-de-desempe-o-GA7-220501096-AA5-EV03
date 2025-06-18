// Menú desplegable
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
};

// Validación de inicio de sesión
document.getElementById("loginForm").addEventListener("submit", function (event) {
    event.preventDefault();

    let usuario = document.getElementById("username").value;
    let contraseña = document.getElementById("password").value;
    let mensajeError = document.getElementById("errorMsg");

    if (usuario === "admin" && contraseña === "1234") {
        alert("Inicio de sesión exitoso");
        window.location.href = "administrador.html";
    } else {
        mensajeError.textContent = "Usuario o contraseña incorrectos";
    }
});

// Recuperación de contraseña
document.getElementById("recuperarForm").addEventListener("submit", function(event) {
    event.preventDefault();
    
    const email = document.getElementById("emailRecuperacion").value;
    const errorMsg = document.getElementById("errorRecuperacion");

    const usuariosRegistrados = JSON.parse(localStorage.getItem("usuarios")) || [];
    const usuario = usuariosRegistrados.find(user => user.email === email);

    if (usuario) {
        alert(`Se ha enviado un enlace de recuperación a: ${email}\n(Simulación: Ver consola para detalles)`);
        console.log(`Enlace simulado: http://tudominio.com/reset-password?token=ABC123`);
        window.location.href = "inicio.html";
    } else {
        errorMsg.textContent = "El correo no está registrado.";
    }
});

