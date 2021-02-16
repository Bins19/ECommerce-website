<?php
$title = 'Modifier mes informations';
ob_start();
?>
    <div class="container">
        <h4>Modifier vos informations !</h4>
        <form action="index.php?action=updateUser&idUser=<?= $user->getIdUser() ?>" method="post">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input readonly type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?= $user->getMail() ?>">
            </div>
            <div class="form-group">
                <label for="firstName">Prénom</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?= $user->getFirstName() ?>">
            </div>
            <div class="form-group">
                <label for="lastName">Nom</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?= $user->getLastName() ?>">
            </div>
            <div class="form-group">
                <label for="street">Rue</label>
                <input type="text" class="form-control" id="street" name="street" value="<?= $user->getStreet() ?>">
            </div>
            <div class="form-group">
                <label for="zipCode">Code postal</label>
                <input type="text" class="form-control" id="zipCode" name="zipCode" value="<?= $user->getZipCode() ?>">
            </div>
            <div class="form-group">
                <label for="city">Ville</label>
                <input type="text" class="form-control" id="city" name="city" value="<?= $user->getCity() ?>">
            </div>
            <div class="form-group">
                <label for="country">Pays</label>
                <input type="text" class="form-control" id="country" name="country" value="<?= $user->getCountry() ?>">
            </div>
            <div class="form-group">
                <label for="phone">Numéro de téléphone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= $user->getPhone() ?>">
            </div>
            <button type="submit" class="btn btn-outline-success">Modifier</button>
        </form>
    </div>
<?php
$content = ob_get_clean();
require('template.php');