// Función para cargar el banner
function cargarBanner() {
    fetch('includes/banner.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('banner-container').innerHTML = data;
        });
}

// Función para cargar el footer
function cargarFooter() {
    fetch('includes/footer.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('footer-container').innerHTML = data;
        });
}

// Llamar a las funciones al cargar la página
window.onload = function() {
    cargarBanner();
    cargarFooter();
};


function toggleMenu() {
    const menu = document.querySelector('.menu');
    const button = document.querySelector('.menu-toggle');

    menu.classList.toggle('active');
    button.classList.toggle('active');
}
