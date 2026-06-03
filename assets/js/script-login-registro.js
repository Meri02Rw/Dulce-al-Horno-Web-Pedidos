// Elementos
const modal = document.getElementById("modal");
const btnAbrirModal = document.getElementById("btnAbrirModal");
const btnCerrarModal = document.getElementById("cerrarModal");
const formLogin = document.getElementById("formLogin");
const formRegistro = document.getElementById("formRegistro");

// Abrir modal mostrando solo el login por defecto
btnAbrirModal.addEventListener("click", () => {
    modal.style.display = "flex";
    formLogin.classList.remove("oculto");
    formRegistro.classList.add("oculto");
});

// Cerrar modal
btnCerrarModal.addEventListener("click", () => {
    modal.style.display = "none";
});

// Cambiar a formulario de registro
btnRegistro.addEventListener("click", () => {
    formLogin.classList.add("oculto");
    formRegistro.classList.remove("oculto");
});

// Cambiar a formulario de inicio de sesión
btnLogin.addEventListener("click", () => {
    formRegistro.classList.add("oculto");
    formLogin.classList.remove("oculto");
});
