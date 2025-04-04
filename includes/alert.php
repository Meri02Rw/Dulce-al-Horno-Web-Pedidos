<link rel="stylesheet" href="css/styles-alert.css">
<?php
include 'config/config.php';
if (isset($_SESSION['mensaje'])):
?>
    <div id="mensaje-alerta" class="mensaje">
        <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
    </div>
    <script>
        setTimeout(() => {
            document.getElementById("mensaje-alerta").style.display = "none";
        }, 5000); // Desaparece después de 5 segundos
    </script>
<?php
    unset($_SESSION['mensaje']); // Borra el mensaje después de mostrarlo
endif;
?>
