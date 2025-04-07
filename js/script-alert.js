// Ocultar mensaje de alerta después de 5 segundos
document.addEventListener('DOMContentLoaded', () => {
    const mensaje = document.getElementById("mensaje-alerta");
    if (mensaje) {
        setTimeout(() => {
            mensaje.style.display = "none";
        }, 5000);
    }

    const waBoton = document.getElementById("wa-boton");
    const waLink = waBoton?.querySelector("a")?.href;

    if (waBoton && waLink) {
        // Abrir WhatsApp en otra pestaña a los 2s
        setTimeout(() => {
            window.open(waLink, "_blank");
        }, 2000);

        // Ocultar el botón a los 10s
        setTimeout(() => {
            waBoton.style.display = "none";
        }, 10000);
    }
});
