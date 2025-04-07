<link rel="stylesheet" href="/DulceAlHornoWebPedidos/css/styles-alert.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<?php
include __DIR__ .  '/../config/config.php'; // Incluye configuración y asegura que la sesión esté iniciada 

// Mostrar alerta
if (isset($_SESSION['mensaje'])):
?>
    <!-- Alerta general -->
    <div id="mensaje-alerta" class="mensaje">
        <?= htmlspecialchars($_SESSION['mensaje']); ?>
    </div>

    <!-- Alerta para pedido exitoso -->
    <?php if (!empty($_SESSION['pedido_exitoso']) && isset($_SESSION['whatsapp_link'])): ?>
        <div class="wa-float-bottom" id="wa-boton">
            <a href="<?= $_SESSION['whatsapp_link'] ?>" target="_blank" class="btn-wa">
                <i class="bi bi-whatsapp"></i> Enviar pedido por WhatsApp
            </a>
        </div>
    <?php endif; ?>

<?php
    unset($_SESSION['mensaje']);
    unset($_SESSION['pedido_exitoso']);
    unset($_SESSION['whatsapp_link']);
endif;
?>