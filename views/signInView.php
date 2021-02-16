<?php
$title = 'Connexion';
ob_start();
?>
<div class="container">
    <h4>Identifiez-vous !</h4>
    <form action="index.php?action=signIn" method="post" class="needs-validation" novalidate>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" required>
            <small id="emailHelp" class="form-text text-muted">Nous ne partagerons votre e-mail avec personne (c'est bien sûr faux)</small>
            <div class="invalid-feedback">
                Insérer svp un mail valide
            </div>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <div class="invalid-feedback">
                Insérer svp un mot de passe
            </div>
        </div>
        <button type="submit" class="btn btn-outline-success">Se connecter</button>
    </form>
    <p><a href="index.php?action=formSignUp">Pas encore inscrit? Faîtes-le en 2 clics</a></p>
</div>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<?php
$content = ob_get_clean();
require('template.php');