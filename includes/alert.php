<link rel="stylesheet" href="css/styles-alert.css">
<?php
include 'config/config.php';

if (isset($_SESSION['mensaje'])):
?>
    <div id="mensaje-alerta" class="mensaje">
        <?= htmlspecialchars($_SESSION['mensaje']); ?>
    </div>

    <?php if (!empty($_SESSION['pedido_exitoso']) && isset($_SESSION['whatsapp_link'])): ?>
        <div class="alerta-exito">
            <a href="<?= $_SESSION['whatsapp_link'] ?>" target="_blank" class="btn-wa">Enviar pedido por WhatsApp</a>

            <script>
                setTimeout(() => {
                    window.open("<?= $_SESSION['whatsapp_link'] ?>", "_blank");
                }, 2000);
            </script>
        </div>
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