<?php
$title = 'Votre compte';
ob_start();
?>
<div class="container">
    <h4>Vos informations</h4>
    <table cellspacing="0" cellpadding="0" width="60%">
        <tr>
            <td><strong>Mail</strong></td>
            <td><?= $user->getMail() ?></td>
        </tr>
        <tr>
            <td><strong>Nom</strong></td>
            <td><?= $user->getFirstName() . ' ' . $user->getLastName() ?></td>
        </tr>
        <tr>
            <td><strong>Adresse</strong></td>
            <td><?= $user->getStreet() . ', ' . $user->getZipCode() . ', ' . $user->getCity() . ', ' . $user->getCountry() ?></td>
        </tr>
        <tr>
            <td><strong>Numéro de téléphone</strong></td>
            <td><?= $user->getPhone() ?></td>
        </tr>
    </table><br>
    <a class="btn btn-outline-primary" href="index.php?action=formUpdateUser&idUser=<?= $user->getIdUser() ?>" role="button">Modifier vos informations</a>
</div>
<?php
$content = ob_get_clean();
require('template.php');