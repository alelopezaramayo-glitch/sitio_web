<?php
/**
 * footer.php — pie de página y scripts de JavaScript.
 *
 * Variable opcional:
 *   $scripts_extra (array) Scripts propios de la página, ej: ['javascript.js'].
 */
$scripts_extra = $scripts_extra ?? [];
?>
<footer class="site-footer"><p>© <?= date('Y') ?> <?= htmlspecialchars(APP_OWNER) ?></p></footer>
<?php foreach ($scripts_extra as $script): ?>
<script src="<?= htmlspecialchars($script) ?>"></script>
<?php endforeach; ?>
</body>
</html>
