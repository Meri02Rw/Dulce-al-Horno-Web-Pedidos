<link rel="stylesheet" href="css/styles-alert.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<?php
include 'config/config.php';

if (isset($_SESSION['mensaje'])):
?>
    <div id="mensaje-alerta" class="mensaje">
        <?= htmlspecialchars($_SESSION['mensaje']); ?>
    </div>

    <?php if (!empty($_SESSION['pedido_exitoso']) && isset($_SESSION['whatsapp_link'])): ?>
        <div class="wa-float-bottom" id="wa-boton">
            <a href="<?= $_SESSION['whatsapp_link'] ?>" target="_blank" class="btn-wa">
                <i class="bi bi-whatsapp"></i> Enviar pedido por WhatsApp
            </a>
        </div>

        <script>
            setTimeout(() => {
                window.open("<?= $_SESSION['whatsapp_link'] ?>", "_blank");
            }, 2000);

            setTimeout(() => {
                document.getElementById("wa-boton").style.display = "none";
            }, 10000);
        </script>
    <?php endif; ?>

    <script>
        setTimeout(() => {
            document.getElementById("mensaje-alerta").style.display = "none";
        }, 5000);
    </script>

<?php
    unset($_SESSION['mensaje']);
    unset($_SESSION['pedido_exitoso']);
    unset($_SESSION['whatsapp_link']);
endif;
?>