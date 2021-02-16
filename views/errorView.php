<?php
$title = 'Erreur';
ob_start();
?>
<div class="container">
    <h4 style="color: red"><?= $errorMessage ?></h4>
</div>
<?php
$content = ob_get_clean();
require('template.php');
