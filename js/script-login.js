// Elementos
const modal = document.getElementById("modal");
const btnAbrirModal = document.getElementById("btnAbrirModal");
const btnCerrarModal = document.getElementById("cerrarModal");
const btnLogin = document.getElementById("btnLogin");
const btnRegistro = document.getElementById("btnRegistro");
const formLogin = document.getElementById("formLogin");
const formRegistro = document.getElementById("formRegistro");

// Abrir modal
btnAbrirModal.addEventListener("click", () => {
    modal.style.display = "flex";
});

// Cerrar modal
btnCerrarModal.addEventListener("click", () => {
    modal.style.display = "none";
});

// Cambiar a formulario de registro
btnRegistro.addEventListener("click", () => {
    formLogin.classList.add("oculto");
    formRegistro.classList.remove("oculto");
    btnLogin.classList.remove("activo");
    btnRegistro.classList.add("activo");
});

// Cambiar a formulario de inicio de sesión
btnLogin.addEventListener("click", () => {
    formRegistro.classList.add("oculto");
    formLogin.classList.remove("oculto");
    btnRegistro.classList.remove("activo");
    btnLogin.classList.add("activo");
});
