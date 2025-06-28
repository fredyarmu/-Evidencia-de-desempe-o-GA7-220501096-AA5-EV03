/* ————— MENÚ DESPLEGABLE ————— */
function toggleMenu () {
  const menu = document.getElementById('menuContent');
  if (menu) {
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
  }
}
window.addEventListener('click', e => {
  if (!e.target.matches('.menu-btn')) {
    document
      .querySelectorAll('.menu-content')
      .forEach(d => (d.style.display = 'none'));
  }
});

/* ————— LÓGICA PRINCIPAL CUANDO EL DOM ESTÁ LISTO ————— */
document.addEventListener('DOMContentLoaded', () => {
  // Elementos imprescindibles
  const loginForm    = document.getElementById('loginForm');
  const usuarioInput = document.getElementById('username');
  const passInput    = document.getElementById('password');
  const mensajeLogin = document.getElementById('mensajeLogin');

  if (!loginForm) {
    console.error('No se encontró #loginForm — revisa el HTML');
    return;
  }

  /* —— A) Validación y submit —— */
  loginForm.addEventListener('submit', e => {
    e.preventDefault();            // ⬅️ siempre cancelamos envío al servidor
    // Limpia mensajes
    mensajeLogin.textContent = '';
    usuarioInput.classList.remove('error-campo');
    passInput.classList.remove('error-campo');

    // Campos vacíos
    if (!usuarioInput.value.trim() || !passInput.value.trim()) {
      mensajeLogin.textContent = 'Por favor completa ambos campos.';
      if (!usuarioInput.value.trim()) usuarioInput.classList.add('error-campo');
      if (!passInput.value.trim())   passInput.classList.add('error-campo');
      return;
    }

    // Credenciales únicas permitidas
    if (
      usuarioInput.value.trim() === 'Barberos' &&
      passInput.value.trim() === 'Barberos2025**'
    ) {
      alert('Inicio de sesión exitoso');
      window.location.href = 'Empleados.html';   // asegúrate de que exista
      return;
    }

    // Cualquier otro par: error
    usuarioInput.classList.add('error-campo');
    passInput.classList.add('error-campo');
    mensajeLogin.textContent = 'Usuario o contraseña incorrectos.';
    mostrarModalError('Usuario o contraseña incorrectos.');
  });

  /* —— B) Mostrar errores recibidos por ?error=login —— */
  const params = new URLSearchParams(window.location.search);
  if (params.get('error') === 'login') {
    usuarioInput.classList.add('error-campo');
    passInput.classList.add('error-campo');
    mensajeLogin.textContent = 'Usuario o contraseña incorrectos.';
    mostrarModalError('Usuario o contraseña incorrectos.');
  }

  /* —— C) Recuperación de contraseña (si existe el form) —— */
  const recuperarForm = document.getElementById('recuperarForm');
  if (recuperarForm) {
    recuperarForm.addEventListener('submit', e => {
      e.preventDefault();
      const email    = document.getElementById('emailRecuperacion').value;
      const errorMsg = document.getElementById('errorRecuperacion');
      const users    = JSON.parse(localStorage.getItem('usuarios')) || [];
      const existe   = users.find(u => u.email === email);
      if (existe) {
        alert(
          `Se ha enviado un enlace de recuperación a: ${email}\n` +
          '(Simulación: ver consola)'
        );
        console.log(
          'Enlace simulado: http://tudominio.com/reset-password?token=ABC123'
        );
        window.location.href = 'inicio.html';
      } else {
        errorMsg.textContent = 'El correo no está registrado.';
      }
    });
  }
});

/* ————— MODAL GENÉRICO DE ERROR ————— */
function mostrarModalError (mensaje) {
  const modal = document.createElement('div');
  Object.assign(modal.style, {
    position: 'fixed',
    inset: 0,
    background: 'rgba(0,0,0,0.5)',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    zIndex: 9999
  });
  modal.innerHTML = `
    <div style="background:#fff;padding:30px 40px;border-radius:10px;
                max-width:90vw;box-shadow:0 2px 10px #0003;text-align:center;">
        <h3 style="color:#c00;margin-bottom:10px;">Error de inicio de sesión</h3>
        <p style="margin-bottom:20px;">${mensaje}</p>
        <button style="padding:8px 20px;background:#c00;color:#fff;border:none;
                       border-radius:5px;cursor:pointer;">Cerrar</button>
    </div>`;
  modal.querySelector('button').onclick = () => modal.remove();
  document.body.appendChild(modal);
}
